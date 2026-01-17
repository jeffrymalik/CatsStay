<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetSitterProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'years_of_experience',
        // 'experience_description', // ❌ HAPUS INI
        'is_verified',
        'verified_at',
        'offers_cat_sitting',
        'offers_grooming',
        'offers_home_visit',
        'cat_sitting_price',
        'cat_sitting_description', // ✅ TAMBAH
        'grooming_price',
        'grooming_description', // ✅ TAMBAH
        'home_visit_price',
        'home_visit_description', // ✅ TAMBAH
        'max_cats_accepted',
        'home_description',
        'home_photos',
        'is_available',
        'response_time',
        'rating_average',
        'total_bookings',
        'completed_bookings',
        'total_reviews',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'offers_cat_sitting' => 'boolean',
        'offers_grooming' => 'boolean',
        'offers_home_visit' => 'boolean',
        'cat_sitting_price' => 'decimal:2',
        'grooming_price' => 'decimal:2',
        'home_visit_price' => 'decimal:2',
        'home_photos' => 'array',
        'is_available' => 'boolean',
        'rating_average' => 'decimal:2',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeOfferingService($query, $service)
    {
        $column = "offers_{$service}";
        return $query->where($column, true);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public function offersCatSitting(): bool
    {
        return $this->offers_cat_sitting;
    }

    public function offersGrooming(): bool
    {
        return $this->offers_grooming;
    }

    public function offersHomeVisit(): bool
    {
        return $this->offers_home_visit;
    }

    public function getPriceForService(string $service): ?float
    {
        $priceColumn = "{$service}_price";
        return $this->$priceColumn;
    }

    // ✅ TAMBAH METHOD BARU
    public function getDescriptionForService(string $service): ?string
    {
        $descriptionColumn = "{$service}_description";
        return $this->$descriptionColumn;
    }

    public function getCompletionRateAttribute(): float
    {
        if ($this->total_bookings === 0) {
            return 0;
        }
        
        return round(($this->completed_bookings / $this->total_bookings) * 100, 1);
    }

    public function updateStats(): void
    {
        $this->update([
            'rating_average' => $this->user->receivedReviews()->avg('rating') ?? 0,
            'total_reviews' => $this->user->receivedReviews()->count(),
            'total_bookings' => $this->user->bookingsAsSitter()->count(),
            'completed_bookings' => $this->user->bookingsAsSitter()->completed()->count(),
        ]);
    }

    public function getServicesWithPricingAttribute()
    {
        $services = [];

        if ($this->offers_cat_sitting && $this->cat_sitting_price) {
            $services[] = [
                'type' => 'cat-sitting',
                'name' => 'Cat Sitting',
                'price' => $this->cat_sitting_price,
                'description' => $this->cat_sitting_description, // ✅ TAMBAH
                'icon' => 'fa-home',
            ];
        }

        if ($this->offers_grooming && $this->grooming_price) {
            $services[] = [
                'type' => 'grooming',
                'name' => 'Grooming',
                'price' => $this->grooming_price,
                'description' => $this->grooming_description, // ✅ TAMBAH
                'icon' => 'fa-cut',
            ];
        }

        if ($this->offers_home_visit && $this->home_visit_price) {
            $services[] = [
                'type' => 'home-visit',
                'name' => 'Home Visit',
                'price' => $this->home_visit_price,
                'description' => $this->home_visit_description, // ✅ TAMBAH
                'icon' => 'fa-walking',
            ];
        }

        return $services;
    }
}