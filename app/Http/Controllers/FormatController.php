<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormatRequest;
use App\Http\Requests\UpdateFormatRequest;
use App\Http\Requests\UploadFormatRequest;
use App\Models\Format;
use App\Models\CsvArchive;

use Illuminate\Support\Facades\Log;
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
        Format::generateStepSequence();
        $tree = Format::getStepTree();

        $_step = 1;
        $items = Format::findItemsWithParents([''])->get();

        Format::where('visible', '=', 1)->update(['visible' => 0]);

        foreach ($items as $item) {
            $item->set_visible(true, $_step);
        }

        $items = Format::getVisibleItems();

        Log::debug('Goto ' . $_step);

        return view('start', compact('items', '_step', 'tree'));
    }

    public function goto_tree($step)
    {
        Format::generateStepSequence();
        $tree = Format::getStepTree();

        return view('tree', compact('tree'));
    }

    public function goto($step)
    {
        Format::generateStepSequence();
        $tree = Format::getStepTree();

        // Nascondo tutti gli elementi
        Format::hideAllItems();

        $items = Format::findItemsWithStep($step)->get();

        // Mostro gli elementi
        foreach ($items as $item) {
            $item->set_visible(true, $step);
        }

        $items = Format::getVisibleItems();

        if (count($items) == 0) {
            Log::debug('Done.');

            $items = Format::all();
            return view('done', compact('items'));
        }

        Log::debug('Goto ' . $step);

        $_step = $step;
        return view('start', compact('items', '_step', 'tree'));
    }


    public function next(StoreFormatRequest $request)
    {
        // Aggiorno i dati con quelli inseriti
        $elenco_visibili = Format::where('visible', 1)->get();
        foreach ($elenco_visibili as $item) {
            if (is_null($request[$item->alias])) {
                Format::updateAliasWithValue($item->alias, 0);
            } else {
                Format::updateAliasWithValue($item->alias, $request[$item->alias]);
            }
        }

        Format::generateStepSequence();
        $tree = Format::getStepTree();
        $_step = $request['_step'] + 1;

        if ($request['_view_mode']=='favorite') {
           return FormatController::favorite(); 
        }

        return FormatController::goto($_step);
    }

    public function new()
    {
        $items = CsvArchive::all();
        return view('new', compact('items'));
    }

    public function upload(UploadFormatRequest $request)
    {
        $path = $request->file->move(public_path() . '/csv', 'json_data.json');
        CsvArchiveController::loadCsv($path);

        if (isset($request->name)) {
            $item = CsvArchive::where('name', $request->name)->first();
            if ($item !== null) {
                $item->update(['name' => $request->name]);
            } else {
                $item = CsvArchive::create([
                    'name' => $request->name,
                ]);
            }

            // $item = CsvArchive::create(['name'=>$request->name]);
            Storage::put('csv/' . $item->id, file($path));
        }

        Format::completeGroupTitle();

        return redirect()->route('welcome');
    }

    public function swap_favorite($alias)
    {
        $format = Format::where('alias', '=', $alias)->first();
        $format->update(['favorite' => !$format->favorite]);
        return true;
    }


    public function favorite()
    {
        Format::generateStepSequence();
        $tree = Format::getStepTree();

        Format::hideAllItems();

        $items = Format::where('favorite', '=', 1)->get();
        foreach ($items as $item) {
            $respectRules = $item->respectRules();
            $item->update([
                'visible' => $respectRules,
            ]);
        }

        $items = Format::where('favorite', '=', 1)
            ->where('visible', 1)
            ->get()
            ->groupBy(['group_title']);

        return view('favorite', compact('items', 'tree'));
    }
}
