<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Cardiology' => [
                'name' => 'Cardiology Consultation',
                'description' => 'Consultation for heart and cardiovascular conditions.',
            ],
            'Dermatology' => [
                'name' => 'Dermatology Consultation',
                'description' => 'Consultation for skin, hair, and nail conditions.',
            ],
            'Pediatrics' => [
                'name' => 'Pediatric Consultation',
                'description' => 'Healthcare consultation for children.',
            ],
            'Internal Medicine' => [
                'name' => 'Internal Medicine Consultation',
                'description' => 'Consultation for adult internal medicine conditions.',
            ],
            'Orthopedics' => [
                'name' => 'Orthopedic Consultation',
                'description' => 'Consultation for bone, joint, and muscle conditions.',
            ],
            'Ophthalmology' => [
                'name' => 'Eye Examination',
                'description' => 'Examination and consultation for eye conditions.',
            ],
        ];

        foreach ($services as $specialtyName => $serviceData) {
            $service = Service::firstOrCreate(
                ['name' => $serviceData['name']],
                ['description' => $serviceData['description']]
            );

            $providers = Provider::whereHas(
                'specialties',
                function ($query) use ($specialtyName) {
                    $query->where('name', $specialtyName);
                }
            )->get();

            foreach ($providers as $provider) {
                $provider->services()->syncWithoutDetaching([
                    $service->id,
                ]);
            }
        }
    }
}