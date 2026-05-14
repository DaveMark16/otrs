<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'origin',
        'destination',
        'origin_country',
        'destination_country',
        'type',
        'operator',
        'status',
        'max_passengers',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'promo_trip');
    }

    public function getRouteLabelAttribute(): string
    {
        return $this->origin_country . ' → ' . $this->destination_country;
    }

    // Renamed from getNameAttribute to avoid overriding the 'name' DB column.
    // Use $trip->display_name in views instead of $trip->name.
    public function getDisplayNameAttribute(): string
    {
        return $this->origin_country . ' → ' . $this->destination_country;
    }
}