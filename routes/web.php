<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/attiva/{csvArchive}', [App\Http\Controllers\CsvArchiveController::class, 'attiva'])->name('attiva');
Route::get('/show/{csvArchive}', [App\Http\Controllers\CsvArchiveController::class, 'show'])->name('show');

Route::get('/start', [App\Http\Controllers\FormatController::class, 'start'])->name('start');
Route::post('/next', [App\Http\Controllers\FormatController::class, 'next'])->name('next');
Route::get('/step/{step}', [App\Http\Controllers\FormatController::class, 'goto'])->name('goto');
Route::get('/tree/{step}', [App\Http\Controllers\FormatController::class, 'goto_tree'])->name('goto_tree');

Route::get('/new', [App\Http\Controllers\FormatController::class, 'new'])->name('new');
Route::post('/upload', [App\Http\Controllers\FormatController::class, 'upload'])->name('upload');

Route::get('/favorite', [App\Http\Controllers\FormatController::class, 'favorite'])->name('favorite');

Route::post('/alias/{alias}/favorite', [App\Http\Controllers\FormatController::class, 'swap_favorite'])->name('swap_favorite');
