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
use App\Models\Spotify_playlist;
use App\Models\User_crate;

/**
 * packages
 */

//  spotify api wrapper - https://github.com/jwilsson/spotify-web-api-php#usage
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

//  grimzy
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;


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


        $existing_field = Spotify_playlist::where('locale_user_id', Auth::id())->where("playlist_id", $id)->first();
//        dd( );
//
//        $existing_field->location_lat
//


        /**
         * request location
         * this is where we're going to add the previous data (model
         */
        $_geocode = LocationController::geocode_lookup("");
        $_geocode = json_decode($_geocode);

        /**
         * parse the location for valid return
         */
        //dd( $_geocode );
        if ($_geocode == null) {
            //($_geocode->data[0]->latitude) == true || empty($_geocode->data[0]->longitude) == true) {
            if ($existing_field->location == null) {
                $location = array (0,0);
            } else {
                $location = array(
                    $existing_field->location->getLat(), $existing_field->location->getLng()
                );
            }
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

    public function update(Request $request, $id)
    {
        $_location = Spotify_playlist::where("locale_user_id", '=', Auth::id())->where("playlist_id", '=', $id)->first();
        $_location->location = new Point($request->lat, $request->lng);
        $_location->save();

    }


    public function playlist_location_get(Request $request)
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


    private function spotify_connect()
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



//Illuminate\Database\QueryException: SQLSTATE[42000]: Syntax error or access violation: 1582 Incorrect parameter count in the call to native function 'ST_GeomFromText' (SQL: update `spotify_playlists` set `location` = ST_GeomFromText(POINT(44.916105959115 -93.319431671939), 0, 'axis-order=long-lat'), `spotify_playlists`.`updated_at` = 2020-10-29 01:19:35 where `id` = 1) in file /Users/jacobnollette/Code/locale/vendor/laravel/framework/src/Illuminate/Database/Connection.php on line 671
