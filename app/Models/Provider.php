<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    protected $fillable = [
        'type',
        'name',
        'bio',
        'phone',
        'email',
        'website',
        'address_line',
        'city',
        'region',
        'latitude',
        'longitude',
        'fee_min',
        'fee_max',
        'rating_average',
        'rating_count',
        'verification_status',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'fee_min' => 'decimal:2',
            'fee_max' => 'decimal:2',
            'rating_average' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    public function doctorProfile(): HasOne
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function clinicProfile(): HasOne
    {
        return $this->hasOne(ClinicProfile::class);
    }
    public function specialties(): BelongsToMany
{
    return $this->belongsToMany(Specialty::class)
        ->withTimestamps();
}
   public function services(): BelongsToMany
{
    return $this->belongsToMany(Service::class)
        ->withTimestamps();
}
public function availabilitySlots(): HasMany
{
    return $this->hasMany(AvailabilitySlot::class);
}
}