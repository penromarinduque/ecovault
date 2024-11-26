<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = [
        'folder_path',
        'folder_type',
        'municipality'
    ];
}
