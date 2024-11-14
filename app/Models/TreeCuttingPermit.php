<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeCuttingPermit extends Model
{
    use HasFactory;
    protected $table = 'tree_cutting_permits';
    protected $fillable = [
        'file_id',
        'name_of_client',
    ];

    /**
     * Get the file associated with the permit.
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    /**
     * Get the tree cutting details associated with the permit.
     */
    public function details()
    {
        return $this->hasMany(TreeCuttingPermitDetail::class);
    }
}
