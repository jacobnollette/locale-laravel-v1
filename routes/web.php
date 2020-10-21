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
Route::post( '/dashboard/playlist/remove/', 'App\Http\Controllers\DashboardController@playlist_remove');

/**
 * Playlist rubbish
 */
Route::get( '/playlist/{id}', 'App\Http\Controllers\PlaylistController@index');

/**
 * Explorer rubbish
 */
Route::get( '/explore/', 'App\Http\Controllers\ExplorerController@index');
Route::post( '/dashboard/explore/add/', 'App\Http\Controllers\ExplorerController@explorer_add');
Route::post( '/dashboard/explore/remove/', 'App\Http\Controllers\ExplorerController@explorer_remove');

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

Route::get( '/', 'App\Http\Controllers\SpotifyController@landing');
