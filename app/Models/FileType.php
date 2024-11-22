<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    protected $fillable = [
        'type_name',      // The name of the file type
        'classification_id', // The classification field
    ];
}
