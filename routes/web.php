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
});

Route::get('/spotify', 'App\Http\Controllers\SpotifyController@index');
Route::get('/spotify/login', 'App\Http\Controllers\SpotifyController@login');

Route::get('/spotify/show_playlists', 'App\Http\Controllers\SpotifyController@show_playlists');
