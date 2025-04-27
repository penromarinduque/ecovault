<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreePlantation extends Model
{
    use HasFactory;
    protected $table = 'tree_plantation_registration';
    protected $fillable = [
        'file_id',
        'name_of_client',
        'number_of_trees',
        'location',
        'date_applied',
        'species',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
