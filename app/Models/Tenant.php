<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

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

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
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
