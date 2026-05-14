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
        'phone',
        'password',
        'role',
        'status',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ── Relationships ──────────────────────────────────────
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ── Role helpers ───────────────────────────────────────
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isPassenger(): bool
    {
        return in_array($this->role, ['traveler', 'business', 'tourist', 'commuter', 'corporate', 'passenger']);
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}