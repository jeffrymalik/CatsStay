<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'full_address',
        'city',
        'province',
        'postal_code',
        'latitude',
        'longitude',
        'is_primary',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_primary' => 'boolean',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public function getFormattedAddressAttribute(): string
    {
        return "{$this->full_address}, {$this->city}, {$this->province} {$this->postal_code}";
    }

    public function setAsPrimary(): void
    {
        Address::where('user_id', $this->user_id)
               ->where('id', '!=', $this->id)
               ->update(['is_primary' => false]);
        
        $this->update(['is_primary' => true]);
    }
}