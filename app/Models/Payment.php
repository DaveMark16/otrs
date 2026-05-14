<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id', 'method', 'amount', 'currency', 'status',
        'attempts', 'transaction_ref', 'paid_at', 'refund_date',
        'refund_reason', 'refund_ref',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'refund_date' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}