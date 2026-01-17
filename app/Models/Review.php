<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'sitter_id',
        'rating',
        'review_text',
        'recommendation',
        'photos',
        'sitter_reply',
        'replied_at',
        'is_approved',
        'is_hidden',
    ];

    protected $casts = [
        'photos' => 'array',
        'replied_at' => 'datetime',
        'is_approved' => 'boolean',
        'is_hidden' => 'boolean',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sitter()
    {
        return $this->belongsTo(User::class, 'sitter_id');
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    public function scopePublic($query)
    {
        return $query->approved()->visible();
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public function canBeEdited()
    {
        return $this->created_at->diffInDays(now()) <= 7;
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getRatingStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '⭐' : '☆';
        }
        return $stars;
    }

    public function hasReply()
    {
        return !empty($this->sitter_reply);
    }
}