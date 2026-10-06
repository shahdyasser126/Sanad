
# SANAD - Provider Discovery Backend

Provider Discovery backend feature for SANAD, built with Laravel.

The feature allows users to discover verified healthcare providers, search and filter providers, and open provider details.

---

## Feature Scope

This implementation covers:

- Provider listing
- Provider search
- Provider filtering
- Provider details
- Verified-provider visibility
- Specialty matching
- Explainable search/filter matching
- Doctor profile details
- Clinic profile and branches
- Empty search/filter results
- API Resources
- Feature tests
- API documentation

Features such as booking, payments, reviews, emergency workflows, and other unrelated modules are outside the current Provider Discovery scope.

---

## Tech Stack

- PHP
- Laravel
- MySQL
- Laravel Eloquent ORM
- Laravel API Resources
- Pest / PHPUnit Feature Tests

---

## Provider Types

The Provider model currently supports:

- `doctor`
- `clinic`

---

## Verification

Only verified providers are publicly discoverable.

Supported verification statuses:

- `pending`
- `verified`
- `expired`
- `suspended`
- `revoked`

Public discovery only returns providers with:

```text
verification_status = verified
````

Unverified provider details return:

```text
404 Not Found
```

---

## Database Structure

The Provider Discovery feature uses the following main tables:

```text
providers
doctor_profiles
clinic_profiles
clinic_branches
specialties
provider_specialty
```

### Main relationships

```text
Provider
 ├── DoctorProfile
 ├── ClinicProfile
 │    └── ClinicBranch
 └── Specialties
```

---

## API Endpoints

Base path:

```text
/api
```

### List Providers

```http
GET /api/providers
```

Returns a paginated list of verified providers.

### Search

```http
GET /api/providers?search=Ahmed
```

Searches:

* provider name
* bio
* city
* region

### Filter by Specialty

```http
GET /api/providers?specialty=Cardiology
```

### Filter by Region

```http
GET /api/providers?region=Gharbia
```

### Filter by Provider Type

```http
GET /api/providers?type=doctor
```

Supported values:

```text
doctor
clinic
```

### Combined Search and Filters

```http
GET /api/providers?search=Ahmed&specialty=Cardiology&region=Gharbia&type=doctor
```

### Provider Details

```http
GET /api/providers/{providerId}
```

Returns details for a verified provider.

---

## Explainable Matching

Search and filtering responses can include:

```text
matched_fields
matching_reasons
```

Example:

```json
{
    "matched_fields": [
        "specialty",
        "region"
    ],
    "matching_reasons": [
        "Matched specialty: Cardiology",
        "Matched region: Gharbia"
    ]
}
```

This allows the frontend to explain why a provider matched the user's search or filters.

---

## Provider Details

The Provider Details API can return:

* Basic provider information
* Contact information
* Location
* Fees
* Rating
* Verification information
* Specialties
* Doctor profile information
* Clinic branches

Doctor example:

```json
{
    "doctor_profile": {
        "qualification": "M.B.B.S, M.D. Cardiology",
        "license_number": "DOC-10001",
        "affiliations": "Tanta University Hospital"
    }
}
```

Clinic example:

```json
{
    "clinic_profile": {
        "branches": [
            {
                "name": "Al Hayat Medical Center - Main Branch",
                "city": "Tanta",
                "region": "Gharbia"
            }
        ]
    }
}
```

---

## Empty Results

A valid request with no matching providers returns:

```json
{
    "success": true,
    "data": []
}
```

Example:

```http
GET /api/providers?specialty=Neurology
```

The frontend can use this response to display an Empty State.

---

## API Documentation

Detailed API documentation is available at:

```text
docs/provider-discovery-api.md
```

It includes:

* Endpoint descriptions
* Query parameters
* Request examples
* Response examples
* Filtering behavior
* Matching explanations
* Empty results
* Unverified provider behavior
* Frontend integration flow

---

## Frontend Integration Flow

The intended discovery flow is:

```text
GET /api/providers
        ↓
Provider List
        ↓
Search / Filter
        ↓
Select Provider
        ↓
GET /api/providers/{id}
        ↓
Provider Details
```

The frontend can use:

```text
success
```

to determine request success.

For search and filtering:

```text
matched_fields
matching_reasons
```

can be used to explain matching results.

---

## Running the Project

Install PHP dependencies:

```powershell
composer install
```

Install frontend dependencies:

```powershell
npm install
```

Create the environment file:

```powershell
copy .env.example .env
```

Generate the application key:

```powershell
php artisan key:generate
```

Configure the MySQL database in `.env`.

Run migrations:

```powershell
php artisan migrate
```

Seed the Provider Discovery sample data:

```powershell
php artisan db:seed
```

---

## Running Tests

Run the complete test suite:

```powershell
php artisan test
```

Current Provider Discovery test coverage includes:

* Verified providers appear in listing
* Search by provider name
* Filter by specialty
* Provider details
* Blocking unverified provider details
* Combined filters
* Explainable matching
* Doctor profile details
* Clinic branch details
* Empty search/filter results

Current test result:

```text
12 tests passed
44 assertions
```

---

## Project Structure

Important Provider Discovery files:

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── ProviderController.php
│   └── Resources/
│       ├── ProviderSummaryResource.php
│       └── ProviderDetailResource.php
│
├── Models/
│   ├── Provider.php
│   ├── DoctorProfile.php
│   ├── ClinicProfile.php
│   ├── ClinicBranch.php
│   └── Specialty.php
│
database/
├── migrations/
└── seeders/
    ├── ProviderSeeder.php
    └── SpecialtySeeder.php
│
routes/
└── api.php
│
tests/
└── Feature/
    └── ProviderDiscoveryTest.php
│
docs/
└── provider-discovery-api.md
```

---

## Git

Main branch:

```text
main
```

Repository:

https://github.com/shahdyasser126/Sanad.git
---

## Current Status

Provider Discovery backend is implemented and tested.

Current test status:

```text
12 tests passed
44 assertions
```

The implementation is ready for frontend integration and API consumption.