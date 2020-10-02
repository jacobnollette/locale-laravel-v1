<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SpotifyController extends Controller
{
  public function index(Request $request)
  {
    $parse = $request->path();
    $uri = $request->fullUrl();
    $uri = parse_url( $uri );
    $uri = $uri["query"];
    print_r( $uri );
    //return view('spotify');
  }

  public function login()
  {
    $SPOTIFY_CLIENT_ID=env('SPOTIFY_CLIENT_ID');
    $SPOTIFY_CLIENT_SECRET=env('SPOTIFY_CLIENT_SECRET');
    //
    $SPOTIFY_LOGIN_URL = 'https://accounts.spotify.com/authorize?response_type=code&client_id=' . $SPOTIFY_CLIENT_ID . '&redirect_uri=' . urlencode('https://locale.test/spotify');
    header("Location: $SPOTIFY_LOGIN_URL");
  }

  public function show_playlists()
  {
    $spotify_code = env("SPOTIFY_CLIENT_CODE");

    $response = Http::get('https://api.spotify.com/v1/me/playlists', [
      'Authorization' => 'Bearer ' . $spotify_code,
    ]);    
    print_r ( $response );
  }
}
