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

class ExplorerController extends Controller
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
        $_recent_playlists = User_crates::orderBy('created_at', 'desc')->limit(10)->get();

        //dd($_recent_playlists);
        $output_playlists = array();
        foreach ($_recent_playlists as $playlist) {
            //$playlist->locale_user_id;
            //$playlist->playlist_id;
            $_playlist_info = Spotify_playlists::where("playlist_id", $playlist->playlist_id)->first();
//            dd($_playlist_info);
            //$_playlist_info->playlist_name;
            $_temp_spotify_api = $this->connect_as_user( $_playlist_info->locale_user_id );
            $_spotify_playlist = $_temp_spotify_api->spotify_api->getPlaylist($_playlist_info->playlist_id);
            $_spotify_playlist->inCrate = 'no';


            $output_playlists[] = $_spotify_playlist;


        }


        return view('explorer/index', [
            'playlists' => $output_playlists
        ]);
    }


    public function explorer_add (Request $request) {
        $_user = User::where("id", "=", Auth::id())->first();
        User_crates::updateOrInsert(
            ['locale_user_id' => Auth::id(), "playlist_id" => $request->playlist],
            ['created_at'=>now(), 'updated_at'=>now(), 'created_at'=>now(), ]
        );
        $_spotify_connection = $this->connect_as_user(Auth::id());
        $status = $_spotify_connection->spotify_api->followPlaylist($request->playlist);
        echo json_encode( "Followed $request->playlist" );
    }

    public function explorer_remove ( Request $request ) {
        $_user = User::where("id", "=", Auth::id())->first();
        User_crates::where('locale_user_id', Auth::id() )->where("playlist_id", $request->playlist)->delete();
        $_spotify_connection = $this->connect_as_user(Auth::id());
        $_spotify_connection->spotify_api->unfollowPlaylist($request->playlist);

        echo json_encode( "Unfollowed $request->playlist" );
    }



    private function connect_as_user($given_locale_id)
    {
        $_user = User::where("id", "=", $given_locale_id)->first();
        $_output_spotify = new SpotifyController();
        $_output_spotify->spotify_session->refreshAccessToken($_user->spotify_refresh_token);
        $_output_spotify->spotify_access_token = $_output_spotify->spotify_session->getAccessToken();
        $_output_spotify->spotify_refresh_token = $_output_spotify->spotify_session->getRefreshToken();
        User::where("id", "=", $given_locale_id)->update(array(
            'spotify_access_token' => $_output_spotify->spotify_access_token,
            'spotify_refresh_token' => $_output_spotify->spotify_refresh_token,
            'spotify_access_token_added' => now(),
            'spotify_refresh_token_added' => now()
        ));

        $_output_spotify->spotify_api->setAccessToken($_output_spotify->spotify_access_token);

        //  we have a spotify access token,
        //  update user info
        $me = $_output_spotify->spotify_api->me();
        User::where("id", "=", $given_locale_id)->update(array(
            'spotify_user_id' => $me->id
        ));

        return $_output_spotify;
    }
}
