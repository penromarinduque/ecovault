<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeSpecies extends Model
{
    use HasFactory;

    protected $table = 'tree_species';

    protected $fillable = [
        'common_name',
    ];
}
