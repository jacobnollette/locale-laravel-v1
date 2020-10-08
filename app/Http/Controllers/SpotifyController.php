<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\SpotifyConfigs;
use App\Models\User;


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
        $user_id = Auth::id();

        $_user = User::where("id", "=", $user_id)->first();

        return view('spotify/index', [
            'token' => $this->token,
            'client_id' => $this->client_id,
            'redirect_url' => $this->response_url,
            'user' => $_user
        ]);
    }

    public function response()
    {
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

        // this works
        $user_id = Auth::id();

        User::where("id", "=", $user_id)->update(array(
            'spotify_access_token' => $access_token)
        );

        $output = '{' . "\"redirect_url\":\"/spotify\"}";
        //$output .= "\"access_token\":\"$access_token\",";
        //$output .= "\"user_id\":\"$user_id\"}";
        //$output .= "\"user_output\":\"$user\"}";


        return $output;
    }
}
