<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlaylist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('spotify_playlist', function (Blueprint $table) {
            $table->id();
            $table->string('locale_user_id');
            $table->string('playlist_name');
            $table->string('playlist_id');
            $table->point("location")->nullable();
            $table->longText('tracks')->nullable();
            $table->timestamp('date_added')->nullable();
            $table->timestamp('date_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
