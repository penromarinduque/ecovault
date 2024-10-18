<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class RecentActivity extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'filename',  // New field
        'date',      // New field
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
