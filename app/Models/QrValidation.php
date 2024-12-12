<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrValidation extends Model
{
    protected $fillable = [
        'file_id',
        'url',
        'scanned_at',
        'is_valid',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
