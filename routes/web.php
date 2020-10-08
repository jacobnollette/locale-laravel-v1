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

/**
 * Dashboard rubbish
 */
Route::get( '/dashboard/', 'App\Http\Controllers\DashboardController@index');


/**
 * Spotify connections
 */
Route::get('/spotify/', 'App\Http\Controllers\SpotifyController@index');
Route::get('/spotify/response', 'App\Http\Controllers\SpotifyController@response');
Route::post('/spotify/input', 'App\Http\Controllers\SpotifyController@input');


/**
 * Auth, and login rubbish
 */
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('welcome');
});
