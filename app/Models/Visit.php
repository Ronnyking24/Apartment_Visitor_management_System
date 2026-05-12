<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id',
        'tenant_id',
        'purpose',
        'check_in_time',
        'check_out_time',
        'status',
        'approved_by_tenant',
        'notes',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'approved_by_tenant' => 'boolean',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
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
