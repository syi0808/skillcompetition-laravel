<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallary extends Model
{
    protected $fillable = [
        'image', 'thumbnail'
    ];
}
