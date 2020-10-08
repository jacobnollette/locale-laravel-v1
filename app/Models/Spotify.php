<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

//  https://github.com/jwilsson/spotify-web-api-php#usage
use SpotifyWebAPI\Session;

use App\Models\User;


class Spotify extends Model
{
    use HasFactory;

    private $spotify_session;

    private static function spotify_session_new () {
        self::spotify_session = new SpotifyWebAPI\Session(
            env("SPOTIFY_CLIENT_ID" ),

            'CLIENT_SECRET',
            'REDIRECT_URI'
        );
    }

    private static function hash_spotify_token () {
        $_thing_to_hash = env("SPOTIFY_CLIENT_ID" ) . ":" . env("SPOTIFY_CLIENT_SECRET" );
        $hashed_token = base64_encode( $_thing_to_hash );
        return $hashed_token;
    }
    public static function authorize_bearer_token () {

        $_authorization_header = "Basic " . self::hash_spotify_token();
        //dd( $_authorization_header);
        $response = Http::withHeaders([
            "accept" => "application/json",
            'Authorization' => $_authorization_header
        ])->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
        ]);
        return $response;
    }
    private static function authorized_spotify_query ( $endpoint, $input ) {

    }
    public static function get_user_access_token () {
        $user_id = Auth::id();
        $user = User::where("id", "=", $user_id)->first();
        return $user->spotify_access_token;
    }
}
