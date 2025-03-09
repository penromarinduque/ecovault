<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ButterflySpecies extends Model
{
    //
    protected $fillable = [
        'scientific_name',
        'common_name',
        'family',
        'genus',
        'description',
        'image_url'
    ];
}
