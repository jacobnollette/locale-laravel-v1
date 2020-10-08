<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class Spotify extends Model
{
    use HasFactory;

    public static function get_user_access_token () {
        $user_id = Auth::id();
        $user = User::where("id", "=", $user_id)->first();
        return $user->spotify_access_token;
    }

}
