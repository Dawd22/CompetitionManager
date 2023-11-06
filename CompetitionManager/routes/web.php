<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('competitions.create');
});
Route::get('/index', function () {
    return view('pages.index');
});
Route::resource('competition','App\Http\Controllers\CompetitionsController');
Route::resource('round','App\Http\Controllers\RoundsController');