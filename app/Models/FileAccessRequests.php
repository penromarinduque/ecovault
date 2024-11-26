<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileAccessRequests extends Model
{
    protected $fillable = [
        'file_id',
        'requested_by_user_id',
        'handled_by_admin_id',
        'status',
        'start_date',
        'expiration_date',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by_user_id');
    }

    public function handledBy()
    {
        return $this->belongsTo(User::class, 'handled_by_admin_id');
    }
}
