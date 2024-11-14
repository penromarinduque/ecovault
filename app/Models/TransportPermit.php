<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportPermit extends Model
{
    use HasFactory;

    protected $table = 'transport_permits';
    protected $fillable = [
        'file_id',
        'name_of_client',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function details()
    {
        return $this->hasMany(TreeTransportPermitDetails::class);
    }
}
