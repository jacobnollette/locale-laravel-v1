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


Route::get('posts/{post}', 'App\Http\Controllers\PostsController@show' );


Route::get('/spotify', 'App\Http\Controllers\SpotifyController@index');
Route::get('/spotify_response', 'App\Http\Controllers\SpotifyController@response');








Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('welcome');
});
