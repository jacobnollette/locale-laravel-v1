<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SpotifyController extends Controller
{
    private $token = "hello";
    private $response_url;
    /**
     *  Crucial spotify secrets
     */
    private $client_id;
    private $client_secret;
    private $client_hashed_token;

    function __construct()
    {
        $this->response_url = urlencode('https://locale.test/spotify/response');
        $this->client_hashed_token = base64_encode($this->client_id . ':' . $this->client_secret);
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');
    }


    public function index()
    {

        return view('spotify/index', [
            'token' => $this->token,
            'client_id' => $this->client_id,
            'redirect_url' => $this->response_url
        ]);
    }

//    public function bearer_token(Request $request, $id)
//    {
//        //  laravel get requests
//        //  https://laravel.com/docs/8.x/http-client
//
//
////        $response = Http::withHeaders([
////            'Authorization' => $this->client_hashed_token,
////        ])->get('http://test.com/users', [
////            'name' => 'Taylor',
////        ]);
////        $response = Http::get('https://accounts.spotify.com/authorize', [
////            'client_id'         => $this->client_id,
////            'response_type'     => 'token',
////            'redirect_uri'      => urlencode( 'https://locale.test/spotify/response'),
////        ]);
//
//    }

    public function response()
    {
        //https://locale.test/spotify/response#access_token=BQABFpoO25BaEfWBH7j1-Re6hxpd_NNjks-lhyZYhU0ZVAggDgyBPYqO_lOKiZHzedfZxIs_n5eXjMQUz1LKbaWl-q8nrNejm0ZTxB-v0IUioGsb3WPPIyKp1EvGXM5xhTAD2tk2uqdMxsz2rlg8tLE7n_JPeFuZNdU&token_type=Bearer&expires_in=3600
        return view('spotify/response');
    }

    public function input (Request $request)
    {
        /**
         * token input
         */
        $access_token       = $request->input('access_token');
        $token_type         = $request->input('token_type');
        $expires_in         = $request->input('expires_in');
        $token_type         = $request->input('token_type');

        $redirect_url = '{"redirect_url":"/spotify"}';
        return $redirect_url;

        //return $request;
        //return json_decode( $name );
        //return json_decode ( $request );


    }
}
