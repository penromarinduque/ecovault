<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\file_access_requests;
use App\Models\file_shares;
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'permit_type',
        'land_category',
        'municipality',
        'report_type',
        'file_name',
        'file_path',
        'office_source',
        'category',
        'classification',
        'status',
        'user_id',
        'is_archived',
        'archived_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function treeCuttingPermits()
    {
        return $this->hasMany(TreeCuttingPermit::class);
    }

    public function chainsawRegistrations()
    {
        return $this->hasMany(ChainsawRegistration::class);
    }

    public function treePlantationRegistrations()
    {
        return $this->hasMany(TreePlantation::class);
    }

    public function transportPermits()
    {
        return $this->hasMany(TransportPermit::class);
    }

    public function landTitles()
    {
        return $this->hasMany(LandTitle::class);
    }

    public function archive()
    {
        $this->is_archived = true;
        $this->archived_at = now();
        $this->save();
    }

    // Check if the file is archived
    public function isArchived()
    {
        return $this->is_archived;
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'No User'; // Return the user's name or a default value if not found
    }


    public function shares()
    {
        return $this->hasMany(FileShares::class);
    }

    public function accessRequests()
    {
        return $this->hasMany(FileAccessRequests::class);
    }

}
