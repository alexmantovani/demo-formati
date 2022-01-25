<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormatRequest;
use App\Http\Requests\UpdateFormatRequest;
use App\Http\Requests\UploadFormatRequest;
use App\Models\Format;

use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Stmt\Foreach_;

use function PHPUnit\Framework\isNull;

class FormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $json_str = Storage::get('json_data.json');
        // //$json_str = file_get_contents('people.json');
        // $items = json_decode($json_str, false);

        // return view('start', compact('items'));
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

    public function start()
    {
        $_step = 1;
        $items = Format::findItemsWithParents([''])->get();

        Format::where('visible', '=', 1)->update(['visible' => 0]);

        foreach ($items as $item) {
            // foreach ($group as $item) {
                $item->set_visible(true, $_step);
            // }
        }

        $items = Format::getVisibleItems();

        return view('start', compact('items', '_step'));
    }

    public function prev(StoreFormatRequest $request, $step)
    {
        $_step = $step - 1;

        // Nascondo tutti gli elementi
        Format::where('visible', '=', 1)->update(['visible' => 0]);
        Format::where('step', '=', $step)->update(['step' => 0]);

        $items = Format::findItemsWithStep($_step)->get();

        // Mostro gli elementi
        foreach ($items as $item) {
            // foreach ($group as $item) {
                $item->set_visible(true, $_step);
            // }
        }

        $items = Format::getVisibleItems();

        return view('start', compact('items', '_step'));
    }

    public function next(StoreFormatRequest $request)
    {
        $_step = $request['_step'] + 1;

        $elenco_visibili = Format::where('visible', 1)->get();
        foreach ($elenco_visibili as $item) {
            if (is_null($request[$item->alias])) {
                Format::updateAliasWithValue($item->alias, 0);
            } else {
                Format::updateAliasWithValue($item->alias, $request[$item->alias]);
            }
        }

        // Nascondo tutti gli elementi
        Format::where('visible', '=', 1)->update(['visible' => 0]);

        // Vado allo step successivo
        $items = Format::findItemsWithParents($elenco_visibili->pluck('alias'))->get();
        // Mostro gli elementi
        foreach ($items as $item) {
            // foreach ($group as $item) {
                $item->set_visible(true, $_step);
            // }
        }

        $items = Format::getVisibleItems();

        if (count($items)==0) {
            return view('done');
        }

        return view('start', compact('items', '_step'));
    }

    public function new()
    {
        return view('new');
    }

    public function upload(UploadFormatRequest $request)
    {
        $path = $request->file->move(public_path() . '/csv', 'json_data.json');

        $csv = array_map('str_getcsv', file($path));
        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv); # remove column header

        Format::truncate();
        foreach ($csv as $item) {
            Format::create($item);
        }

        Format::completeGroupTitle();

        return redirect()->route('welcome');
    }
}
