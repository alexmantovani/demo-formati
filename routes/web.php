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

Route::get('/start', [App\Http\Controllers\FormatController::class, 'start'])->name('start');
Route::get('/prev/{step}', [App\Http\Controllers\FormatController::class, 'prev'])->name('prev');
Route::post('/next', [App\Http\Controllers\FormatController::class, 'next'])->name('next');
// Route::post('/store', [App\Http\Controllers\FormatController::class, 'next'])->name('store');

Route::get('/new', [App\Http\Controllers\FormatController::class, 'new'])->name('new');
Route::post('/upload', [App\Http\Controllers\FormatController::class, 'upload'])->name('upload');
