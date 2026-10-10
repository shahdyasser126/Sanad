<?php

use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('provider listing returns only verified providers', function () {
    $verifiedProvider = Provider::create([
        'type' => 'doctor',
        'name' => 'Verified Doctor',
        'bio' => 'Verified provider for testing.',
        'phone' => '01000000001',
        'email' => 'verified@test.test',
        'city' => 'Tanta',
        'region' => 'Gharbia',
        'verification_status' => 'verified',
    ]);

    $pendingProvider = Provider::create([
        'type' => 'doctor',
        'name' => 'Pending Doctor',
        'bio' => 'Pending provider for testing.',
        'phone' => '01000000002',
        'email' => 'pending@test.test',
        'city' => 'Tanta',
        'region' => 'Gharbia',
        'verification_status' => 'pending',
    ]);

    $response = $this->getJson('/api/providers');

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true);

    $providerIds = collect($response->json('data'))
        ->pluck('id')
        ->all();

    expect($providerIds)
        ->toContain($verifiedProvider->id)
        ->not->toContain($pendingProvider->id);
});

test('provider search filters results by name', function () {
    Provider::create([
        'type' => 'doctor',
        'name' => 'Ahmed Hassan',
        'bio' => 'Cardiology specialist.',
        'email' => 'ahmed@test.test',
        'verification_status' => 'verified',
    ]);

    Provider::create([
        'type' => 'doctor',
        'name' => 'Mona Ali',
        'bio' => 'Dermatology specialist.',
        'email' => 'mona@test.test',
        'verification_status' => 'verified',
    ]);

    $response = $this->getJson('/api/providers?search=Ahmed');

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true);

    $results = collect($response->json('data'));

    expect($results)->toHaveCount(1)
        ->and($results->first()['name'])->toBe('Ahmed Hassan');
});

test('provider filtering works by specialty', function () {
    $cardio = Provider::create([
        'type' => 'doctor',
        'name' => 'Ahmed Hassan',
        'bio' => 'Cardiology specialist.',
        'email' => 'ahmed@test.test',
        'verification_status' => 'verified',
    ]);

    $derma = Provider::create([
        'type' => 'doctor',
        'name' => 'Mona Ali',
        'bio' => 'Dermatology specialist.',
        'email' => 'mona@test.test',
        'verification_status' => 'verified',
    ]);

    $cardiology = \App\Models\Specialty::create([
        'name' => 'Cardiology',
    ]);

    $dermatology = \App\Models\Specialty::create([
        'name' => 'Dermatology',
    ]);

    $cardio->specialties()->attach($cardiology);
    $derma->specialties()->attach($dermatology);

    $response = $this->getJson('/api/providers?specialty=Cardiology');

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true);

    $results = collect($response->json('data'));

    expect($results)->toHaveCount(1)
        ->and($results->first()['name'])->toBe('Ahmed Hassan');
});

test('provider details returns a verified provider', function () {
    $provider = Provider::create([
        'type' => 'doctor',
        'name' => 'Ahmed Hassan',
        'bio' => 'Cardiology specialist.',
        'email' => 'ahmed@test.test',
        'verification_status' => 'verified',
    ]);

    $response = $this->getJson("/api/providers/{$provider->id}");

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.id', $provider->id)
        ->assertJsonPath('data.name', 'Ahmed Hassan')
        ->assertJsonPath('data.verification.status', 'verified');
});

test('provider details does not return an unverified provider', function () {
    $provider = Provider::create([
        'type' => 'doctor',
        'name' => 'Pending Doctor',
        'bio' => 'Pending provider for testing.',
        'email' => 'pending-details@test.test',
        'verification_status' => 'pending',
    ]);

    $response = $this->getJson("/api/providers/{$provider->id}");

    $response
        ->assertStatus(404)
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Provider not found.');
});

test('provider discovery supports combined filters', function () {
    $provider = Provider::create([
        'type' => 'doctor',
        'name' => 'Ahmed Hassan',
        'bio' => 'Cardiology specialist.',
        'email' => 'ahmed-combined@test.test',
        'city' => 'Tanta',
        'region' => 'Gharbia',
        'verification_status' => 'verified',
    ]);

    Provider::create([
        'type' => 'doctor',
        'name' => 'Mona Ali',
        'bio' => 'Cardiology specialist.',
        'email' => 'mona-combined@test.test',
        'city' => 'Tanta',
        'region' => 'Gharbia',
        'verification_status' => 'verified',
    ]);

    $cardiology = \App\Models\Specialty::create([
        'name' => 'Cardiology',
    ]);

    $provider->specialties()->attach($cardiology);

    $response = $this->getJson(
        '/api/providers?search=Ahmed&specialty=Cardiology&region=Gharbia&type=doctor'
    );

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true);

    $results = collect($response->json('data'));

    expect($results)->toHaveCount(1)
        ->and($results->first()['id'])->toBe($provider->id)
        ->and($results->first()['name'])->toBe('Ahmed Hassan');
});

test('provider discovery explains why a provider matched', function () {
    $provider = Provider::create([
        'type' => 'doctor',
        'name' => 'Ahmed Hassan',
        'bio' => 'Cardiology specialist.',
        'email' => 'ahmed-match@test.test',
        'verification_status' => 'verified',
    ]);

    $cardiology = \App\Models\Specialty::create([
        'name' => 'Cardiology',
    ]);

    $provider->specialties()->attach($cardiology);

    $response = $this->getJson('/api/providers?specialty=Cardiology');

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true);

    $result = collect($response->json('data'))->first();

    expect($result['matched_fields'])
        ->toContain('specialty');

    expect($result['matching_reasons'])
        ->toContain('Matched specialty: Cardiology');
});

