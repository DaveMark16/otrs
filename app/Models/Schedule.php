<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        "trip_id", "departure_at", "arrival_at",
        "capacity", "available_seats",
        "fare_class", "base_fare", "status"
    ];

    protected $casts = [
        "departure_at" => "datetime",
        "arrival_at" => "datetime",
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}