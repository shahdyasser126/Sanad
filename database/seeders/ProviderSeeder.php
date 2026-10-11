<?php

namespace Database\Seeders;

use App\Models\ClinicBranch;
use App\Models\ClinicProfile;
use App\Models\DoctorProfile;
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
            // 1. Dr. Karim Mansour (Cardiology)
            [
                'type' => 'doctor',
                'name' => 'Dr. Karim Mansour - د. كريم منصور',
                'bio' => 'Professor of Cardiology & Interventional Cardiac Sciences at Kasr Al Ainy. Fellow of the Royal College of Physicians (FRCP, UK).',
                'phone' => '01000044892',
                'email' => 'karim.mansour@sanad.test',
                'website' => null,
                'address_line' => 'Tourist Area, 26th July Corridor, 6th of October City',
                'city' => '6th of October',
                'region' => 'Giza',
                'latitude' => 29.9723,
                'longitude' => 30.9458,
                'fee_min' => 450,
                'fee_max' => 550,
                'rating_average' => 4.90,
                'rating_count' => 384,
                'verification_status' => 'verified',
                'specialties' => ['Cardiology'],
                'doctor_profile' => [
                    'qualification' => 'Ph.D. in Cardiovascular Diseases, Cairo University',
                    'license_number' => 'EGY-MED-44892',
                    'affiliations' => 'Kasr Al Ainy, Dar Al Fouad Hospital',
                ],
            ],

            // 2. Dr. Salma El-Naggar (Dermatology)
            [
                'type' => 'doctor',
                'name' => 'Dr. Salma El-Naggar - د. سلمى النجار',
                'bio' => 'Consultant Dermatologist & Aesthetic Laser Specialist. Member of the American Academy of Dermatology (AAD).',
                'phone' => '01000051904',
                'email' => 'salma.naggar@sanad.test',
                'website' => null,
                'address_line' => 'Clinic Hub, North 90th St, New Cairo',
                'city' => 'New Cairo',
                'region' => 'Cairo',
                'latitude' => 30.0254,
                'longitude' => 31.4721,
                'fee_min' => 350,
                'fee_max' => 400,
                'rating_average' => 4.95,
                'rating_count' => 421,
                'verification_status' => 'verified',
                'specialties' => ['Dermatology'],
                'doctor_profile' => [
                    'qualification' => 'Doctorate in Dermatology, Cairo University',
                    'license_number' => 'EGY-MED-51904',
                    'affiliations' => 'Cairo University, DermaLife Clinic',
                ],
            ],

            // 3. Dr. Nour El-Din Sabry (Orthopedics)
            [
                'type' => 'doctor',
                'name' => 'Dr. Nour El-Din Sabry - د. نور الدين صبري',
                'bio' => 'Consultant Orthopedic & Arthroscopic Surgeon. Specialized in ACL reconstruction, knee joint repair and spine rehabilitation.',
                'phone' => '01000038102',
                'email' => 'nour.sabry@sanad.test',
                'website' => null,
                'address_line' => 'Korba Square, Heliopolis, Cairo',
                'city' => 'Heliopolis',
                'region' => 'Cairo',
                'latitude' => 30.0886,
                'longitude' => 31.3283,
                'fee_min' => 400,
                'fee_max' => 450,
                'rating_average' => 4.80,
                'rating_count' => 295,
                'verification_status' => 'verified',
                'specialties' => ['Orthopedics'],
                'doctor_profile' => [
                    'qualification' => 'M.D. Orthopedic Surgery, Ain Shams University',
                    'license_number' => 'EGY-MED-38102',
                    'affiliations' => 'Ain Shams Hospitals, Cleopatra Polyclinics',
                ],
            ],

            // 4. Dr. Sherif Barakat (Pediatrics)
            [
                'type' => 'doctor',
                'name' => 'Dr. Sherif Barakat - د. شريف بركات',
                'bio' => 'Senior Consultant of Pediatric Medicine & Neonatology. Former Head of Pediatrics at Abou El-Reesh Children Hospital.',
                'phone' => '01000029401',
                'email' => 'sherif.barakat@sanad.test',
                'website' => null,
                'address_line' => 'Corniche El Nile, Maadi, Cairo',
                'city' => 'Maadi',
                'region' => 'Cairo',
                'latitude' => 29.9602,
                'longitude' => 31.2568,
                'fee_min' => 300,
                'fee_max' => 380,
                'rating_average' => 4.88,
                'rating_count' => 512,
                'verification_status' => 'verified',
                'specialties' => ['Pediatrics'],
                'doctor_profile' => [
                    'qualification' => 'M.D. Pediatrics, Cairo University (Kasr Al Ainy)',
                    'license_number' => 'EGY-MED-29401',
                    'affiliations' => 'Abou El-Reesh, As-Salam International Hospital',
                ],
            ],

            // 5. Dr. Tamer Al-Alfy (Dentistry)
            [
                'type' => 'doctor',
                'name' => 'Dr. Tamer Al-Alfy - د. تامر الألفي',
                'bio' => 'Consultant Oral & Maxillofacial Implant Surgeon. Member of ITI Basel, Switzerland. Painless computer-guided implants.',
                'phone' => '01000018490',
                'email' => 'tamer.alfy@sanad.test',
                'website' => null,
                'address_line' => '15 Brazil St, Zamalek, Cairo',
                'city' => 'Zamalek',
                'region' => 'Cairo',
                'latitude' => 30.0617,
                'longitude' => 31.2198,
                'fee_min' => 300,
                'fee_max' => 350,
                'rating_average' => 4.96,
                'rating_count' => 310,
                'verification_status' => 'verified',
                'specialties' => ['Dentistry'],
                'doctor_profile' => [
                    'qualification' => 'Master of Dental Surgery (MDS), Cairo University',
                    'license_number' => 'EGY-DEN-18490',
                    'affiliations' => 'Cure Dental Centers, ITI Switzerland',
                ],
            ],

            // 6. Dr. Amira Khalil (Ophthalmology)
            [
                'type' => 'doctor',
                'name' => 'Dr. Amira Khalil - د. أميرة خليل',
                'bio' => 'Consultant Ophthalmologist & Femto-LASIK Specialist. Fellow of the Royal College of Surgeons of Edinburgh (FRCS).',
                'phone' => '01000049120',
                'email' => 'amira.khalil@sanad.test',
                'website' => null,
                'address_line' => '109 El Tahrir St, Dokki, Giza',
                'city' => 'Dokki',
                'region' => 'Giza',
                'latitude' => 30.0384,
                'longitude' => 31.2120,
                'fee_min' => 400,
                'fee_max' => 450,
                'rating_average' => 4.87,
                'rating_count' => 260,
                'verification_status' => 'verified',
                'specialties' => ['Ophthalmology'],
                'doctor_profile' => [
                    'qualification' => 'FRCS Ophthalmology, Edinburgh',
                    'license_number' => 'EGY-MED-49120',
                    'affiliations' => 'Magrabi Eye Hospital, Ain Shams University',
                ],
            ],

            // 7. Dr. Hazem Abdel Rahim (Gastroenterology)
            [
                'type' => 'doctor',
                'name' => 'Dr. Hazem Abdel Rahim - د. حازم عبد الرحيم',
                'bio' => 'Consultant Gastroenterologist & Endoscopist at Kasr Al Ainy. IBS, GERD acid reflux and digestive disease specialist.',
                'phone' => '01000035012',
                'email' => 'hazem.abdelrahim@sanad.test',
                'website' => null,
                'address_line' => 'Makram Ebeid St, Nasr City, Cairo',
                'city' => 'Nasr City',
                'region' => 'Cairo',
                'latitude' => 30.0571,
                'longitude' => 31.3414,
                'fee_min' => 350,
                'fee_max' => 400,
                'rating_average' => 4.82,
                'rating_count' => 330,
                'verification_status' => 'verified',
                'specialties' => ['Gastroenterology', 'Internal Medicine'],
                'doctor_profile' => [
                    'qualification' => 'M.D. Internal Medicine & Hepatology, Cairo University',
                    'license_number' => 'EGY-MED-35012',
                    'affiliations' => 'Kasr Al Ainy, Cleopatra Clinics',
                ],
            ],

            // 8. Dr. Walid Shaker (Neurology)
            [
                'type' => 'doctor',
                'name' => 'Dr. Walid Shaker - د. وليد شاكر',
                'bio' => 'Consultant Neurologist. Chronic migraine, nerve conduction studies, epilepsy and neuropathy management.',
                'phone' => '01000040112',
                'email' => 'walid.shaker@sanad.test',
                'website' => null,
                'address_line' => 'Zayed Medical Center, Sheikh Zayed City',
                'city' => 'Sheikh Zayed',
                'region' => 'Giza',
                'latitude' => 30.0531,
                'longitude' => 30.9634,
                'fee_min' => 400,
                'fee_max' => 450,
                'rating_average' => 4.81,
                'rating_count' => 195,
                'verification_status' => 'verified',
                'specialties' => ['Neurology'],
                'doctor_profile' => [
                    'qualification' => 'M.D. Neurology, Ain Shams University',
                    'license_number' => 'EGY-MED-40112',
                    'affiliations' => 'Ain Shams Hospitals, Dar Al Fouad Clinics',
                ],
            ],

            // 9. Dr. Mona Zein (Ophthalmology - Alexandria)
            [
                'type' => 'doctor',
                'name' => 'Dr. Mona Zein - د. منى زين',
                'bio' => 'Consultant Ophthalmologist & Glaucoma Specialist at Alexandria Faculty of Medicine. Fellow of the International Council of Ophthalmology (ICO).',
                'phone' => '01000037881',
                'email' => 'mona.zein@sanad.test',
                'website' => null,
                'address_line' => 'Fawzi Moaz St, Smouha, Alexandria',
                'city' => 'Smouha',
                'region' => 'Alexandria',
                'latitude' => 31.2156,
                'longitude' => 29.9482,
                'fee_min' => 350,
                'fee_max' => 400,
                'rating_average' => 4.80,
                'rating_count' => 180,
                'verification_status' => 'verified',
                'specialties' => ['Ophthalmology'],
                'doctor_profile' => [
                    'qualification' => 'M.D. Ophthalmology, Alexandria University',
                    'license_number' => 'EGY-MED-37881',
                    'affiliations' => 'Alexandria University Hospital, Magrabi Center',
                ],
            ],

            // 10. Dr. Mohamed El-Nemr (Dentistry - Mansoura)
            [
                'type' => 'doctor',
                'name' => 'Dr. Mohamed El-Nemr - د. محمد النمر',
                'bio' => 'Consultant Orthodontist & Diamond Invisalign Provider in Egypt. Clear aligners and aesthetic dentistry.',
                'phone' => '01000019800',
                'email' => 'mohamed.nemr@sanad.test',
                'website' => null,
                'address_line' => 'El Gomhouria St, Mansoura Center, Dakahlia',
                'city' => 'Mansoura',
                'region' => 'Dakahlia',
                'latitude' => 31.0421,
                'longitude' => 31.3785,
                'fee_min' => 300,
                'fee_max' => 350,
                'rating_average' => 4.88,
                'rating_count' => 275,
                'verification_status' => 'verified',
                'specialties' => ['Dentistry'],
                'doctor_profile' => [
                    'qualification' => 'M.D. Orthodontics, Mansoura University',
                    'license_number' => 'EGY-DEN-19800',
                    'affiliations' => 'Mansoura University, Cure Dental Center',
                ],
            ],

            // 11. Cleopatra Specialized Polyclinics (Clinic)
            [
                'type' => 'clinic',
                'name' => 'Cleopatra Specialized Polyclinics - عيادات كليوباترا التخصصية',
                'bio' => 'JCI-accredited premier healthcare center delivering comprehensive multi-specialty care with elite Egyptian consultants.',
                'phone' => '19668',
                'email' => 'cleopatra@sanad.test',
                'website' => 'https://cleopatrahospitals.com',
                'address_line' => '39 Cleopatra St, Korba, Heliopolis, Cairo',
                'city' => 'Heliopolis',
                'region' => 'Cairo',
                'latitude' => 30.0892,
                'longitude' => 31.3289,
                'fee_min' => 300,
                'fee_max' => 650,
                'rating_average' => 4.80,
                'rating_count' => 342,
                'verification_status' => 'verified',
                'specialties' => ['Cardiology', 'Dermatology', 'Orthopedics', 'Pediatrics', 'Gastroenterology'],
                'clinic_profile' => [
                    'branches' => [
                        [
                            'name' => 'Korba Main Branch - فرع الكوربة الرئيسي',
                            'address_line' => '39 Cleopatra St, Heliopolis',
                            'city' => 'Heliopolis',
                            'region' => 'Cairo',
                            'latitude' => 30.0892,
                            'longitude' => 31.3289,
                            'phone' => '+20 2 2414 0000',
                        ],
                        [
                            'name' => 'New Cairo Branch - فرع التجمع الخامس',
                            'address_line' => 'North 90th St, New Cairo',
                            'city' => 'New Cairo',
                            'region' => 'Cairo',
                            'latitude' => 30.0245,
                            'longitude' => 31.4715,
                            'phone' => '+20 2 2813 0000',
                        ],
                    ],
                ],
            ],

            // 12. Dar Al Fouad Clinics (Clinic)
            [
                'type' => 'clinic',
                'name' => 'Dar Al Fouad Clinics & Center - مجمع عيادات مستشفى دار الفؤاد',
                'bio' => 'Internationally recognized healthcare center of excellence for cardiology, orthopedics, oncology and specialized surgery.',
                'phone' => '16370',
                'email' => 'daralfouad@sanad.test',
                'website' => 'https://daralfouad.org',
                'address_line' => '26th of July Corridor, Tourist Area, 6th of October City',
                'city' => '6th of October',
                'region' => 'Giza',
                'latitude' => 29.9725,
                'longitude' => 30.9460,
                'fee_min' => 400,
                'fee_max' => 800,
                'rating_average' => 4.90,
                'rating_count' => 489,
                'verification_status' => 'verified',
                'specialties' => ['Cardiology', 'Orthopedics', 'Neurology', 'Internal Medicine'],
                'clinic_profile' => [
                    'branches' => [
                        [
                            'name' => '6th of October Campus - مجمع ٦ أكتوبر',
                            'address_line' => '26th July Corridor, Tourist Area',
                            'city' => '6th of October',
                            'region' => 'Giza',
                            'latitude' => 29.9725,
                            'longitude' => 30.9460,
                            'phone' => '+20 2 3824 7247',
                        ],
                        [
                            'name' => 'Nasr City Diagnostic Center - فرع مدينة نصر',
                            'address_line' => 'Youssef Abbas St, Nasr City',
                            'city' => 'Nasr City',
                            'region' => 'Cairo',
                            'latitude' => 30.0652,
                            'longitude' => 31.3280,
                            'phone' => '+20 2 2260 0000',
                        ],
                    ],
                ],
            ],

            // 13. As-Salam International Polyclinic (Clinic)
            [
                'type' => 'clinic',
                'name' => 'As-Salam International Polyclinic - عيادات السلام الدولي',
                'bio' => 'Compassionate, personalized multi-specialty clinical care with modern diagnostic suites in Maadi and New Cairo.',
                'phone' => '19885',
                'email' => 'assalam@sanad.test',
                'website' => 'https://assalamhospital.com',
                'address_line' => 'Corniche El Nile, Maadi, Cairo',
                'city' => 'Maadi',
                'region' => 'Cairo',
                'latitude' => 29.9610,
                'longitude' => 31.2570,
                'fee_min' => 350,
                'fee_max' => 700,
                'rating_average' => 4.70,
                'rating_count' => 275,
                'verification_status' => 'verified',
                'specialties' => ['Pediatrics', 'Obstetrics & Gynecology', 'Psychiatry', 'Cardiology'],
                'clinic_profile' => [
                    'branches' => [
                        [
                            'name' => 'Maadi Corniche Center - فرع كورنيش المعادي',
                            'address_line' => 'Corniche El Nile, Maadi',
                            'city' => 'Maadi',
                            'region' => 'Cairo',
                            'latitude' => 29.9610,
                            'longitude' => 31.2570,
                            'phone' => '+20 2 2524 0250',
                        ],
                    ],
                ],
            ],

            // 14. Magrabi Eye, Ear & Dental Center (Clinic)
            [
                'type' => 'clinic',
                'name' => 'Magrabi Eye, Ear & Dental Center - مراكز مغربي التخصصية',
                'bio' => 'The Middle East leader in specialized ophthalmology, audiology, ENT and cosmetic implant dentistry.',
                'phone' => '19748',
                'email' => 'magrabi@sanad.test',
                'website' => 'https://magrabi.com',
                'address_line' => '109 El Tahrir St, Dokki, Giza',
                'city' => 'Dokki',
                'region' => 'Giza',
                'latitude' => 30.0380,
                'longitude' => 31.2118,
                'fee_min' => 350,
                'fee_max' => 600,
                'rating_average' => 4.85,
                'rating_count' => 410,
                'verification_status' => 'verified',
                'specialties' => ['Ophthalmology', 'Ear, Nose & Throat (ENT)', 'Dentistry'],
                'clinic_profile' => [
                    'branches' => [
                        [
                            'name' => 'Dokki Main Center - فرع الدقي',
                            'address_line' => '109 El Tahrir St, Dokki',
                            'city' => 'Dokki',
                            'region' => 'Giza',
                            'latitude' => 30.0380,
                            'longitude' => 31.2118,
                            'phone' => '+20 2 3760 0010',
                        ],
                        [
                            'name' => 'Alexandria Smouha Branch - فرع سموحة الإسكندرية',
                            'address_line' => 'Fawzi Moaz St, Smouha',
                            'city' => 'Smouha',
                            'region' => 'Alexandria',
                            'latitude' => 31.2150,
                            'longitude' => 29.9480,
                            'phone' => '+20 3 4200 000',
                        ],
                    ],
                ],
            ],

            // 15. Unverified Test Provider (FR-SAN Requirement check)
            [
                'type' => 'doctor',
                'name' => 'Dr. Unverified Test - طبيب غير معتمد تجريبي',
                'bio' => 'Unverified pending provider for safety testing.',
                'phone' => '01000099999',
                'email' => 'unverified@sanad.test',
                'website' => null,
                'address_line' => 'Test Street',
                'city' => 'Tanta',
                'region' => 'Gharbia',
                'latitude' => 30.7900,
                'longitude' => 31.0050,
                'fee_min' => 100,
                'fee_max' => 200,
                'rating_average' => 0,
                'rating_count' => 0,
                'verification_status' => 'pending',
                'specialties' => ['Pediatrics'],
            ],
        ];

        foreach ($providers as $providerData) {
            $specialtyNames = $providerData['specialties'] ?? [];
            $doctorProfileData = $providerData['doctor_profile'] ?? null;
            $clinicProfileData = $providerData['clinic_profile'] ?? null;

            unset(
                $providerData['specialties'],
                $providerData['doctor_profile'],
                $providerData['clinic_profile']
            );

            $provider = Provider::updateOrCreate(
                [
                    'email' => $providerData['email'],
                ],
                $providerData
            );

            // Sync Specialties
            $specialtyIds = Specialty::whereIn('name', $specialtyNames)->pluck('id');
            $provider->specialties()->sync($specialtyIds);

            // Doctor Profile
            if ($doctorProfileData !== null) {
                DoctorProfile::updateOrCreate(
                    ['provider_id' => $provider->id],
                    $doctorProfileData
                );
            }

            // Clinic Profile & Branches
            if ($clinicProfileData !== null) {
                $clinicProfile = ClinicProfile::firstOrCreate([
                    'provider_id' => $provider->id,
                ]);

                if (isset($clinicProfileData['branches'])) {
                    foreach ($clinicProfileData['branches'] as $branchData) {
                        ClinicBranch::updateOrCreate(
                            [
                                'clinic_profile_id' => $clinicProfile->id,
                                'name' => $branchData['name'],
                            ],
                            $branchData
                        );
                    }
                }
            }
        }
    }
}