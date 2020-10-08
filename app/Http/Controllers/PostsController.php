<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    public function show( $slug ) {

        return view('post', [
                'post' => Post::where('slug', $slug)->firstOrFail()
            ]
        );
    }

    public function show_static( $post ) {
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
