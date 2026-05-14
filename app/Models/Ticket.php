<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'booking_id', 'ticket_no', 'passenger_name', 'seat_no',
        'fare_class', 'status', 'issued_at'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}