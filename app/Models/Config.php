<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [

        'Drive',
        'BackDirSQL',
        'BackDirFiles',
        'StorePath',
        'MySqlDir',
        'MySqlDumpDir'
    ];
}
