<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'bio' => $this->bio,

            'location' => [
                'city' => $this->city,
                'region' => $this->region,
            ],

            'fees' => [
                'min' => $this->fee_min,
                'max' => $this->fee_max,
            ],

            'rating' => [
                'average' => $this->rating_average,
                'count' => $this->rating_count,
            ],

            'specialties' => $this->whenLoaded('specialties', function () {
                return $this->specialties
                    ->map(fn ($specialty) => [
                        'id' => $specialty->id,
                        'name' => $specialty->name,
                    ])
                    ->values();
            }),

            'services' => $this->whenLoaded('services', function () {
                return $this->services
                    ->map(fn ($service) => [
                        'id' => $service->id,
                        'name' => $service->name,
                    ])
                    ->values();
            }),

            'matched_fields' => $this->when(
                isset($this->matched_fields),
                fn () => $this->matched_fields
            ),

            'matching_reasons' => $this->when(
                isset($this->matching_reasons),
                fn () => $this->matching_reasons
            ),
        ];
    }
}