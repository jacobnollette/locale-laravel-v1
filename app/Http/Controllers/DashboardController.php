<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Dashboard;
use App\Models\Spotify;
use App\Models\Spotify_playlists;

/**
 * packages
 */

//  spotify api wrapper - https://github.com/jwilsson/spotify-web-api-php#usage
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class DashboardController extends Controller
{

    /**
     *  Crucial spotify secrets
     */
    private $client_id;
    private $client_secret;
    private $client_hashed_token;

    private $user_id;

    private $spotify_session;
    private $spotify_api;
    private $spotify_access_token;


    function __construct()
    {

        $this->response_url_raw = 'https://locale.test/spotify/auth/response';
        $this->response_url = urlencode($this->response_url_raw);

        /**
         * Spotify objects
         */
        $this->spotify_session = new Session(
            env("SPOTIFY_CLIENT_ID"),
            env("SPOTIFY_CLIENT_SECRET"),
            $this->response_url_raw
        );

        $this->spotify_api = new SpotifyWebAPI;
    }

    public function index()
    {
        $this->user_get();
        //  connect to spotify, provide access token
        $this->spotify_connect();


        //$this->playlist_update_all();


    }


    private function playlist_update_all()
    {
        /**
         * get all playlists, scrape through the list, and get them entered into the database
         */

        $this->user_get();
        //  connect to spotify, provide access token
        $this->spotify_connect();
        //$_user = User::where( "id", "=", $this->user_id )->first();


        //  get playlist count
        $_user = User::where("id", "=", $this->user_id)->first();
        $playlists = $this->spotify_api->getUserPlaylists($_user->spotify_user_id, [
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


                $playlist_tracks = $this->spotify_api->getPlaylistTracks($playlist_id);
                $playlist_tracks = $this->playlist_tracks_parse($playlist_tracks);
                $playlist_tracks = json_encode($playlist_tracks);

                Spotify_playlists::updateOrInsert(
                    ['locale_user_id' => $this->user_id, "playlist_id" => $playlist_id],
                    ['playlist_name' => $playlist_name,
                        'date_added' => now(),
                        'date_updated' => now(),
                        'tracks' => $playlist_tracks
                    ]
                );
            endforeach;

        }


//        Spotify_playlists::updateOrInsert(
//            ['locale_user_id' => $this->user_id, "playlist_id" => $playlists->items[0]->id],
//            [   'playlist_name'     => $playlists->items[0]->name,
//                'date_added'        => now(),
//                'date_updated'      => now()
//            ]
//        );


//        $playlists->items[0]->id;
//        ;
//        dd( $playlists );


    }

    private function playlist_get_batch($limit, $offset)
    {
        /**
         * get batch of playlists
         */
        $this->user_get();
        //  connect to spotify, provide access token
        $this->spotify_connect();
        //  get playlist count
        $_user = User::where("id", "=", $this->user_id)->first();
        $playlists = $this->spotify_api->getUserPlaylists($_user->spotify_user_id, [
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
        $this->user_get();

        $_user = User::where("id", "=", $this->user_id)->first();
        if (isset($_user->spotify_refresh_token)) :
            $this->spotify_session->refreshAccessToken($_user->spotify_refresh_token);
            $this->spotify_access_token = $this->spotify_session->getAccessToken();
            $this->spotify_refresh_token = $this->spotify_session->getRefreshToken();
            User::where("id", "=", $this->user_id)->update(array(
                'spotify_access_token' => $this->spotify_access_token,
                'spotify_refresh_token' => $this->spotify_refresh_token,
                'spotify_access_token_added' => now(),
                'spotify_refresh_token_added' => now()
            ));

            $this->spotify_api->setAccessToken($this->spotify_access_token);

            //  we have a spotify access token,
            //  update user info
            $this->spotify_update_user();
        endif;

    }

    private function spotify_update_user()
    {
        //  get spotify user data & add to locale user table
        $me = $this->spotify_api->me();
        User::where("id", "=", $this->user_id)->update(array(
            'spotify_user_id' => $me->id
        ));
    }


    private function user_get()
    {
//        $user_id =
        $this->user_id = Auth::id();
        //= User::where("id", "=", $user_id)->first();
    }

}
