<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'bio' => $this->bio,

            'contact' => [
                'phone' => $this->phone,
                'email' => $this->email,
                'website' => $this->website,
            ],

            'location' => [
                'address_line' => $this->address_line,
                'city' => $this->city,
                'region' => $this->region,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],

            'fees' => [
                'min' => $this->fee_min,
                'max' => $this->fee_max,
            ],

            'rating' => [
                'average' => $this->rating_average,
                'count' => $this->rating_count,
            ],

            'verification' => [
                'status' => $this->verification_status,
                'verified_at' => $this->verified_at,
            ],

            'specialties' => $this->whenLoaded('specialties', function () {
                return $this->specialties
                    ->map(fn ($specialty) => [
                        'id' => $specialty->id,
                        'name' => $specialty->name,
                    ])
                    ->values();
            }),

            'doctor_profile' => $this->whenLoaded(
                'doctorProfile',
                fn () => $this->doctorProfile ? [
                    'qualification' => $this->doctorProfile->qualification,
                    'license_number' => $this->doctorProfile->license_number,
                    'affiliations' => $this->doctorProfile->affiliations,
                ] : null
            ),

            'clinic_profile' => $this->whenLoaded(
                'clinicProfile',
                fn () => $this->clinicProfile ? [
                    'branches' => $this->clinicProfile->branches
                        ->map(fn ($branch) => [
                            'id' => $branch->id,
                            'name' => $branch->name,
                            'address_line' => $branch->address_line,
                            'city' => $branch->city,
                            'region' => $branch->region,
                            'latitude' => $branch->latitude,
                            'longitude' => $branch->longitude,
                            'phone' => $branch->phone,
                        ])
                        ->values(),
                ] : null
            ),
        ];
    }
}