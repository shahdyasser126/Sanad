<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClinicProfile extends Model
{
    protected $fillable = [
        'provider_id',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(ClinicBranch::class);
    }
}