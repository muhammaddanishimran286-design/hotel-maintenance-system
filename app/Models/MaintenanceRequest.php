<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'urgency',
        'status',
        'image',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    // Relationships - FIXED with foreign key
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->hasOne(MaintenanceTask::class, 'request_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Scopes (for filtering)
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
