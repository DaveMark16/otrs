<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Promo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'discount_type',
        'discount_value',
        'promo_code',
        'start_date',
        'end_date',
        'applies_to_all',
    ];

    protected $casts = [
        'start_date'     => 'date',
        'end_date'       => 'date',
        'applies_to_all' => 'boolean',
        'discount_value' => 'decimal:2',
    ];

    // Auto-generate promo code if not provided
    protected static function booted(): void
    {
        static::creating(function (Promo $promo) {
            if (empty($promo->promo_code)) {
                $promo->promo_code = strtoupper(Str::random(4) . '-' . Str::random(4));
            } else {
                $promo->promo_code = strtoupper($promo->promo_code);
            }
        });

        static::updating(function (Promo $promo) {
            $promo->promo_code = strtoupper($promo->promo_code);
        });
    }

    // ── Relationships ────────────────────────────────────────────────
    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'promo_trip');
    }

    // ── Computed Attributes ──────────────────────────────────────────
    public function getStatusAttribute(): string
    {
        $today = Carbon::today();
        if ($today->lt($this->start_date)) return 'upcoming';
        if ($today->gt($this->end_date))   return 'expired';
        return 'active';
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    public function getFormattedDiscountAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return number_format($this->discount_value, 0) . '%';
        }
        return '₱' . number_format($this->discount_value, 2);
    }

    // ── Scopes ───────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->whereDate('start_date', '<=', today())
                     ->whereDate('end_date', '>=', today());
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('end_date', '<', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('start_date', '>', today());
    }
}
