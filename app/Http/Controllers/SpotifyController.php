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
     * Spotify public essentials
     */
    public $spotify_api;
    public $spotify_session;
    public $spotify_scopes;
    public $spotify_response_url;
    public $spotify_response_url_raw;
    public $spotify_access_token;
    public $spotify_refresh_token;


    function __construct($test = null)
    {
        //dd( $test);
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
    public function landing()
    {
        $_user = User::where( "id", "=", Auth::id() )->first();

        return view('spotify/landing', [
        ]);
    }
    public function index()
    {

        $_user = User::where( "id", "=", Auth::id() )->first();

        return view('spotify/index', [
        ]);
    }

    public function spotify_auth_response()
    {
        /**
         * Receives the spotify code, and redirects to dashboard
         * /spotify/auth/response
         */


        /**
         * get access token from spotify and store it in database
         * get access from token
         */
        $this->spotify_session->requestAccessToken($_GET['code']);

        /**
         *  internal access token stuff
         */
        $_access_token = $this->spotify_session->getAccessToken();
        $_refresh_token = $this->spotify_session->getRefreshToken();

        /**
         * save access token to database
         */
        User::where( "id", "=", Auth::id() )->update(array(
            'spotify_access_token' => $_access_token,
            'spotify_access_token_added' => now(),
            'spotify_refresh_token' => $_refresh_token,

        ));

        /**
         * redirect to dashboard
         * the access token is saved to the database
         */
        header('Location: ' . "/dashboard" );
        die();
    }

    public function spotify_auth_get_redirect()
    {
        /**
         * the spotify auth url
         * /spotify/auth
         * redirects to spotify auth page
         *
         * spotify redirects to /spotify/auth/respose
         * that route goes to SpotifyControllers@spotify_auth_response
         */
        header('Location: ' . $this->spotify_session->getAuthorizeUrl( $this->spotify_scopes ) );
        die();
    }

}
