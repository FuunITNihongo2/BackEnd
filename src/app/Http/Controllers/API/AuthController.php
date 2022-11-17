<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
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
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else
        { 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
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
        ]);
        // validate the incoming request data
        do {
            //generate a random string using Laravel's str_random helper
            $token = str_random();
            $password = str_random();
        } //check if the token already exists and if it does, try again
        while (Invite::where('token', $token)->first());
        //create a new invite record
        $invite = Invite::create([
            'email' => $request->get('email'),
            'token' => $token,
            'password' => $password
        ]);
        // send the email
        Mail::to($request->get('email'))->send(new InviteCreated($invite));
        // redirect back where we came from
        return ['status', 'verification request sent'];
    }
    /**
     * accept api
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
