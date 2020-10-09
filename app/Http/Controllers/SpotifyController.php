<?php

namespace App\Http\Controllers;

/**
 * libraries
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * models
 */
use App\Models\User;

/**
 * packages
 */
//  spotify api wrapper - https://github.com/jwilsson/spotify-web-api-php#usage
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;


class SpotifyController extends Controller
{
    /**
     *  Crucial bits
     */
    private $locale_id;

    /**
     * Spotify essentials
     */
    private $spotify_api;
    private $spotify_session;
    private $spotify_scopes;
    private $response_url;
    private $response_url_raw;



    function __construct()
    {

        /**
         * Spotify bits
         */
        //  this is the endpoint for receiving the spotify access token
        $this->spotify_response_url_raw = 'https://locale.test/spotify/auth/response';
        $this->spotify_response_url = urlencode( $this->spotify_response_url_raw );

        $this->spotify_session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->spotify_response_url_raw
        );
        $this->spotify_api = new SpotifyWebAPI;
        $this->spotify_scopes = [
            'scope' => [
                'playlist-modify-private',
                'playlist-modify-public',
                'playlist-read-private',
                'user-read-private',
            ],
        ];

    }

    public function index()
    {
        $_user = User::where("id", "=", $this->locale_id)->first();

        return view('spotify/index', [
        ]);
    }

    public function spotify_auth_response()
    {
        /**
         * Prerequisites
         */

        /**
         * get access token from spotify and store it in database
         */
        //  get access from token
        $this->spotify_session->requestAccessToken($_GET['code']);

        //  access token
        $_access_token = $this->spotify_session->getAccessToken();
        $_refresh_token = $this->spotify_session->getRefreshToken();

        //$this->spotify_api->setAccessToken( $_access_token );
        User::where("id", "=", $this->locale_id)->update(array(
            'spotify_access_token' => $_access_token,
            'spotify_access_token_added' => now(),
            'spotify_refresh_token' => $_refresh_token,

        ));
        header('Location: ' . "/dashboard" );
        die();
    }




    public function spotify_auth_get_redirect()
    {
        header('Location: ' . $this->spotify_session->getAuthorizeUrl( $this->spotify_scopes ) );
        die();
    }

    private function user_get () {
        $user_id = Auth::id();
        $this->locale_id = User::where("id", "=", $user_id)->first();
    }
}
