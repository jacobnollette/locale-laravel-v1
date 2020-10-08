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



        $this->response_url_raw = 'https://locale.test/spotify/response';
        $this->response_url = urlencode( $this->response_url_raw );
        $this->scopes = urlencode("playlist-read-private playlist-modify playlist-modify-private");
        $this->client_hashed_token = base64_encode($this->client_id . ':' . $this->client_secret);
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');

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

        return view('spotify/index', [
            'token' => $this->token,
            'client_id' => $this->client_id,
            'redirect_url' => $this->response_url,
            'scopes' => $this->scopes,
            'user' => $_user
        ]);
    }

    public function response()
    {
        $access_token = $_GET['code'];

        $this->spotify_api->setAccessToken( $access_token );



//
//        if (isset($_GET['code'])) {
//            $this->spotify_session->requestAccessToken($_GET['code']);
//            $api->setAccessToken($this->spotify_session->getAccessToken());
//
//            print_r($api->me());
//        }
//        die();
//        return view('spotify/response');
    }

    public function input(Request $request)
    {
        /**
         * token input
         */
        $access_token = $request->input('access_token');
        $token_type = $request->input('token_type');
        $expires_in = $request->input('expires_in');
        $token_type = $request->input('token_type');

        // this works
        $user_id = Auth::id();

        User::where("id", "=", $user_id)->update(array(
            'spotify_access_token' => $access_token,
            'spotify_access_token_added' => now()
        ));

        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());

            print_r($api->me());
        }
        die();

        $output = '{' . "\"redirect_url\":\"/spotify\"}";
        //$output .= "\"access_token\":\"$access_token\",";
        //$output .= "\"user_id\":\"$user_id\"}";
        //$output .= "\"user_output\":\"$user\"}";


        return $output;
    }


    public function spotify_get_auth_redirect()
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
