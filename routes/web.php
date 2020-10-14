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
Route::post( '/dashboard/playlist/add/', 'App\Http\Controllers\DashboardController@playlist_add');


/**
 * Spotify connections
 */
Route::get('/spotify/', 'App\Http\Controllers\SpotifyController@index');
Route::post('/spotify/input', 'App\Http\Controllers\SpotifyController@input');

Route::get('/spotify/auth/response', 'App\Http\Controllers\SpotifyController@spotify_auth_response');
Route::get( '/spotify/auth', 'App\Http\Controllers\SpotifyController@spotify_auth_get_redirect');


/**
 * Auth, and login rubbish
 */
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    header('Location: /spotify' );
    die();
});
