<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $table = 'residents';

    protected $fillable = [
        'user_id',
        'apartment_id',
        'phone',
        'national_id',
        'gender',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function apartmentRoom()
    {
        return $this->apartment();
    }

    public function getApartmentIdAttribute()
    {
        return $this->attributes['apartment_id'] ?? $this->attributes['apartment_room_id'] ?? null;
    }

    /**
     * @param mixed $value
     */
    public function setApartmentIdAttribute($value): void
    {
        $this->attributes['apartment_id'] = $value;
    }

    public function apartment()
    {
        // Support both pre-migration and post-migration column names.
        // Prefer the new column when it actually has a value, otherwise use the legacy one.
        $fk = !empty($this->attributes['apartment_id']) ? 'apartment_id' : 'apartment_room_id';
        return $this->belongsTo(Apartment::class, $fk);
    }

    public function getApartmentDisplayAttribute(): ?string
    {
        $apartmentId = $this->attributes['apartment_id'] ?? $this->attributes['apartment_room_id'] ?? null;

        if (!$apartmentId) {
            return null;
        }

        $apartment = Apartment::find($apartmentId);

        return $apartment?->apartment_number;
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function activeVisits()
    {
        return $this->hasMany(Visit::class)->where('status', 'active');
    }
}