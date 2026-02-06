<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    // GET /api/foods/{food}/restaurants/nearby?lat=2.1896&lng=102.2501&radius_km=5
    public function nearbyRestaurants(Request $request, int $food)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');
        $radiusKm = (float) $request->query('radius_km', 5);

        if ($lat === null || $lng === null) {
            return response()->json([
                'message' => 'lat and lng are required. Example: ?lat=2.1896&lng=102.2501&radius_km=5'
            ], 422);
        }

        $lat = (float) $lat;
        $lng = (float) $lng;
        $radiusKm = $radiusKm > 0 ? min($radiusKm, 50) : 5;

        $distanceSql = "(
            6371 * acos(
                cos(radians(?)) * cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(latitude))
            )
        )";

        $restaurants = DB::table('restaurants')
            ->selectRaw("restaurants.*, {$distanceSql} AS distance_km", [$lat, $lng, $lat])
            ->where('food_id', $food)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->having('distance_km', '<=', $radiusKm)
            ->orderBy('distance_km')
            ->get();

        return response()->json([
            'food_id' => $food,
            'origin' => ['lat' => $lat, 'lng' => $lng],
            'radius_km' => $radiusKm,
            'results' => $restaurants
        ]);
    }
}