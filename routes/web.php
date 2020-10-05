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

    $posts = [
        "my-first-post" => "Hello world 1",
        'my-second-post' => "Hello world 2"
    ];


    if ( ! array_key_exists( $post, $posts) ) {
        abort( 404, "Page does not exist");
    }

    return view('post', [
            'post' => $posts[$post]
        ]
    );

});



Route::get('/spotify', 'App\Http\Controllers\SpotifyController@index');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

