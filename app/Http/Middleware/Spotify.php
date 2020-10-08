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
    public function handle(Request $request, Closure $next)
    {
        $session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->response_url_raw
        );


        $session->refreshAccessToken($refreshToken);

        $accessToken = $session->getAccessToken();


        return $next($request);
    }
}
