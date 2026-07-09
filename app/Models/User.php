<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function assignedTasks()
    {
        return $this->hasMany(MaintenanceTask::class, 'assigned_to');
    }

    public function assignedByTasks()
    {
        return $this->hasMany(MaintenanceTask::class, 'assigned_by');
    }

    public function maintenanceNotifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Role Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager' || $this->isAdmin();
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isReceptionist()
    {
        return $this->role === 'receptionist';
    }
}
