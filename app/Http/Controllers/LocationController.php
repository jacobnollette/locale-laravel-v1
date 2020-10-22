<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * controllers
 */

use App\Http\Controllers\SpotifyController;
use App\Http\Controller\LocationAPIController;

/**
 * models
 */

use App\Models\User;
use App\Models\Dashboard;
use App\Models\Spotify;
use App\Models\Spotify_playlists;
use App\Models\User_crates;

/**
 * packages
 */

//  spotify api wrapper - https://github.com/jwilsson/spotify-web-api-php#usage
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class LocationController extends Controller
{
    function __construct()
    {
        $this->spotify = new SpotifyController();
    }


    public function index()
    {
        //  connect to spotify, provide access token
        $test = new Auth();
        if (Auth::id() != true):
            /**
             * we are not logged in, redirect to spotify
             */
            header('Location: /');
            die();
        endif;
        $this->spotify_connect();

        return view('dashboard/index', [
            'playlists' => $playlists
        ]);
    }

    public function location_update(Request $request)
    {
        $_playlist = $request->playlist;
        $_location = $request->location;
    }








}
