<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    //
    protected $fillable = [
        'start_date',
        'end_date',
        'car_number',
        'people_count',
        'price',
        'user_id',
        'campground_id',
    ];
}
