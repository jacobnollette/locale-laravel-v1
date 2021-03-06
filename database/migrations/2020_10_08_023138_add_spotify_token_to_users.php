<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpotifyTokenToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('spotify_access_token', 512)->nullable();
            $table->timestamp('spotify_access_token_added')->nullable();
            $table->string('spotify_refresh_token', 512)->nullable();
            $table->timestamp('spotify_refresh_token_added')->nullable();
            $table->string('spotify_user_id', 32)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
