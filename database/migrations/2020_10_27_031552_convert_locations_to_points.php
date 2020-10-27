<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertLocationsToPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->point("location")->nullable();
        });

        $results = DB::table('spotify_playlists')->select('id','name')->get();


//        $table->string('location_lat')->nullable();
//        $table->string('location_long')->nullable();
        $i = 1;
        foreach ($results as $result){
            DB::table('spotify_playlists')
                ->where('id',$result->id)
                ->update([
                    "location" => array(
                        $result->location_lat,
                        $result->location_long
                    )
                ]);
            $i++;
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('points', function (Blueprint $table) {
            //
        });
    }
}
