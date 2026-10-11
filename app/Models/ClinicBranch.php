<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicBranch extends Model
{
    protected $fillable = [
        'clinic_profile_id',
        'name',
        'address_line',
        'city',
        'region',
        'latitude',
        'longitude',
        'phone',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function clinicProfile(): BelongsTo
    {
        return $this->belongsTo(ClinicProfile::class);
    }
}