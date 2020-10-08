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

    private $token = "hello";
    private $response_url;
    /**
     *  Crucial spotify secrets
     */
    private $client_id;
    private $client_secret;
    private $client_hashed_token;

    private $spotify_session;
    private $spotify_api;


    function __construct()
    {
        $this->response_url_raw = 'https://locale.test/spotify/auth/response';
        $this->response_url = urlencode($this->response_url_raw);
        $this->client_hashed_token = base64_encode($this->client_id . ':' . $this->client_secret);
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');

        $this->spotify_session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->response_url_raw
        );


        /**
         * Spotify access token
         * initialize spotify web api token
         */
        $user_id = Auth::id();
        $_user = User::where("id", "=", $user_id)->first();
        if (isset($_user->spotify_access_token)):
            $_user_access_token = $_user->spotify_access_token;
            $this->spotify_api = new SpotifyWebAPI();
            $this->spotify_api->setAccessToken($_user_access_token);
        endif;
    }

    public function index()
    {

        $me = $this->spotify_api->me();
        dd( $me );
        print_r($this->spotify_api->getTrack('7EjyzZcbLxW7PaaLua9Ksb'));

    die();
        $playlists = $api->getUserPlaylists('USER_ID', [
            'limit' => 5
        ]);


        //$token = Spotify::get_user_access_token();
        // $bearer_token = Spotify::authorize_bearer_token();

        //echo $bearer_token;
        //die();
//        return view('dashboard/index', [
//            'client_id' => $this->client_id
//        ]);
    }


}
