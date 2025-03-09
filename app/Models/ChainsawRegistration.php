<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChainsawRegistration extends Model
{
    use HasFactory;
    protected $table = 'chainsaw_registrations';
    protected $fillable = [
        'file_id',
        'name_of_client',
        'location',
        'serial_number',
        'date_applied',
        'category'
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}