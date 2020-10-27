<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Grimzy\LaravelMysqlSpatial\Types\Point;

class ConvertLocationsToPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('spotify_playlists', function (Blueprint $table) {
//            $table->point("location")->nullable();
//        });

        $results = DB::table('spotify_playlists')->select('id',"location_lat", "location_long")->get();

        $i = 1;
        foreach ($results as $result){

            $_point = new Point( $result->location_lat, $result->location_long );
            DB::table('spotify_playlists')
                ->where('id',$result->id)
                ->update([
                    "location" => $_point
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
