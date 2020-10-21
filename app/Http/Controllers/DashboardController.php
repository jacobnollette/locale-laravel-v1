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

//  spotify api wrapper - https://github.com/jwilsson/spotify-web-api-php#usage
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class DashboardController extends Controller
{
    /**
     * Modules
     */
    private $spotify;


    function __construct()
    {
        $this->spotify = new SpotifyController();
    }

    public function index()
    {
        //  connect to spotify, provide access token
        $test = new Auth();
        if ( Auth::id() != true ):
            /**
             * we are not logged in, redirect to spotify
             */
            header('Location: /' );
            die();
        endif;
        $this->spotify_connect();

        /**
         * load all playlists
         * make background in future versions
         * add it to the queue
         */
        //$this->playlist_update_all();
        $playlists = $this->playlist_update_10();
        $playlists = $playlists->items;

        $playlists = $this->playlist_check_crate ( $playlists );
        return view('dashboard/index', [
            'playlists' => $playlists
        ]);


    }

    public function playlist_add (Request $request) {
        $_user = User::where("id", "=", Auth::id())->first();
        User_crates::updateOrInsert(
            ['locale_user_id' => Auth::id(), "playlist_id" => $request->playlist],
            ['created_at'=>now(), 'updated_at'=>now(), 'created_at'=>now(), ]
        );
        echo json_encode( "Added $request->playlist to crate!" );
    }

    public function playlist_remove ( Request $request ) {
        $_user = User::where("id", "=", Auth::id())->first();
        User_crates::where('locale_user_id', Auth::id() )->where("playlist_id", $request->playlist)->delete();
        echo json_encode("Removed $request->playlist from crate!");
    }

    private function playlist_check_crate ( $playlists ) {
        $_output_playlists = array();
        foreach( $playlists as $playlist ):
            $_single_playlist = $playlist;
            $_single_playlist->inCrate = $this->playlist_isin_crate( $_single_playlist->id );
            $_output_playlists[] = $_single_playlist;
        endforeach;
        return $_output_playlists;
    }
    private function playlist_isin_crate ( $playlist_id ) {
        $_playlist = User_Crates::where("playlist_id", "=", $playlist_id )->first();
        if ( is_null( $_playlist ) ) {
            return "no";
            //return "yes";
        } else {
            return "yes";
        }
    }
    private function playlist_update_10()
    {
        /**
         * get the first 10 playlists
         */
        //  connect to spotify, provide access token
        $this->spotify_connect();
        //  get playlist count
        $_user = User::where("id", "=", Auth::id())->first();
        $playlists = $this->spotify->spotify_api->getUserPlaylists($_user->spotify_user_id, [
            'limit' => 1
        ]);
        $batch = $this->playlist_get_batch(10, 0);
        foreach ($batch->items as $item):
            $playlist_name = $item->name;
            $playlist_id = $item->id;
//                $playlist_tracks = $this->spotify_api->getPlaylistTracks($playlist_id);
//                $playlist_tracks = $this->playlist_tracks_parse($playlist_tracks);
//                $playlist_tracks = json_encode($playlist_tracks);
            $playlist_tracks = "";
            Spotify_playlists::updateOrInsert(
                ['locale_user_id' => Auth::id(), "playlist_id" => $playlist_id],
                ['playlist_name' => $playlist_name,
                    'date_added' => now(),
                    'date_updated' => now(),
                    'tracks' => $playlist_tracks
                ]
            );
        endforeach;
        return $batch;

    }


    private function playlist_update_all()
    {
        /**
         * get all playlists, scrape through the list, and get them entered into the database
         */

        //  connect to spotify, provide access token
        $this->spotify_connect();
        //$_user = User::where( "id", "=", $this->user_id )->first();


        //  get playlist count
        $_user = User::where("id", "=", Auth::id())->first();
        $playlists = $this->spotify->spotify_api->getUserPlaylists($_user->spotify_user_id, [
            'limit' => 1
        ]);
        $playlist_count = $playlists->total;
        $limit = 20;
        $playlist_compile = array();
        for ($i = 0; $i < $playlist_count; $i = $i + $limit) {
            $batch = $this->playlist_get_batch($limit, $i);
            foreach ($batch->items as $item):
                $playlist_name = $item->name;
                $playlist_id = $item->id;
//                $playlist_tracks = $this->spotify_api->getPlaylistTracks($playlist_id);
//                $playlist_tracks = $this->playlist_tracks_parse($playlist_tracks);
//                $playlist_tracks = json_encode($playlist_tracks);
                $playlist_tracks = "";
                Spotify_playlists::updateOrInsert(
                    ['locale_user_id' => Auth::id(), "playlist_id" => $playlist_id],
                    ['playlist_name' => $playlist_name,
                        'date_added' => now(),
                        'date_updated' => now(),
                        'tracks' => $playlist_tracks
                    ]
                );
            endforeach;
        }

    }

    private function playlist_get_batch($limit, $offset)
    {
        /**
         * get batch of playlists
         */

        //  connect to spotify, provide access token
        $this->spotify_connect();
        //  get playlist count
        $_user = User::where("id", "=", Auth::id())->first();
        $playlists = $this->spotify->spotify_api->getUserPlaylists($_user->spotify_user_id, [
            'limit' => $limit,
            'offset' => $offset
        ]);
        return $playlists;
    }

    private function playlist_tracks_parse($given)
    {
        // create array to organize our song data, into json
        $output = array();
        foreach ($given->items as $item) {
            $output[] = $item->track;
        }
        return $output;
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

    private function spotify_update_user()
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
