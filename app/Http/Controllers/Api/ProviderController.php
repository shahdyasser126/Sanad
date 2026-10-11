<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderSummaryResource;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Resources\ProviderDetailResource;
class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $specialty = trim((string) $request->query('specialty', ''));
        $region = trim((string) $request->query('region', ''));
        $type = trim((string) $request->query('type', ''));

        $providers = Provider::query()
            ->where('verification_status', 'verified')

            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('bio', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('region', 'like', "%{$search}%");
                });
            })

            ->when($specialty !== '', function ($query) use ($specialty) {
                $query->whereHas('specialties', function ($query) use ($specialty) {
                    $query->where('name', 'like', "%{$specialty}%");
                });
            })

            ->when($region !== '', function ($query) use ($region) {
                $query->where('region', 'like', "%{$region}%");
            })

            ->when($type !== '', function ($query) use ($type) {
                $query->where('type', $type);
            })

            ->with('specialties:id,name')

            ->select([
                'id',
                'type',
                'name',
                'bio',
                'city',
                'region',
                'fee_min',
                'fee_max',
                'rating_average',
                'rating_count',
            ])

            ->paginate(10);

        if ($specialty !== '') {
            $providers->getCollection()->transform(function ($provider) use ($specialty) {
                $matchedSpecialties = $provider->specialties
                    ->filter(function ($item) use ($specialty) {
                        return str_contains(
                            strtolower($item->name),
                            strtolower($specialty)
                        );
                    })
                    ->values();

                $provider->matched_fields = $matchedSpecialties
                    ->map(fn ($item) => 'specialty')
                    ->unique()
                    ->values();

                $provider->matching_reasons = $matchedSpecialties
                    ->map(fn ($item) => "Matched specialty: {$item->name}")
                    ->values();

                return $provider;
            });
        }

        if ($region !== '') {
            $providers->getCollection()->transform(function ($provider) use ($region) {
                $provider->matched_fields = collect($provider->matched_fields ?? [])
                    ->push('region')
                    ->unique()
                    ->values();

                $provider->matching_reasons = collect($provider->matching_reasons ?? [])
                    ->push("Matched region: {$provider->region}")
                    ->unique()
                    ->values();

                return $provider;
            });
        }

        if ($type !== '') {
            $providers->getCollection()->transform(function ($provider) use ($type) {
                $provider->matched_fields = collect($provider->matched_fields ?? [])
                    ->push('type')
                    ->unique()
                    ->values();

                $provider->matching_reasons = collect($provider->matching_reasons ?? [])
                    ->push("Matched provider type: {$provider->type}")
                    ->unique()
                    ->values();

                return $provider;
            });
        }

        if ($search !== '') {
            $providers->getCollection()->transform(function ($provider) use ($search) {
                $searchTerm = strtolower($search);

                $matchedFields = collect();
                $matchingReasons = collect();

                $fields = [
                    'name' => $provider->name,
                    'bio' => $provider->bio,
                    'city' => $provider->city,
                    'region' => $provider->region,
                ];

                foreach ($fields as $field => $value) {
                    if ($value !== null && str_contains(strtolower($value), $searchTerm)) {
                        $matchedFields->push($field);

                        $matchingReasons->push(
                            "Matched {$field}: {$value}"
                        );
                    }
                }

                $provider->matched_fields = collect($provider->matched_fields ?? [])
                    ->merge($matchedFields)
                    ->unique()
                    ->values();

                $provider->matching_reasons = collect($provider->matching_reasons ?? [])
                    ->merge($matchingReasons)
                    ->unique()
                    ->values();

                return $provider;
            });
        }

        return ProviderSummaryResource::collection($providers)
            ->additional([
                'success' => true,
            ]);
    }

    public function show(Provider $provider)
    {
        if ($provider->verification_status !== 'verified') {
            return response()->json([
                'success' => false,
                'message' => 'Provider not found.',
            ], 404);
        }

        $provider->load([
            'specialties:id,name',
            'doctorProfile:id,provider_id,qualification,license_number,affiliations',
            'clinicProfile.branches',
        ]);
return ProviderDetailResource::make($provider)
    ->additional([
        'success' => true,
    ]);
    }
}