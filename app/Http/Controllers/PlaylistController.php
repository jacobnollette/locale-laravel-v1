<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * controllers
 */

use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\LocationController;

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

class PlaylistController extends Controller
{
    function __construct()
    {
        $this->spotify = new SpotifyController();
    }


    public function index(Request $request, $id)
    {
        if (Auth::id() != true):
            /**
             * we are not logged in, redirect to spotify
             */
            header('Location: /');
            die();
        endif;
        $this->spotify_connect();

        /**
         * request location
         * this is where we're going to add the previous data (model
         */
        $_geocode = LocationController::geocode_lookup("");
        $_geocode = json_decode($_geocode);

        /**
         * parse the location for valid return
         */
        if (empty($_geocode->data[0]->latitude) == true || empty($_geocode->data[0]->longitude) == true) {
            $location = array(
                0, 0
            );
        } else {
            $location = array(
                $_geocode->data[0]->latitude,
                $_geocode->data[0]->longitude
            );
        }

        /**
         * spotify info request
         */
        $playlist = $this->spotify->spotify_api->getPlaylist($id);
        //dd($playlist->tracks->items[0]);
        //dd( $playlist);


        /**
         * output
         */
        return view('playlists/edit', [
            'playlist' => $playlist,
            'location' => $location
        ]);
    }

    public function update(Request $request)
    {
        $location = json_decode( $request->location );
        $location->lat
            $location->lng
    }


    public
    function playlist_location_get(Request $request)
    {
        if (Auth::id() != true):
            /**
             * we are not logged in, redirect to spotify
             */
            header('Location: /');
            die();
        endif;

        $query = "hello";
        $query = json_encode($query);
        return $query;
    }


    private
    function spotify_connect()
    {
        /**
         * we need to move this functionality to the spotify controller
         */
        $_user = User::where("id", "=", Auth::id())->first();
        if (isset($_user->spotify_refresh_token)) :
            $this->spotify->spotify_session->refreshAccessToken($_user->spotify_refresh_token);
            $this->spotify->spotify_access_token = $this->spotify->spotify_session->getAccessToken();
            $this->spotify->spotify_refresh_token = $this->spotify->spotify_session->getRefreshToken();
            User::where("id", "=", Auth::id())->update(array(
                'spotify_access_token' => $this->spotify->spotify_access_token,
                'spotify_refresh_token' => $this->spotify->spotify_refresh_token,
                'spotify_access_token_added' => now(),
                'spotify_refresh_token_added' => now()
            ));

            $this->spotify->spotify_api->setAccessToken($this->spotify->spotify_access_token);

            //  we have a spotify access token,
            //  update user info
            $this->spotify_update_user();
        endif;

    }

    private
    function spotify_update_user()
    {
        /**
         * we need to move this functionality to the spotify controller
         */
        //  get spotify user data & add to locale user table
        $me = $this->spotify->spotify_api->me();
        User::where("id", "=", Auth::id())->update(array(
            'spotify_user_id' => $me->id
        ));
    }
}
