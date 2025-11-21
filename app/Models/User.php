<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',           // TAMBAHAN BARU
        'photo',          // TAMBAHAN BARU
        'is_verified',    // TAMBAHAN BARU
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',  // TAMBAHAN BARU
        ];
    }

        /**
     * Helper method: Check if user is Normal User
     *
     * @return bool
     */
    public function isNormalUser()
    {
        return $this->role === 'normal';
    }

        /**
     * Helper method: Check if user is Pet Sitter
     *
     * @return bool
     */
    public function isPetSitter()
    {
        return $this->role === 'sitter';
    }

        /**
     * Helper method: Check if user is Admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
