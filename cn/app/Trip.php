<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'recommend_trip_id', 'trip_name', 'score'
    ];
}
