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
 * Global rubbish
 */
Auth::routes();

/**
 * Home rubbish
 */
Route::get( '/','App\Http\Controllers\HomeController@landing');
Route::get( '/home','App\Http\Controllers\HomeController@index');

/**
 * Dashboard rubbish
 */
Route::get('/dashboard/','App\Http\Controllers\DashboardController@index');
Route::post('/dashboard/playlist/add/','App\Http\Controllers\DashboardController@playlist_add');
Route::post('/dashboard/playlist/remove/','App\Http\Controllers\DashboardController@playlist_remove');

/**
 * Playlist rubbish
 */
Route::get('/playlist/{id}/','App\Http\Controllers\PlaylistController@index');
Route::post('/playlist/{id}/location/update/','App\Http\Controllers\PlaylistController@location_update');
Route::post('/playlist/{id}/playlist/add/','App\Http\Controllers\PlaylistController@playlist_add');
Route::post('/playlist/{id}/playlist/remove/','App\Http\Controllers\PlaylistController@playlist_remove');


/**
 * Location API rubbish
 */
Route::post('/utility/location/get/','App\Http\Controllers\LocationAPIController@api_v1_location_get');

/**
 * Explorer rubbish
 */
Route::get('/explore/','App\Http\Controllers\ExploreController@index');
Route::post( '/dashboard/explore/add/','App\Http\Controllers\ExploreController@explorer_add');
Route::post( '/dashboard/explore/remove/','App\Http\Controllers\ExploreController@explorer_remove');
Route::post( '/dashboard/explore/list/','App\Http\Controllers\ExploreController@list');




/**
 * Spotify rubbish
 */
Route::get('/spotify/','App\Http\Controllers\SpotifyController@index');
Route::get('/spotify/auth/response', 'App\Http\Controllers\SpotifyController@spotify_auth_response');
Route::get('/spotify/auth','App\Http\Controllers\SpotifyController@spotify_auth_get_redirect');
Route::post('/spotify/input','App\Http\Controllers\SpotifyController@input');


