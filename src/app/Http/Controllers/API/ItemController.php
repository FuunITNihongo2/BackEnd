<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::whereNotNull('menu_id')
                    ->orderBy('price')
                    ->get()
                    ->load('images','menu','menu.booth')
                    ->load('menu.booth.images');
        $response = [
            'listOfItems' => $items
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        $data = $request->only(['name', 'price', 'description', 'menu_id']);
        // pass the validate
        try {
            $item = Item::create([
                'name' => $data['name'],
                'price' => $data['price'],
                'description' => $data['description'],
                'menu_id' => $data['menu_id'],
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
            $link = Storage::disk('s3')->put('images/items', $request->file('image'));
            $link = Storage::disk('s3')->url($link);
            if(
                Image::insert([
                    'name' => $item->name.'_image',
                    'imageable_id'=> $item->id,
                    'imageable_type' => 'App\Models\Item',
                    'link' => $link,
                    'created_at' =>  \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ])
            ){
                return ['message','success'];
            }
            //if insert fail
            return response()->json(['message', 'Something went wrong'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 424);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        if ($item){
            $item->load('images');
            if($request->has('name')){
                $item->update(['name'=>$request->name]);
            }
            if($request->has('price')){
                $item-->update(['price'=>$request->price]);
            }
            if($request->has('description')){
                $item-->update(['description'=>$request->description]);
            }
            if($request->has('updated_at')){
                $item-->update(['updated_at'=>$request->updated_at]);
            }
            if($request->has('created_at')){
                $item-->update(['created_at'=>$request->created_at]);
            }

            if ($request->hasFile('image')) {
                $image = Image::where('imageable_id',$item->id)
                            ->where('imageable_type','App\Models\Item')
                            ->first();
                if(strlen($image) > 0){
                    $element = explode("/", $image->link);
                    $path = 'images/items/'.$element[5];
                    Storage::disk('s3')->delete($path);
                }
                $link = Storage::disk('s3')->put('images/items', $request->file('image'));
                $link = Storage::disk('s3')->url($link);
                $image->update([
                    'name' => $booth->name.'_image',
                    'imageable_id'=> $booth->id,
                    'imageable_type' => 'App\Models\Item',
                    'link' => $link,
                    'created_at' =>  \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
            $response = [
                'data' => $item
            ];
            return response()->json($response, 200);
        }
        else{
            return response()->json(['message' => "Item not found!"], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if($item){
            $item->delete();
            $items = Item::all();  
        }
        else 
            return response()->json(['message'=>'Item not found!'], 404);
        return response()->json($items);
    }

}
