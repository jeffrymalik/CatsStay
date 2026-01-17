<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCat extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'cat_id',
        'cat_type',
        'new_cat_name',
        'new_cat_breed',
        'new_cat_age',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function cat()
    {
        return $this->belongsTo(Cat::class);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public function getCatNameAttribute()
    {
        if ($this->cat_type === 'registered' && $this->cat) {
            return $this->cat->name;
        }
        
        return $this->new_cat_name;
    }

    public function getCatBreedAttribute()
    {
        if ($this->cat_type === 'registered' && $this->cat) {
            return $this->cat->breed ?? 'Not specified';
        }
        
        return $this->new_cat_breed ?? 'Not specified';
    }
}