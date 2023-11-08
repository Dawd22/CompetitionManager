<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoundsController;
use App\Http\Controllers\CompetitionsController;
use App\Http\Controllers\CompetitorsController;

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
Route::delete('/competitor',CompetitorsController::class);
Route::resource('competition',CompetitionsController::class);
Route::resource('round',RoundsController::class);
Route::resource('competitor',CompetitorsController::class);
