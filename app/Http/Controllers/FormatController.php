<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormatRequest;
use App\Http\Requests\UpdateFormatRequest;
use App\Models\Format;

use Illuminate\Support\Facades\Storage;

class FormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $json_str = Storage::get('json_data.json');
        //$json_str = file_get_contents('people.json');
        $items = json_decode($json_str, false);

        return view('start', compact('items'));
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
     * @param  \App\Http\Requests\StoreFormatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormatRequest $request)
    {
        $json_str = Storage::get('json_data.json');
        //$json_str = file_get_contents('people.json');
        $items = json_decode($json_str, false);

        return view('start', compact('items'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Format  $format
     * @return \Illuminate\Http\Response
     */
    public function show(Format $format)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Format  $format
     * @return \Illuminate\Http\Response
     */
    public function edit(Format $format)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormatRequest  $request
     * @param  \App\Models\Format  $format
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormatRequest $request, Format $format)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Format  $format
     * @return \Illuminate\Http\Response
     */
    public function destroy(Format $format)
    {
        //
    }



    public function next(StoreFormatRequest $request)
    {
        dd($request);
    }
}
