<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Models
 */

use App\Models\User;

/**
 * Packages
 */

//  spotify api wrapper - https://github.com/jwilsson/spotify-web-api-php#usage
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;


class Spotify
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */


    private $response_url_raw;
    private $response_url;

    private $spotify_api;
    private $spotify_session;

    function __construct()
    {
        $this->response_url_raw = 'https://locale.test/spotify/auth/response';
        $this->response_url = urlencode($this->response_url_raw);

        $this->spotify_session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->response_url_raw
        );
        $this->spotify_api = new SpotifyWebAPI;
    }


    public function handle(Request $request, Closure $next)
    {
        /**
         * get basic locale user info
         */
        $user_id = Auth::id();
        $_user = User::where("id", "=", $user_id)->first();
//
//        //  get previous access token from locale
        $_locale_access_token = $_user->spotify_access_token;
        $_locale_refresh_token = $_user->spotify_refresh_token;

        $_new_refresh_token = $this->spotify_session->refreshAccessToken($_locale_refresh_token);
        if ($_new_refresh_token == true):
            //  do nothing
        else:
            echo "token expired";
        endif;

        return $next($request);
    }
}
