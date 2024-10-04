<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreePlantation extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'name_of_client',
        'location',
        'date_applied',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
