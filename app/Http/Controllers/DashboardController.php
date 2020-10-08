<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Dashboard;
use App\Models\Spotify;

/**
 * packages
 */

//  spotify api wrapper - https://github.com/jwilsson/spotify-web-api-php#usage
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class DashboardController extends Controller
{

    /**
     *  Crucial spotify secrets
     */
    private $client_id;
    private $client_secret;
    private $client_hashed_token;

    private $spotify_session;
    private $spotify_api;
    private $spotify_access_token;


    function __construct()
    {

        $this->response_url_raw = 'https://locale.test/spotify/auth/response';
        $this->response_url = urlencode($this->response_url_raw);

        /**
         * Spotify objects
         */
        $this->spotify_session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->response_url_raw
        );
        $this->spotify_api = new SpotifyWebAPI;
    }

    public function index()
    {
        $user_id = Auth::id();
        $_user = User::where("id", "=", $user_id)->first();

        //  connect to spotify, provide access token
        $this->spotify_connect();

        //  we have a spotify access token,
        //  update user info
        $this->spotify_update_user();


//        $me = $this->spotify_api->me();
        $playlists = $this->spotify_api->getUserPlaylists($_user->spotify_user_id, [
            'limit' => 5
        ]);

        dd( $playlists );





//        dd( $me );
//        if (isset($_user->spotify_access_token)):
//            $_user_access_token = $_user->spotify_access_token;
//            $this->spotify_api = new SpotifyWebAPI();
//            $this->spotify_api->setAccessToken($_user_access_token);
//        endif;
//        dd( $this->spotify_access_token );
//
//        dd( $this->spotify_api);
//        $me = $this->spotify_api->me();
//        dd( $me );
//        print_r($this->spotify_api->getTrack('7EjyzZcbLxW7PaaLua9Ksb'));
//
//    die();
//        $playlists = $api->getUserPlaylists('USER_ID', [
//            'limit' => 5
//        ]);


        //$token = Spotify::get_user_access_token();
        // $bearer_token = Spotify::authorize_bearer_token();

        //echo $bearer_token;
        //die();
//        return view('dashboard/index', [
//            'client_id' => $this->client_id
//        ]);
    }


    private function spotify_connect()
    {
        /**
         * This goes through the user flow of queueing up the spotify api
         */
        $user_id = Auth::id();

        $_user = User::where("id", "=", $user_id)->first();
        if (isset($_user->spotify_refresh_token)) :

            $this->spotify_session->refreshAccessToken($_user->spotify_refresh_token);
            $this->spotify_access_token = $this->spotify_session->getAccessToken();
            $this->spotify_refresh_token = $this->spotify_session->getRefreshToken();

            User::where("id", "=", $user_id)->update(array(
                'spotify_access_token' => $this->spotify_access_token,
                'spotify_refresh_token' => $this->spotify_refresh_token,
                'spotify_access_token_added' => now(),
                'spotify_refresh_token_added' => now()
            ));

            $this->spotify_api->setAccessToken($this->spotify_access_token);

        endif;

    }

    private function spotify_update_user() {
        /**
         * Update user table with additional spotify info
         */

        //  get Locale user id
        $user_id = Auth::id();

        //  get spotify user data & add to locale user table
        $me = $this->spotify_api->me();
        User::where("id", "=", $user_id)->update(array(
            'spotify_user_id' => $me->id
        ));
    }


}
