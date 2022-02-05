<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCsvArchiveRequest;
use App\Http\Requests\UpdateCsvArchiveRequest;
use App\Models\CsvArchive;
use App\Models\Format;

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
    // public function show(CsvArchive $csvArchive)
    // {
    //     //
    // }

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

    public function loadCsv($path)
    {
        $csv = array_map('str_getcsv', file($path));
        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv); # remove column header

        Format::truncate();
        foreach ($csv as $item) {
            Format::create($item);
        }
    }

    public function show(CsvArchive $csvArchive)
    {
        $name = $csvArchive->name;
        
        $path = storage_path('/app/csv/' . $csvArchive->id);
        $csv = array_map('str_getcsv', file($path));

        return view('show_csv', compact('csv', 'name'));
    }

    public function attiva(CsvArchive $csvArchive)
    {
        $path = storage_path('/app/csv/' . $csvArchive->id);

        CsvArchiveController::loadCsv($path);
        Format::completeGroupTitle();

        return redirect()->route('welcome');
    }
}
