<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $table = 'apartments';

    protected $fillable = [
        'apartment_number',
        'block_name',
        'floor_number',
        'status',
        'notes',
    ];

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function activeResident()
    {
        return $this->hasOne(Resident::class)->latest();
    }

    public function tenants()
    {
        return $this->residents();
    }

    public function activeTenant()
    {
        return $this->activeResident();
    }

    public function getApartmentNumberAttribute()
    {
        return $this->attributes['apartment_number'] ?? $this->attributes['apartment_room_number'] ?? null;
    }

    /**
     * @param mixed $value
     */
    public function setApartmentNumberAttribute($value): void
    {
        $this->attributes['apartment_number'] = $value;
        $this->attributes['apartment_room_number'] = $value;
    }
}