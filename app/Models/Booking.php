<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'schedule_id', 'reference_no', 'status',
        'total_amount', 'passenger_count', 'contact_email', 'expires_at',
        'promo_id', 'discount_amount', 'original_amount',
    ];

    protected $casts = [
        'expires_at'      => 'datetime',
        'total_amount'    => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'original_amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->reference_no)) {
                $booking->reference_no = 'BK-' . strtoupper(uniqid());
            }
        });
    }

    public function user()      { return $this->belongsTo(User::class); }
    public function schedule()  { return $this->belongsTo(Schedule::class); }
    public function tickets()   { return $this->hasMany(Ticket::class); }
    public function payment()   { return $this->hasOne(Payment::class); }
    public function payments()  { return $this->hasMany(Payment::class); }
    public function promo()     { return $this->belongsTo(Promo::class); }

    public function getHasPromoAttribute(): bool
    {
        return !is_null($this->promo_id) && $this->discount_amount > 0;
    }
}
