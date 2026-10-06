<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Specialty;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            [
                'type' => 'doctor',
                'name' => 'Ahmed Hassan',
                'bio' => 'Consultant cardiologist with experience in adult heart care.',
                'phone' => '01000000001',
                'email' => 'ahmed.hassan@sanad.test',
                'website' => null,
                'address_line' => '123 El Bahr Street',
                'city' => 'Tanta',
                'region' => 'Gharbia',
                'latitude' => 30.7865,
                'longitude' => 31.0004,
                'fee_min' => 300,
                'fee_max' => 500,
                'rating_average' => 4.80,
                'rating_count' => 125,
                'verification_status' => 'verified',
                'specialties' => ['Cardiology'],
            ],

            [
                'type' => 'doctor',
                'name' => 'Mona Ali',
                'bio' => 'Dermatology specialist providing general skin care services.',
                'phone' => '01000000002',
                'email' => 'mona.ali@sanad.test',
                'website' => null,
                'address_line' => '45 Saad Zaghloul Street',
                'city' => 'Tanta',
                'region' => 'Gharbia',
                'latitude' => 30.7860,
                'longitude' => 31.0000,
                'fee_min' => 250,
                'fee_max' => 400,
                'rating_average' => 4.60,
                'rating_count' => 89,
                'verification_status' => 'verified',
                'specialties' => ['Dermatology'],
            ],

            [
                'type' => 'doctor',
                'name' => 'Karim Mostafa',
                'bio' => 'Internal medicine doctor focused on adult primary care.',
                'phone' => '01000000003',
                'email' => 'karim.mostafa@sanad.test',
                'website' => null,
                'address_line' => '20 El Galaa Street',
                'city' => 'Alexandria',
                'region' => 'Alexandria',
                'latitude' => 31.2001,
                'longitude' => 29.9187,
                'fee_min' => 200,
                'fee_max' => 350,
                'rating_average' => 4.40,
                'rating_count' => 64,
                'verification_status' => 'verified',
                'specialties' => ['Internal Medicine'],
            ],

            [
                'type' => 'doctor',
                'name' => 'Sara Mohamed',
                'bio' => 'Pediatrics specialist.',
                'phone' => '01000000004',
                'email' => 'sara.mohamed@sanad.test',
                'website' => null,
                'address_line' => '10 Al Geish Street',
                'city' => 'Tanta',
                'region' => 'Gharbia',
                'latitude' => 30.7900,
                'longitude' => 31.0050,
                'fee_min' => 200,
                'fee_max' => 300,
                'rating_average' => 0,
                'rating_count' => 0,
                'verification_status' => 'pending',
                'specialties' => ['Pediatrics'],
            ],

            [
                'type' => 'clinic',
                'name' => 'Al Hayat Medical Center',
                'bio' => 'Multi-specialty medical clinic.',
                'phone' => '01000000005',
                'email' => 'alhayat@sanad.test',
                'website' => 'https://sanad.test/clinics/alhayat',
                'address_line' => '100 El Bahr Street',
                'city' => 'Tanta',
                'region' => 'Gharbia',
                'latitude' => 30.7850,
                'longitude' => 31.0020,
                'fee_min' => 200,
                'fee_max' => 600,
                'rating_average' => 4.70,
                'rating_count' => 210,
                'verification_status' => 'verified',
                'specialties' => ['Cardiology', 'Internal Medicine', 'Pediatrics'],
            ],

            [
                'type' => 'clinic',
                'name' => 'Future Care Clinic',
                'bio' => 'Medical clinic with general and specialist services.',
                'phone' => '01000000006',
                'email' => 'futurecare@sanad.test',
                'website' => 'https://sanad.test/clinics/future-care',
                'address_line' => '55 Canal Street',
                'city' => 'Mansoura',
                'region' => 'Dakahlia',
                'latitude' => 31.0409,
                'longitude' => 31.3785,
                'fee_min' => 250,
                'fee_max' => 500,
                'rating_average' => 4.30,
                'rating_count' => 72,
                'verification_status' => 'suspended',
                'specialties' => ['Dermatology', 'Ophthalmology'],
            ],
        ];

        foreach ($providers as $providerData) {
            $specialtyNames = $providerData['specialties'];

            unset($providerData['specialties']);

            $provider = Provider::updateOrCreate(
                [
                    'email' => $providerData['email'],
                ],
                $providerData
            );

            $specialtyIds = Specialty::whereIn('name', $specialtyNames)
                ->pluck('id');

            $provider->specialties()->sync($specialtyIds);
        }
    }
}