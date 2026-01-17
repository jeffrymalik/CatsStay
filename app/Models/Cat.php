<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'breed',
        'date_of_birth',
        'gender',
        'weight',
        'personality_traits',
        'care_instructions',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingCats()
    {
        return $this->hasMany(BookingCat::class);
    }

    // Accessors
    public function getPhotoUrlAttribute()
    {
        return $this->photo 
            ? asset('storage/' . $this->photo)
            : asset('images/default-cat.png');
    }

    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }

        return $this->date_of_birth->age;
    }

    public function getAgeTextAttribute()
    {
        $age = $this->age;
        if (!$age) {
            return 'N/A';
        }

        return $age . ' ' . ($age > 1 ? 'years' : 'year');
    }
}