<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ButterflyDetails extends Model
{
    protected $fillable = ['file_id', 'butterfly_id', 'quantity'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function butterfly()
    {
        return $this->belongsTo(ButterflySpecies::class);
    }
}
