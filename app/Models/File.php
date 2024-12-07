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
        'classification',
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

        FileHistory::create([
            'file_id' => $this->id,
            'action' => 'File has been archived',
            'changes' => json_encode(['attributes' => $this->file]),
            'user_id' => auth()->id() ?: 0,
        ]);
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
        return $this->hasMany(FileShares::class, 'file_id');
    }

    // Check if the file is shared with any user
    public function getIsSharedAttribute()
    {
        return $this->shares()->exists();
    }

    public function accessRequests()
    {
        return $this->hasMany(FileAccessRequests::class);
    }

    public function fileShares()
    {
        return $this->hasMany(FileShares::class);
    }

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'file_shares', 'file_id', 'shared_with_user_id')
            ->withPivot('shared_by_admin_id', 'permission');
    }

    public function histories()
    {
        return $this->hasMany(FileHistory::class);
    }

    protected static function booted()
    {
        static::created(function ($file) {
            FileHistory::create([
                'file_id' => $file->id,
                'action' => 'created',
                'changes' => json_encode(['attributes' => $file->toArray()]),
                'user_id' => auth()->id() ?: 0, // Fallback to a default user ID (0 or system user)
            ]);
        });

        // static::updated(function ($file) {
        //     FileHistory::create([
        //         'file_id' => $file->id,
        //         'action' => 'updated',
        //         'changes' => json_encode($file->getChanges()),
        //         'user_id' => auth()->id() ?: 0, // Fallback to a default user ID (0 or system user)
        //     ]);
        // });

        static::deleted(function ($file) {
            FileHistory::create([
                'file_id' => $file->id,
                'action' => 'deleted',
                'changes' => null,
                'user_id' => auth()->id() ?: 0, // Fallback to a default user ID (0 or system user)
            ]);
        });

    }
}
