<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCsvArchiveRequest;
use App\Http\Requests\UpdateCsvArchiveRequest;
use App\Models\CsvArchive;

class CsvArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreCsvArchiveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCsvArchiveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CsvArchive  $csvArchive
     * @return \Illuminate\Http\Response
     */
    public function show(CsvArchive $csvArchive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CsvArchive  $csvArchive
     * @return \Illuminate\Http\Response
     */
    public function edit(CsvArchive $csvArchive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCsvArchiveRequest  $request
     * @param  \App\Models\CsvArchive  $csvArchive
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCsvArchiveRequest $request, CsvArchive $csvArchive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CsvArchive  $csvArchive
     * @return \Illuminate\Http\Response
     */
    public function destroy(CsvArchive $csvArchive)
    {
        //
    }
}
