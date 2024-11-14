<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreeTransportPermitDetails extends Model
{
    protected $table = 'tree_transport_permit_details';

    protected $fillable = [
        'transport_permit_id',
        'number_of_trees',
        'species',
        'destination',
        'date_of_transport',
        'date_applied',
    ];

    public function permit()
    {
        return $this->belongsTo(TransportPermit::class, 'transport_permit_id');
    }
}
