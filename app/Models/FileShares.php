<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileShares extends Model
{
    //

    protected $fillable = [
        'file_id',
        'shared_with_user_id',
        'shared_by_admin_id'
    ];
}
