<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'short_description',
        'description',
        'features',
        'price_note',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public function getIconClassAttribute(): string
    {
        $icons = [
            'cat-sitting' => 'fa-home',
            'grooming' => 'fa-cut',
            'home-visit' => 'fa-walking',
        ];

        return $icons[$this->slug] ?? 'fa-concierge-bell';
    }

    public function getOfferFieldAttribute(): string
    {
        return 'offers_' . str_replace('-', '_', $this->slug);
    }

    public function getPriceFieldAttribute(): string
    {
        return str_replace('-', '_', $this->slug) . '_price';
    }

    // ✅ TAMBAH METHOD BARU
    public function getDescriptionFieldAttribute(): string
    {
        return str_replace('-', '_', $this->slug) . '_description';
    }
}