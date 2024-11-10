<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreeCuttingPermitDetail extends Model
{

    protected $table = 'tree_cutting_permit_details';

    protected $fillable = [
        'tree_cutting_permit_id',
        'number_of_trees',
        'species',
        'location',
        'date_applied',
    ];

    public function permit()
    {
        return $this->belongsTo(TreeCuttingPermit::class, 'tree_cutting_permit_id');
    }
}
