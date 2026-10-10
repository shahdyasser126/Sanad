# SANAD Provider Discovery API

## 1. Overview

The Provider Discovery API allows the frontend to discover verified healthcare providers, search by provider information, filter results using multiple criteria, and retrieve detailed provider information.

The API currently supports doctors and clinics.

All endpoints are currently public and do not require authentication.

**Base URL**

```text
http://127.0.0.1:8000/api
```

## 2. List Providers

Returns a paginated list of verified healthcare providers.

```http
GET /api/providers
```

Only providers with `verification_status = verified` are included.

### Query Parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `search` | string | No | Searches provider name, bio, city, or region |
| `specialty` | string | No | Filters providers by specialty name |
| `service` | string | No | Filters providers by service name |
| `region` | string | No | Filters providers by region |
| `type` | string | No | Filters by provider type (`doctor` or `clinic`) |
| `available_at` | datetime | No | Filters providers with an available slot covering the specified date and time |

### Pagination

The listing endpoint returns 10 providers per page.

The response includes:

- `links`: URLs for the first, last, previous, and next pages.
- `meta`: Pagination information, including current page, page size, total providers, and total pages.

### Example Request

```http
GET /api/providers
```

### Example Response

The following example is based on the actual listing response. The `data` array is shortened to one provider for readability; pagination values reflect the supplied response.

```json
{
  "data": [
    {
      "id": 1,
      "type": "doctor",
      "name": "Ahmed Hassan",
      "bio": "Consultant cardiologist with experience in adult heart care.",
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
        "count": 125
      },
      "specialties": [
        {
          "id": 1,
          "name": "Cardiology"
        }
      ],
      "services": [
        {
          "id": 1,
          "name": "Cardiology Consultation"
        }
      ]
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/providers?page=1",
    "last": "http://127.0.0.1:8000/api/providers?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [],
    "path": "http://127.0.0.1:8000/api/providers",
    "per_page": 10,
    "to": 4,
    "total": 4
  },
  "success": true
}
```

Each provider in the listing may include:

- Basic provider information
- Location
- Fees
- Rating
- Specialties
- Services
- Matching information when applicable

Each service in the listing contains its `id` and `name`.

## 3. Search Providers

Searches providers using information associated with their profiles.

```http
GET /api/providers?search={term}
```

The search checks:

- `name`
- `bio`
- `city`
- `region`

Only verified providers are returned.

When matching information is available, the response includes `matched_fields` and `matching_reasons`.

### Example Request

```http
GET /api/providers?search=Ahmed
```

### Example Matching Information

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

These fields explain why a provider matched the search criteria.

## 4. Filter by Specialty

Filters providers by specialty name.

```http
GET /api/providers?specialty={specialty}
```

### Example Request

```http
GET /api/providers?specialty=Cardiology
```

Only verified providers associated with the requested specialty are returned.

### Example Matching Information

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

If no providers match, the API returns an empty `data` array.

## 5. Filter by Service

Filters providers associated with the requested service.

```http
GET /api/providers?service={service}
```

### Example Request

```http
GET /api/providers?service=Cardiology%20Consultation
```

The API returns verified providers associated with the requested service.

Services in the listing response are represented as objects containing an `id` and a `name`.

### Example Service Object

```json
{
  "id": 1,
  "name": "Cardiology Consultation"
}
```

## 6. Filter by Region

Filters providers by region.

```http
GET /api/providers?region={region}
```

### Example Request

```http
GET /api/providers?region=Gharbia
```

The API filters providers using their region information.

### Example Matching Information

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

## 7. Filter by Provider Type

Filters providers by provider type.

```http
GET /api/providers?type={type}
```

Supported provider types:

```text
doctor
clinic
```

### Example Request

```http
GET /api/providers?type=clinic
```

### Example Matching Information

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

## 8. Filter by Availability

Filters providers based on available appointment slots at a specified date and time.

```http
GET /api/providers?available_at={datetime}
```

### Example Request

```http
GET /api/providers?available_at=2026-10-11%2010:30:00
```

A provider matches when an associated availability slot satisfies all of the following conditions:

- `is_available` is `true`.
- `starts_at` is less than or equal to the requested date and time.
- `ends_at` is greater than the requested date and time.

The datetime must be in a format accepted by the API's date validation rules.

## 9. Combined Search and Filters

Multiple query parameters can be used in the same request.

### Example Request

```http
GET /api/providers?search=Ahmed&specialty=Cardiology&service=Cardiology%20Consultation&region=Gharbia&type=doctor&available_at=2026-10-11%2010:30:00
```

