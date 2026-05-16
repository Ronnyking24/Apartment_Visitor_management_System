<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id',
        'resident_id',
        'purpose',
        'check_in_time',
        'check_out_time',
        'status',
        'approved_by_resident',
        'notes',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'approved_by_resident' => 'boolean',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function getTenantIdAttribute()
    {
        return $this->resident_id;
    }

    /**
     * @param mixed $value
     */
    public function setTenantIdAttribute($value): void
    {
        $this->attributes['resident_id'] = $value;
    }

    public function getApprovedByTenantAttribute()
    {
        return $this->approved_by_resident;
    }

    /**
     * @param mixed $value
     */
    public function setApprovedByTenantAttribute($value): void
    {
        $this->attributes['approved_by_resident'] = $value;
    }

    public function tenant()
    {
        return $this->resident();
    }

    public function getDurationAttribute(): ?string
    {
        if ($this->check_in_time && $this->check_out_time) {
            $diff = $this->check_in_time->diff($this->check_out_time);
            return $diff->format('%H:%I:%S');
        }
        return null;
    }
}
