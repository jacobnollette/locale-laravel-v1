<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User;
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

    function __construct()
    {
        $this->response_url_raw = 'https://locale.test/spotify/auth/response';
        $this->response_url = urlencode($this->response_url_raw);
    }


    public function handle(Request $request, Closure $next)
    {
        $session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->response_url_raw
        );


//        $user_id = Auth::id();
//        if (isset ($user_id)):
//            $_user = User::where("id", "=", $user_id)->first();
//            $_user_access_token = $_user->spotify_access_token;
//            if (isset ($_user_access_token)):
//
//                //echo $_user_access_token;
//                //die();
//                //  refresh user token & save it to the database
//                $new_access_token = $session->refreshAccessToken($_user_access_token);
//                User::where("id", "=", $user_id)->update(array(
//                    'spotify_access_token' => $new_access_token,
//                    'spotify_access_token_added' => now()
//                ));
//
//            endif;
//        endif;




        return $next($request);
    }
}
