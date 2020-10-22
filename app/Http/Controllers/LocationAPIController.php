<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * controllers
 */

use App\Http\Controllers\SpotifyController;

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



class LocationAPIController extends Controller
{
    /**
     * documentation
     * position stack / https://positionstack.com/documentation#php
     */



    function __construct()
    {

    }

    /***************
     * API Methods *
     ***************/
    public function api_v1_location_get(Request $request)
    {
        if (empty($request->location) == true || empty($request->limit) == true) {
            $output = array(
                "error" => "invalid input"
            );
            //  we have invalid input
            //  probably need a proper status code at some point
            //  csrf token should have been included from javascript
            return json_encode($output);
        } else {
            $_given_request = $request->location;
            $_limit = $request->limit;
            return LocationAPIController::geocode_lookup($_given_request, $_limit);
        }
    }

    /*******************
     * Backend Methods *
     *******************/
    static public function geocode_lookup($givenAddress, $limit)
    {
        /**
         * geo-code forward lookup
         */
        $queryString = http_build_query([
            'access_key' => env("POSITION_STACK_API"),
            'query' => $givenAddress,
            'output' => 'json',
            'limit' => $limit,
        ]);

        $ch = curl_init(sprintf('%s?%s', 'https://api.positionstack.com/v1/forward', $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);

        curl_close($ch);

        //  don't json decode; just dump
        return $json;
    }
}
