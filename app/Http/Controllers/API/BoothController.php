<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Http\Requests\StoreBoothRequest;
use App\Http\Requests\UpdateBoothRequest;

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
                    ->get();
        $response = [
            'list of booths' => $booths
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Http\Response
     */
    public function edit(Booth $booth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBoothRequest  $request
     * @param  \App\Models\Booth  $booth
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoothRequest $request, Booth $booth)
    {
        //
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
