<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show( $post ) {
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
    }
}
