<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'name',
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

    public function getNameAttribute(): string
    {
        return $this->origin_country . ' → ' . $this->destination_country;
    }
}