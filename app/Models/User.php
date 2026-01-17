<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'photo',
        'is_verified',
        'bio',
        'date_of_birth',
        'gender',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'last_login_at' => 'datetime',
            'is_verified' => 'boolean',
            'password' => 'hashed',
        ];
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get user's addresses
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get user's primary address
     */
    public function primaryAddress()
    {
        return $this->hasOne(Address::class)->where('is_primary', true);
    }

    /**
     * Get user's cats
     */
    public function cats()
    {
        return $this->hasMany(Cat::class);
    }

    /**
     * Get user's active cats
     */
    public function activeCats()
    {
        return $this->hasMany(Cat::class)->where('is_active', true);
    }

    /**
     * Get sitter profile (only for sitters)
     */
    public function sitterProfile()
    {
        return $this->hasOne(PetSitterProfile::class);
    }

    /**
     * Get bookings as user (cat owner)
     */
    public function bookingsAsUser()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    /**
     * Get bookings as sitter
     */
    public function bookingsAsSitter()
    {
        return $this->hasMany(Booking::class, 'sitter_id');
    }

    /**
     * Get reviews written by user
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get reviews received (for sitters)
     */
    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'sitter_id');
    }

    /**
     * Get messages sent by user
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get messages received by user
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get payments made by user
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get payments received as sitter
     */
    public function receivedPayments()
    {
        return $this->hasMany(Payment::class, 'sitter_id');
    }

    /**
     * Get bank accounts (for sitters)
     */
    public function sitterBankAccounts()
    {
        return $this->hasMany(SitterBankAccount::class);
    }

    /**
     * Get primary bank account
     */
    public function primaryBankAccount()
    {
        return $this->hasOne(SitterBankAccount::class)->where('is_primary', true);
    }

    /**
     * Get earnings (for sitters)
     */
    public function earnings()
    {
        return $this->hasMany(SitterEarning::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeNormalUsers($query)
    {
        return $query->where('role', 'normal');
    }

    public function scopeSitters($query)
    {
        return $query->where('role', 'sitter');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    public function isNormal(): bool
    {
        return $this->role === 'normal';
    }

    public function isSitter(): bool
    {
        return $this->role === 'sitter';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=FF9800&color=fff&size=200";
    }

    public function unreadMessagesCount()
    {
        return $this->receivedMessages()->unread()->count();
    }

    public function unreadNotificationsCount()
    {
        return $this->notifications()->unread()->count();
    }

    public function getTotalEarningsAttribute()
    {
        return $this->earnings()->paid()->sum('net_earning');
    }

    public function getPendingEarningsAttribute()
    {
        return $this->earnings()->pending()->sum('net_earning');
    }
}