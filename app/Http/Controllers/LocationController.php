<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * controllers
 */
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\LocationAPIController;

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



class LocationController extends Controller
{
    function __construct()
    {
        //
    }

    public function location_update(Request $request)
    {
        $_playlist = $request->playlist;
        $_location = $request->location;
    }


    static public function geocode_lookup( $location = null ) {
        if ( $location == null ) {
            return null;
        } else {
            return LocationAPIController::geocode_lookup( $location, 1);
        }

    }





}
