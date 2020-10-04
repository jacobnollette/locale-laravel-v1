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
 * Route::get('/', function () {
 * return view('welcome');
 * });
 **/
Route::get('posts/{post}', function ( $post ) {
    return view("post", [
        'post' => $post
    ] );

});




Route::get('/spotify', 'App\Http\Controllers\SpotifyController@index');
Route::get('/posts/{post}', function () {
    return view("post");
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

