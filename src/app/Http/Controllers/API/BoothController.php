<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Models\Image;
use App\Http\Requests\StoreBoothRequest;
use App\Http\Requests\UpdateBoothRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoothController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booths = Booth::whereNotNull('owner_id')
                    ->where('active_state',true)
                    ->orderBy('total_orders')
                    ->get()
                    ->load('images');
        $response = [
            'list of booths' => $booths
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBoothRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBoothRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Http\Response
     */
    public function show(Booth $booth)
    {
        $booth->load('menus','menus.items','images');
        $response = [
            'booth' => $booth,
            // 'menu' => $booth->menus,
            // 'items' => $booth->menus->items
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Http\Response
     */
    public function showItem(Booth $booth)
    {
        $booth->load('menus','menus.items','menus.items.images');
        $response = [
            'items' => $booth->menus->items
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBoothRequest  $request
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booth $booth)
    {
        try{
            if ($booth){
                $booth->load('images');
                if($request->has('name')){
                    $booth->update(['name'=>$request->name]);
                }
                if($request->has('address')){
                    $booth->update(['address'=>$request->address]);
                }
                if($request->has('active_state')){
                    $booth->update(['active_state'=>$request->active_state]);
                }
                if ($request->hasFile('image')) {
                    $image = Image::where('imageable_id',$booth->id)
                                ->where('imageable_type','App\Models\Booth')
                                ->first();
                    if(strlen($image) > 0){
                        $element = explode("/", $image->link);
                        $path = 'images/booths/'.$element[5];
                        Storage::disk('s3')->delete($path);
                    }
                    $link = Storage::disk('s3')->put('images/booths', $request->file('image'));
                    $link = Storage::disk('s3')->url($link);
                    $image->update([
                        'name' => $booth->name.'_image',
                        'imageable_id'=> $booth->id,
                        'imageable_type' => 'App\Models\Booth',
                        'link' => $link,
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                }
                $response = [
                    'data' => $booth
                ];
                return response()->json($response, 200);
            }
            else{
                return response()->json(['message' => "Can't find user"], 404);
            }
        }
        catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booth $booth)
    {
        //
    }
}
