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
    private $spotify_api;
    private $spotify_session;
    private $token = "hello";
    private $response_url;
    private $response_url_raw;
    private $scopes;
    /**
     *  Crucial spotify secrets
     */
    private $client_id;
    private $client_secret;
    private $client_hashed_token;

    function __construct()
    {



        $this->response_url_raw = 'https://locale.test/spotify/auth/response';
        $this->response_url = urlencode( $this->response_url_raw );
        $this->scopes = urlencode("playlist-read-private playlist-modify playlist-modify-private");
        $this->client_hashed_token = base64_encode($this->client_id . ':' . $this->client_secret);
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');


        $this->spotify_api = new SpotifyWebAPI;

    }

    public function index()
    {
        $user_id = Auth::id();

        $_user = User::where("id", "=", $user_id)->first();

        return view('spotify/index', [
            'token' => $this->token,
            'client_id' => $this->client_id,
            'redirect_url' => $this->response_url,
            'scopes' => $this->scopes,
            'user' => $_user
        ]);
    }

    public function spotify_auth_response()
    {
        $access_token = $_GET['code'];
        $user_id = Auth::id();
        $this->spotify_api->setAccessToken( $access_token );
        User::where("id", "=", $user_id)->update(array(
            'spotify_access_token' => $access_token,
            'spotify_access_token_added' => now()
        ));
        header('Location: ' . "/dashboard" );
        die();
    }




    public function spotify_auth_get_redirect()
    {
        $this->spotify_session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->response_url_raw
        );

        $options = [
            'scope' => [
                'playlist-modify-private',
                'playlist-modify-public',
                'playlist-read-private',
                'user-read-private',
            ],
        ];
        //return $this->spotify_session->getAuthorizeUrl($options);
        header('Location: ' . $this->spotify_session->getAuthorizeUrl($options));
        die();
    }
}

https://accounts.spotify.com/authorize?client_id=c311cb6b6aaf467c948212171b737069&redirect_uri=https%3A%2F%2Flocale.test%2Fspotify%2Fresponse&response_type=code&scope=playlist-read-collaborative+playlist-modify-private+playlist-modify-public+playlist-read-public