The API applies the supplied search and filter criteria together.

Only verified providers matching the combined criteria are returned.

### Frontend Flow

```text
Search / Filter
      |
      v
Provider List
      |
      v
Select Provider
      |
      v
Provider Details
```

## 10. Provider Details

Returns detailed information for a single verified provider.

```http
GET /api/providers/{providerId}
```

### Example Request

```http
GET /api/providers/1
```

The details response includes the fields exposed by the provider details resource, such as:

- Basic provider information
- Contact information
- Location
- Fees
- Rating
- Verification information
- Specialties
- Services
- Doctor profile information, when available
- Clinic profile and branches, when available

### Example Response

The following illustrates the response structure. Field values should match the current `ProviderDetailResource`.

```json
{
  "success": true,
  "data": {
    "id": 1,
    "type": "doctor",
    "name": "Ahmed Hassan",
    "bio": "Consultant cardiologist with experience in adult heart care.",
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
      "count": 125
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
    "services": [
      {
        "id": 1,
        "name": "Cardiology Consultation",
        "description": null
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

The contact, location, doctor profile, and service description values in this example are illustrative and should be verified against an actual details response.

### 10.1. Doctor Profile

When doctor profile information is available, the response may include:

- Qualification
- License number
- Affiliations

### 10.2. Clinic Profile and Branches

For a clinic provider, `clinic_profile` may contain its branch information.

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

The exact branch fields depend on the details resource.

## 11. Unverified Providers

Unverified providers are not publicly discoverable through the provider listing endpoint.

Statuses such as the following are excluded from public discovery:

```text
pending
expired
suspended
revoked
```

Requesting details for an unverified provider returns:

```http
404 Not Found
```

### Example Error Response

```json
{
  "success": false,
  "message": "Provider not found."
}
```

## 12. Empty Results

A valid search or filter that matches no providers returns a successful response with an empty `data` array.

### Example Request

```http
GET /api/providers?specialty=Neurology
```

### Example Response

```json
{
  "success": true,
  "data": []
}
```

The frontend can use this response to display an empty state.

## 13. Validation and Error Handling

Query parameters should use values supported by the API.

The `available_at` parameter is validated as a date when a non-empty value is supplied.

Invalid query parameters may result in a validation error, depending on the validation rules implemented by the application.

The exact status code and response body for invalid input should be confirmed against the running API before being documented as guaranteed behavior.

The frontend should distinguish between:

- Successful requests with matching providers
- Successful requests with an empty result
- Validation errors
- `404 Not Found` responses for unavailable provider details

An empty `data` array does not indicate an API error.

## 14. Frontend Integration

The recommended frontend integration flow is:

```text
GET /api/providers
        |
        v
Display Provider List
        |
        v
Apply Search / Filters
        |
        v
GET /api/providers/{id}
        |
        v
Display Provider Details
```

The frontend can use:

- `success` to determine whether the request succeeded.
- `data` to access provider information.
- `links` to navigate between pages.
- `meta` to display pagination information.
- `matched_fields` to identify matching criteria.
- `matching_reasons` to explain why a provider appeared in the results.

The frontend should handle empty results and HTTP error responses separately.

## 15. Supported Provider Types

The current Provider model supports:

```text
doctor
clinic
```

## 16. Testing

The Provider Discovery feature is covered by Laravel tests.

The last confirmed test result was:

```text
15 tests passed
60 assertions
```

Run the complete test suite with:

```powershell
php artisan test
```

The covered scenarios include:

- Verified providers appear in the listing.
- Search by provider name.
- Filtering by specialty.
- Filtering by service.
- Filtering by region.
- Filtering by provider type.
- Filtering by availability time.
- Provider details for verified providers.
- Blocking unverified provider details.
- Combined filters.
- Explainable matching.
- Doctor profile details.
- Clinic branch details.
- Service information in provider details.
- Empty search or filter results.

Run the test suite again before release to confirm the current result.

## 17. Current Scope

The current implementation focuses on Provider Discovery.

Included functionality:

```text
Provider model
Provider listing
Provider search
Specialty filtering
Service filtering
Region filtering
Provider type filtering
Availability filtering
Provider details
Doctor profile
Clinic profile and branches
Verified-provider visibility
Explainable matching
API resources
Feature tests
API documentation
```

The following features are outside the current Provider Discovery scope:

```text
Booking
Payments
Reviews
Emergency workflows
Other unrelated modules
```

These features may be developed separately as the project evolves.