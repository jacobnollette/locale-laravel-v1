<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


use App\Models\User;
use SpotifyWebAPI\Session;


class Spotify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    private $response_url_raw;
    private $response_url;

    function __construct()
    {
        $this->response_url_raw = 'https://locale.test/spotify/auth/response';
        $this->response_url = urlencode( $this->response_url_raw );
    }


    public function handle(Request $request, Closure $next)
    {
        $session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->response_url_raw
        );

//
//        $session->refreshAccessToken($refreshToken);
//
//        $accessToken = $session->getAccessToken();


        return $next($request);
    }
}