test('provider details includes doctor profile information', function () {
    $provider = Provider::create([
        'type' => 'doctor',
        'name' => 'Ahmed Hassan',
        'bio' => 'Cardiology specialist.',
        'email' => 'ahmed-profile@test.test',
        'verification_status' => 'verified',
    ]);

    $doctorProfile = \App\Models\DoctorProfile::create([
        'provider_id' => $provider->id,
        'qualification' => 'M.B.B.S, M.D. Cardiology',
        'license_number' => 'DOC-10001',
        'affiliations' => 'Tanta University Hospital',
    ]);

    $response = $this->getJson("/api/providers/{$provider->id}");

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath(
            'data.doctor_profile.qualification',
            'M.B.B.S, M.D. Cardiology'
        )
        ->assertJsonPath(
            'data.doctor_profile.license_number',
            'DOC-10001'
        )
        ->assertJsonPath(
            'data.doctor_profile.affiliations',
            'Tanta University Hospital'
        );
});

test('provider details includes clinic branches', function () {
    $provider = Provider::create([
        'type' => 'clinic',
        'name' => 'Al Hayat Medical Center',
        'bio' => 'Medical center providing multiple specialties.',
        'email' => 'clinic-details@test.test',
        'verification_status' => 'verified',
    ]);

    $clinicProfile = \App\Models\ClinicProfile::create([
        'provider_id' => $provider->id,
    ]);

    \App\Models\ClinicBranch::create([
        'clinic_profile_id' => $clinicProfile->id,
        'name' => 'Al Hayat Medical Center - Main Branch',
        'address_line' => '100 El Bahr Street',
        'city' => 'Tanta',
        'region' => 'Gharbia',
        'latitude' => 30.785,
        'longitude' => 31.002,
        'phone' => '01000000005',
    ]);

    $response = $this->getJson("/api/providers/{$provider->id}");

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath(
            'data.clinic_profile.branches.0.name',
            'Al Hayat Medical Center - Main Branch'
        )
        ->assertJsonPath(
            'data.clinic_profile.branches.0.city',
            'Tanta'
        )
        ->assertJsonPath(
            'data.clinic_profile.branches.0.region',
            'Gharbia'
        );
});

test('provider discovery returns an empty result when no provider matches', function () {
    $response = $this->getJson('/api/providers?specialty=Neurology');

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonCount(0, 'data');
});
test('provider details includes services', function () {
    $provider = Provider::create([
        'type' => 'doctor',
        'name' => 'Ahmed Hassan',
        'bio' => 'Cardiology specialist.',
        'email' => 'ahmed-services@test.test',
        'verification_status' => 'verified',
    ]);

    $service = \App\Models\Service::create([
        'name' => 'Cardiology Consultation',
        'description' => 'Consultation for heart conditions.',
    ]);

    $provider->services()->attach($service->id);

    $response = $this->getJson("/api/providers/{$provider->id}");

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonPath(
            'data.services.0.name',
            'Cardiology Consultation'
        )
        ->assertJsonPath(
            'data.services.0.description',
            'Consultation for heart conditions.'
        );
});
test('provider discovery filters by service', function () {
    $cardio = Provider::create([
        'type' => 'doctor',
        'name' => 'Ahmed Hassan',
        'bio' => 'Cardiology specialist.',
        'email' => 'ahmed-service-filter@test.test',
        'verification_status' => 'verified',
    ]);

    $derma = Provider::create([
        'type' => 'doctor',
        'name' => 'Mona Ali',
        'bio' => 'Dermatology specialist.',
        'email' => 'mona-service-filter@test.test',
        'verification_status' => 'verified',
    ]);

    $cardiologyService = \App\Models\Service::create([
        'name' => 'Cardiology Consultation',
        'description' => 'Consultation for heart conditions.',
    ]);

    $dermatologyService = \App\Models\Service::create([
        'name' => 'Dermatology Consultation',
        'description' => 'Consultation for skin conditions.',
    ]);

    $cardio->services()->attach($cardiologyService);
    $derma->services()->attach($dermatologyService);

    $response = $this->getJson(
        '/api/providers?service=Cardiology'
    );

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.name', 'Ahmed Hassan')
        ->assertJsonPath(
            'data.0.services.0.name',
            'Cardiology Consultation'
        )
        ->assertJsonPath(
            'data.0.matched_fields.0',
            'service'
        );
});
test('provider discovery filters by availability time', function () {
    $availableProvider = Provider::create([
        'type' => 'doctor',
        'name' => 'Available Doctor',
        'email' => 'available-doctor@test.test',
        'verification_status' => 'verified',
    ]);

    $unavailableProvider = Provider::create([
        'type' => 'doctor',
        'name' => 'Unavailable Doctor',
        'email' => 'unavailable-doctor@test.test',
        'verification_status' => 'verified',
    ]);

    \App\Models\AvailabilitySlot::create([
        'provider_id' => $availableProvider->id,
        'starts_at' => '2026-10-11 10:00:00',
        'ends_at' => '2026-10-11 11:00:00',
        'is_available' => true,
    ]);

    \App\Models\AvailabilitySlot::create([
        'provider_id' => $unavailableProvider->id,
        'starts_at' => '2026-10-11 10:00:00',
        'ends_at' => '2026-10-11 11:00:00',
        'is_available' => false,
    ]);

    $query = http_build_query([
        'available_at' => '2026-10-11 10:30:00',
    ]);

    $response = $this->getJson("/api/providers?{$query}");

    $response
        ->assertStatus(200)
        ->assertJsonPath('success', true)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath(
            'data.0.id',
            $availableProvider->id
        )
        ->assertJsonPath(
            'data.0.matched_fields.0',
            'availability'
        )
        ->assertJsonPath(
            'data.0.matching_reasons.0',
            'Matched availability time: 2026-10-11 10:30:00'
        );
});