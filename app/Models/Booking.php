<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'sitter_id',
        'service_id',
        'booking_code',
        'start_date',
        'end_date',
        'duration',
        'delivery_method',
        'address_id',
        'special_notes',
        'status',
        'service_price',
        'delivery_fee',
        'subtotal',
        'platform_fee',
        'total_price',
        'total_cats', // NEW: total number of cats
        'confirmed_at',
        'payment_confirmed_at',
        'started_at',
        'completed_at',
        'cancelled_at',
        'cancel_reason',
        'cancelled_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'service_price' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'total_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'payment_confirmed_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sitter()
    {
        return $this->belongsTo(User::class, 'sitter_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function cats()
    {
        return $this->belongsToMany(Cat::class, 'booking_cats')
                    ->withPivot('cat_type', 'new_cat_name', 'new_cat_breed', 'new_cat_age')
                    ->withTimestamps();
    }

    public function bookingCats()
    {
        return $this->hasMany(BookingCat::class);
    }

    // NEW: Get registered cats only
    public function registeredCats()
    {
        return $this->bookingCats()->where('cat_type', 'registered')->with('cat');
    }

    // NEW: Get new cats only
    public function newCats()
    {
        return $this->bookingCats()->where('cat_type', 'new');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public static function generateBookingCode()
    {
        do {
            $code = 'BOOK-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('booking_code', $code)->exists());

        return $code;
    }

    public function calculatePricing($basePricePerDay, $duration, $deliveryMethod, $totalCats = 1)
    {
        // Price per cat per day
        $servicePrice = $basePricePerDay * $duration * $totalCats;
        $deliveryFee = $deliveryMethod === 'pickup' ? 50000 : 0;
        $subtotal = $servicePrice + $deliveryFee;
        $platformFee = $subtotal * 0.05;
        $totalPrice = $subtotal + $platformFee;

        return [
            'service_price' => $servicePrice,
            'delivery_fee' => $deliveryFee,
            'subtotal' => $subtotal,
            'platform_fee' => $platformFee,
            'total_price' => $totalPrice,
        ];
    }

    public function canBeReviewed()
    {
        return $this->status === 'completed' && !$this->review;
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'warning',
            'confirmed' => 'info',
            'payment_pending' => 'warning',
            'payment_confirmed' => 'success',
            'in_progress' => 'primary',
            'completed' => 'success',
            'reviewed' => 'success',
            'cancelled' => 'danger',
        ][$this->status] ?? 'secondary';
    }

    public function getDateRangeAttribute()
    {
        if ($this->duration == 1) {
            return $this->start_date->format('M d, Y');
        }
        
        return $this->start_date->format('M d') . ' - ' . $this->end_date->format('M d, Y');
    }

    // NEW: Get all cats (registered + new) formatted
    public function getAllCatsAttribute()
    {
        return $this->bookingCats->map(function ($bookingCat) {
            return [
                'name' => $bookingCat->cat_name,
                'breed' => $bookingCat->cat_breed,
                'age' => $bookingCat->cat_age,
                'type' => $bookingCat->cat_type,
                'photo_url' => $bookingCat->cat_type === 'registered' && $bookingCat->cat 
                    ? $bookingCat->cat->photo_url 
                    : asset('images/default-cat.jpg'),
            ];
        });
    }

    // NEW: Get cats summary text
    public function getCatsSummaryAttribute()
    {
        $count = $this->bookingCats->count();
        if ($count === 0) return 'No cats';
        if ($count === 1) return $this->bookingCats->first()->cat_name;
        
        $firstCat = $this->bookingCats->first()->cat_name;
        return "{$firstCat} + " . ($count - 1) . " more";
    }
}