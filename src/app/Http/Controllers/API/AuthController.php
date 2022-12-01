<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Image;
use App\Models\Booth;
use App\Models\Invite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mail;
use Validator;

class AuthController extends BaseController
{
    public function getUsers(){
        return User::all();
    }
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        { 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['fullname'] =  $user->fullname;
            $success['nickname'] =  $user->nickname;
            $success['phone_number'] =  $user->phone_number;
            $success['avatar'] =  Image::where('imageable_id',$user->id)
                                    ->where('imageable_type','App\Models\User')
                                    ->first();
            $user->load('booth');
            $success['booth'] =  $user->booth->id;
            $user->load('role');
            $success['role'] =  $user->role->name;
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else
        {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    /**
     * edit profile api.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request)
    {
        try{
            $user = Auth::user();
            if($request->has('nickname')){
                $user->update(['nickname'=>$request->nickname]);
            }
            if($request->has('fullname')){
                $user->update(['fullname'=>$request->fullname]);
            }
            if($request->has('phone_number')){
                $user->update(['phone_number'=>$request->phone_number]);
            }
            if ($request->hasFile('avatar')) {
                $image = Image::where('imageable_id',$user->id)
                            ->where('imageable_type','App\Models\User')
                            ->first();
                if(strlen($image) > 0){
                    $element = explode("/", $image->link);
                    $path = 'images/avatars/'.$element[5];
                    Storage::disk('s3')->delete($path);
                }
                $link = Storage::disk('s3')->put('images/avatars', $request->file('avatar'));
                $link = Storage::disk('s3')->url($link);
                $image->update([
                    'name' => $user->name.'_avatar',
                    'imageable_id'=> $user->id,
                    'imageable_type' => 'App\Models\User',
                    'link' => $link,
                    'created_at' =>  \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
            $user->load('images');
            $response = [
                'data' => $user
            ];
            return response()->json($response, 200);
        }
        catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * delete profile api.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteProfile(User $user)
    {
        $current = Auth::user();
        if($current->role_id === User::ROLE_ADMIN){
            try{
                $user->delete();
            }
            catch(Exception $e){
                return response()->json(['message' => $e->getMessage()], 400);
            }
            return response()->json(['message' => "Delete User Successfully"], 200);
        }
        else{
            return response()->json(['message' => "Permission denied"], 403);
        }
    }

    /**
     * invite api
     *
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request)
    {    
        Validator::make($request->all(),[
            'email' => 'required|email|unique:users',
            'name' => 'required',
        ]);
        if(Invite::where('email',$request->email)->first()){
            return response()->json(['message' => "Already invited this person!"], 404);
        }
        
        $current = Auth::user();
        if($current->role_id === User::ROLE_ADMIN){
            // validate the incoming request data
            do {
                //generate a random string using Laravel's str_random helper
                $token = Str::random(16);
                $password = Str::random(16);
            } //check if the token already exists and if it does, try again
            while (Invite::where('token', $token)->first());
            //create a new invite record
            $invite = Invite::create([
                'email' => $request->get('email'),
                'token' => $token,
                'password' => $password
            ]);
            
            $message="";
            $message.="<h1>Hi ".$request->name."</h1>";
            $message.="<p>Our admin invited you to our website</p>";
            $message.="<h2>Please verify <a href='http://www.frontend.com/verify/".$token."'>Verify</a> </h2>";
            $message.="<h3>Your password is: ".$password.", please change it as soon as possible! </h3>";
            $data = 
            [
                'subject' => "Register Validation",
                'to'      => $request->email,
            ];
            // send the email
            Mail::send(array(), $data, function ($msg) use ($message,$data) 
            {
            $msg->to($data['to'])->subject($data['subject'])
            ->html($message);
            });
            // redirect back where we came from
            return response()->json(['message', 'verification request sent'], 200);
        }
        else{
            return response()->json(['message' => "Permission denied"], 403);
        }
    }
    /**
     * accept register request api
     *
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return $this->sendResponse('','User logout successfully.');
        }
        catch (Exceptions $e){
            return $this->sendError('Error.', ['error'=>$e]);
        }
    }
    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return $this->sendResponse('','User logout successfully.');
        }
        catch (Exceptions $e){
            return $this->sendError('Error.', ['error'=>$e]);
        }
    }
}
