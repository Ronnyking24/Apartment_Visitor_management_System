<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_number',
        'block_name',
        'floor_number',
        'status',
        'notes',
    ];

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function activeTenant()
    {
        return $this->hasOne(Tenant::class)->latest();
    }
}
