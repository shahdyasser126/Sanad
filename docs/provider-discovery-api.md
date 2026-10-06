# SANAD Provider Discovery API

## Overview

The Provider Discovery API allows the frontend to discover verified healthcare providers, search by provider information, filter results, and open provider details.

All endpoints are currently public and do not require authentication.

Base URL:

```text
/api
```

---

## Endpoints

### 1. List Providers

Returns a paginated list of verified providers.

```http
GET /api/providers
```

Only providers with:

```text
verification_status = verified
```

are included.

#### Query Parameters

| Parameter   | Type   | Required | Description                                     |
| ----------- | ------ | -------: | ----------------------------------------------- |
| `search`    | string |       No | Searches provider name, bio, city, or region    |
| `specialty` | string |       No | Filters providers by specialty name             |
| `region`    | string |       No | Filters providers by region                     |
| `type`      | string |       No | Filters by provider type (`doctor` or `clinic`) |

Results are paginated with 10 providers per page.

#### Example

```http
GET /api/providers?search=Ahmed&specialty=Cardiology&region=Gharbia&type=doctor
```

#### Example Response

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "type": "doctor",
            "name": "Ahmed Hassan",
            "bio": "Cardiology specialist.",
            "location": {
                "city": "Tanta",
                "region": "Gharbia"
            },
            "fees": {
                "min": "300.00",
                "max": "500.00"
            },
            "rating": {
                "average": "4.80",
                "count": 25
            },
            "specialties": [
                {
                    "id": 1,
                    "name": "Cardiology"
                }
            ],
            "matched_fields": [
                "specialty",
                "region",
                "type",
                "name"
            ],
            "matching_reasons": [
                "Matched specialty: Cardiology",
                "Matched region: Gharbia",
                "Matched provider type: doctor",
                "Matched name: Ahmed Hassan"
            ]
        }
    ]
}
```

The exact pagination metadata is also returned by Laravel's resource collection.

---

### 2. Search Providers

Search providers using provider information.

```http
GET /api/providers?search={term}
```

The search currently checks:

* `name`
* `bio`
* `city`
* `region`

When a provider matches, the response includes:

```text
matched_fields
matching_reasons
```

Example:

```http
GET /api/providers?search=Ahmed
```

Possible matching information:

```json
{
    "matched_fields": [
        "name"
    ],
    "matching_reasons": [
        "Matched name: Ahmed Hassan"
    ]
}
```

---

### 3. Filter by Specialty

```http
GET /api/providers?specialty={specialty}
```

Example:

```http
GET /api/providers?specialty=Cardiology
```

Only verified providers associated with the requested specialty are returned.

Matching information explains the result:

```json
{
    "matched_fields": [
        "specialty"
    ],
    "matching_reasons": [
        "Matched specialty: Cardiology"
    ]
}
```

---

### 4. Filter by Region

```http
GET /api/providers?region={region}
```

Example:

```http
GET /api/providers?region=Gharbia
```

The API filters providers using their `region` field.

The response includes:

```json
{
    "matched_fields": [
        "region"
    ],
    "matching_reasons": [
        "Matched region: Gharbia"
    ]
}
```

---

### 5. Filter by Provider Type

```http
GET /api/providers?type={type}
```

Supported values:

```text
doctor
clinic
```

Example:

```http
GET /api/providers?type=clinic
```

The response includes matching information:

```json
{
    "matched_fields": [
        "type"
    ],
    "matching_reasons": [
        "Matched provider type: clinic"
    ]
}
```

---

### 6. Combined Search and Filters

Multiple filters can be used in the same request.

Example:

```http
GET /api/providers?search=Ahmed&specialty=Cardiology&region=Gharbia&type=doctor
```

The API applies all supplied filters together.

This allows the frontend flow:

```text
Search / Filter
      ↓
Provider List
      ↓
Select Provider
      ↓
Provider Details
```

---

## 7. Provider Details

Returns the details of a single verified provider.

```http
GET /api/providers/{providerId}
```

Example:

```http
GET /api/providers/1
```

The response contains:

* Basic provider information
* Contact information
* Location
* Fees
* Rating
* Verification status
* Specialties
* Doctor profile information when available
* Clinic branches when available

#### Example Response

```json
{
    "success": true,
    "data": {
        "id": 1,
        "type": "doctor",
        "name": "Ahmed Hassan",
        "bio": "Cardiology specialist.",
        "contact": {
            "phone": "01000000001",
            "email": "ahmed@example.com",
            "website": null
        },
        "location": {
            "address_line": "100 El Bahr Street",
            "city": "Tanta",
            "region": "Gharbia",
            "latitude": "30.7850000",
            "longitude": "31.0020000"
        },
        "fees": {
            "min": "300.00",
            "max": "500.00"
        },
        "rating": {
            "average": "4.80",
            "count": 25
        },
        "verification": {
            "status": "verified",
            "verified_at": null
        },
        "specialties": [
            {
                "id": 1,
                "name": "Cardiology"
            }
        ],
        "doctor_profile": {
            "qualification": "M.B.B.S, M.D. Cardiology",
            "license_number": "DOC-10001",
            "affiliations": "Tanta University Hospital"
        },
        "clinic_profile": null
    }
}
```

For a clinic provider, `clinic_profile` contains its branches.

Example:

```json
{
    "clinic_profile": {
        "branches": [
            {
                "id": 1,
                "name": "Al Hayat Medical Center - Main Branch",
                "address_line": "100 El Bahr Street",
                "city": "Tanta",
                "region": "Gharbia",
                "latitude": "30.7850000",
                "longitude": "31.0020000",
                "phone": "01000000005"
            }
        ]
    }
}
```

---

## 8. Unverified Providers

Unverified providers are not publicly discoverable.

Providers with statuses such as:

```text
pending
expired
suspended
revoked
```

are excluded from the public listing.

Requesting details for an unverified provider returns:

```http
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

## 9. Empty Results

A valid search or filter with no matching providers returns a successful response with an empty data array.

Example:

```http
GET /api/providers?specialty=Neurology
```

Response:

```json
{
    "success": true,
    "data": []
}
```

The frontend can use this response to display an Empty State.

---

## 10. Frontend Integration

The recommended integration flow is:

```text
GET /api/providers
        ↓
Display Provider List
        ↓
Apply search / filters
        ↓
GET /api/providers/{id}
        ↓
Display Provider Details
```

The frontend can use:

```text
success
```

to determine whether the request was successful.

For search and filtering, the frontend can also use:

```text
matched_fields
matching_reasons
```

to explain why a provider matched the user's criteria.

---

## 11. Supported Provider Types

The current Provider model supports:

```text
doctor
clinic
```

---

## 12. Testing

The Provider Discovery feature is covered by Laravel Feature Tests.

Current test coverage includes:

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

Run the complete test suite with:

```powershell
php artisan test
```

Expected current result:

```text
12 tests passed
44 assertions
```

---

## 13. Current Scope

The current implementation is intentionally limited to Provider Discovery.

Included:

```text
Provider model
Provider listing
Provider search
Provider filters
Provider details
Doctor profile
Clinic profile and branches
Verified-provider visibility
Explainable matching
API resources
Feature tests
API documentation
```

Features such as booking, payments, reviews, emergency workflows, and other unrelated modules are outside the current Provider Discovery scope.
