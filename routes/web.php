<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

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
});


Route::post('movie/favorite', [MovieController::class, 'favorite'])->name('favorite');
Route::post('movie/add_to_watchlist', [MovieController::class, 'add_to_watchlist'])->name('add_to_watchlist');
Route::post('movies/update_watch/{watchlist}',[MovieController::class, 'update_watch'])->name('update_watch');
Route::resource('movies', MovieController::class);


