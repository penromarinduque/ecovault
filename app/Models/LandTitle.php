<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandTitle extends Model
{
    use HasFactory;

    protected $table = 'land_titles';
    protected $fillable = [
        'file_id',
        'name_of_client',
        'location',
        'lot_number',
        'property_category',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}