<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Dashboard;
use App\Models\Spotify;

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


    function __construct()
    {
        $this->response_url = urlencode('https://locale.test/spotify/response');
        $this->client_hashed_token = base64_encode($this->client_id . ':' . $this->client_secret);
        $this->client_id = env('SPOTIFY_CLIENT_ID');
        $this->client_secret = env('SPOTIFY_CLIENT_SECRET');
    }

    public function index() {

        //$token = Spotify::get_user_access_token();
        $bearer_token = Spotify::authorize_bearer_token();

        echo $bearer_token;
        die();
//        return view('dashboard/index', [
//            'client_id' => $this->client_id
//        ]);
    }


}
