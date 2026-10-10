<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class AvailabilitySlotSeeder extends Seeder
{
    public function run(): void
    {
        $providers = Provider::where(
            'verification_status',
            'verified'
        )->get();

        foreach ($providers as $provider) {
            $slots = [
                [
                    'start' => now()->addDay()->startOfDay()
                        ->setTime(10, 0),
                    'end' => now()->addDay()->startOfDay()
                        ->setTime(11, 0),
                ],
                [
                    'start' => now()->addDays(2)->startOfDay()
                        ->setTime(14, 0),
                    'end' => now()->addDays(2)->startOfDay()
                        ->setTime(15, 0),
                ],
            ];

            foreach ($slots as $slot) {
                AvailabilitySlot::updateOrCreate(
                    [
                        'provider_id' => $provider->id,
                        'starts_at' => $slot['start'],
                    ],
                    [
                        'ends_at' => $slot['end'],
                        'is_available' => true,
                    ]
                );
            }
        }
    }
}