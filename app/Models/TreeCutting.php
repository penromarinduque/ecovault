<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeCutting extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'name_of_client',
        'number_of_trees',
        'species',
        'location',
        'date_applied',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
