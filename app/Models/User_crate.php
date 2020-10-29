<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Grimzy spatial class
 */
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;


class User_crate extends Model
{
    use HasFactory;
    use SpatialTrait;

    protected $spatialFields = [
        'location'
    ];
}
