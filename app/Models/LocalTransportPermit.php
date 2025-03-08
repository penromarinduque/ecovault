<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalTransportPermit extends Model
{
    use HasFactory;
    protected $table = 'local_transport_permits';
    protected $fillable = [
        'file_id',
        'name_of_client',
        'business_farm_name',
        'butterfly_permt_number',
        'destination',
        'date_applied',
        'classification',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}

