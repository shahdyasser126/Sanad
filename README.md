# SANAD - Provider Discovery Backend

Provider Discovery backend feature for SANAD, built with Laravel.

The feature allows users to discover verified healthcare providers, search and filter providers, and view detailed provider information.

---

## Feature Scope

This implementation covers:

- Provider listing
- Provider search
- Provider filtering
- Provider details
- Verified-provider visibility
- Specialty matching
- Service matching
- Availability-based filtering
- Explainable search and filter matching
- Doctor profile details
- Clinic profile and branches
- Empty search and filter results
- Laravel API Resources
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
- PHPUnit / Laravel Feature Tests

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
```

Requests for providers that are not publicly accessible return:

```text
404 Not Found
```

Example response:

```json
{
  "success": false,
  "message": "Provider not found."
}
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
services
provider_service
availability_slots
```

### Main Relationships

```text
Provider
├── DoctorProfile
├── ClinicProfile
│   └── ClinicBranch
├── Specialties
├── Services
└── AvailabilitySlots
```

### Services

Services are associated with providers through the `provider_service` pivot table.

Each service can include:

- Service ID
- Service name
- Service description

### Availability Slots

Availability slots represent the periods when a provider is available.

The availability filter checks whether a provider has an available slot matching the requested date and time.

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

The listing includes summary information such as:

- Provider ID
- Provider type
- Name and bio
- Location
- Fees
- Rating
- Specialties
- Services

### Search Providers

```http
GET /api/providers?search=Ahmed
```

Searches provider information using supported fields, including:

- Provider name
- Bio
- City
- Region

### Filter by Specialty

```http
GET /api/providers?specialty=Cardiology
```

Returns verified providers matching the requested specialty.

### Filter by Service

```http
GET /api/providers?service=Cardiology%20Consultation
```

Returns verified providers offering the requested service.

### Filter by Region

```http
GET /api/providers?region=Gharbia
```

Returns verified providers matching the requested region.

### Filter by Provider Type

```http
GET /api/providers?type=doctor
```

Supported values:

```text
doctor
clinic
```

### Filter by Availability

```http
GET /api/providers?available_at=2026-10-11%2010:30:00
```

Filters providers based on whether they have an available slot containing the requested date and time.

The `available_at` parameter must contain a valid date and time.

An invalid value returns a validation error.

Example error response:

```json
{
  "message": "The available at field must be a valid date.",
  "errors": {
    "available_at": [
      "The available at field must be a valid date."
    ]
  }
}
```

### Combined Search and Filters

Search and supported filters can be combined in one request.

Example:

```http
GET /api/providers?search=Ahmed&specialty=Cardiology&region=Gharbia&type=doctor
```

Example with a service filter:

```http
GET /api/providers?service=Cardiology%20Consultation&region=Gharbia
```

Example with availability:

```http
GET /api/providers?specialty=Cardiology&available_at=2026-10-11%2010:30:00
```

The returned providers must satisfy the applied filters.

### Provider Details

```http
GET /api/providers/{providerId}
```

Returns detailed information for a verified provider.

The response may include contact information, location, fees, rating, verification information, specialties, services, and the provider-specific profile.

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

These fields allow the frontend to explain why a provider matched the user's search or filters.

The matching information depends on the filters used in the request.

---

## Provider Details

The Provider Details API can return:

- Basic provider information
- Contact information
- Location and geographic coordinates
- Fees
- Rating
- Verification information
- Specialties
- Services and service descriptions
- Doctor profile information
- Clinic profile information and branches

### Doctor Profile Example

```json
{
  "doctor_profile": {
    "qualification": "M.B.B.S, M.D. Cardiology",
    "license_number": "DOC-10001",
    "affiliations": "Tanta University Hospital"
  },
  "clinic_profile": null
}
```

### Clinic Profile Example

A clinic response can include clinic profile information and its branches, depending on the returned provider data.

Example branch structure:

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

Profile fields depend on the provider type. A profile that does not apply to a provider may be returned as `null`.

---

## Empty Results

A valid request with no matching providers returns a successful response with an empty data array.

Example:

```http
GET /api/providers?specialty=Neurology
```

Example response:

```json
{
  "success": true,
  "data": []
}
```

The listing endpoint uses pagination, so its full response may also include pagination links and metadata.

The frontend can use the empty data array to display an empty state.

---

## API Documentation

Detailed API documentation is available at:

```text
docs/provider-discovery-api.md
```

It includes:

- Endpoint descriptions
- Query parameters
- Request examples
- Response examples
- Filtering behavior
- Availability filtering
- Matching explanations
- Empty results
- Unverified provider behavior
- Frontend integration flow

---

## Frontend Integration Flow

The intended discovery flow is:

```text
GET /api/providers
        |
        v
   Provider List
        |
        v
   Search / Filter
        |
        v
  Select Provider
        |
        v
GET /api/providers/{id}
        |
        v
 Provider Details
```

The frontend can use the `success` field to determine whether a request succeeded.

For search and filtering, the frontend can use:

```text
matched_fields
matching_reasons
```

to explain matching results when these fields are included in the response.

The frontend should also handle empty results and validation errors.

---

## Running the Project

### 1. Install PHP Dependencies

```powershell
composer install
```

### 2. Install Frontend Dependencies

If the project requires frontend assets:

```powershell
npm install
```

### 3. Create the Environment File

```powershell
copy .env.example .env
```

### 4. Generate the Application Key

```powershell
php artisan key:generate
```

### 5. Configure the Database

Configure the MySQL connection in `.env`.

Make sure the database exists before running migrations.

### 6. Run Migrations

```powershell
php artisan migrate
```

### 7. Seed the Database

```powershell
php artisan db:seed
```

The seeders populate the configured sample data, including Provider Discovery services and availability slots.

### 8. Start the Development Server

```powershell
php artisan serve
```

The local API is then available at:

```text
http://127.0.0.1:8000/api/providers
```

---

## Running Tests

Run the complete test suite:

```powershell
php artisan test
```

Provider Discovery test coverage includes:

- Verified providers appear in listing
- Search by provider name
- Filter by specialty
- Filter by service
- Filter by availability
- Provider details
- Blocking unverified provider details
- Combined filters
- Explainable matching
- Doctor profile details
- Clinic branch details
- Empty search and filter results
- Services included in provider details

Latest confirmed test result:

```text
15 tests passed
60 assertions
```

Run the test suite again after making changes to verify the current state of the project.

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
│   ├── Specialty.php
│   ├── Service.php
│   └── AvailabilitySlot.php
│
database/
├── migrations/
└── seeders/
    ├── ProviderSeeder.php
    ├── SpecialtySeeder.php
    ├── ServiceSeeder.php
    └── AvailabilitySlotSeeder.php
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

[https://github.com/shahdyasser126/Sanad](https://github.com/shahdyasser126/Sanad)

---

## Current Status

The Provider Discovery backend feature is implemented and the latest confirmed test run passed.

Implemented capabilities include:

- Verified-provider listing and search
- Filtering by specialty, service, region, and provider type
- Availability-based filtering using `available_at`
- Provider details for doctors and clinics
- Service descriptions
- Explainable search and filter matching
- API documentation
- Feature tests

Latest confirmed test status:

```text
15 tests passed
60 assertions
```

The implementation is ready for frontend integration and API consumption.
