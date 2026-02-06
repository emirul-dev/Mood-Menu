<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $foods = DB::table('foods')->pluck('id', 'name'); // name => id

        // ✅ 1 restaurant per food (Melaka-ish coords for testing)
        $restaurants = [
            [
                'food' => 'Nasi Lemak',
                'name' => 'Nasi Lemak Corner',
                'address' => 'Melaka City Centre',
                'latitude' => 2.1896,
                'longitude' => 102.2501,
                'geofence_radius_m' => 500,
            ],
            [
                'food' => 'Chicken Soup',
                'name' => 'Warm Bowl Kitchen',
                'address' => 'Jonker Street Area, Melaka',
                'latitude' => 2.1951,
                'longitude' => 102.2489,
                'geofence_radius_m' => 500,
            ],
            [
                'food' => 'Chocolate Cake',
                'name' => 'Sweet Treat Café',
                'address' => 'Mahkota Parade Area, Melaka',
                'latitude' => 2.1917,
                'longitude' => 102.2524,
                'geofence_radius_m' => 500,
            ],
            [
                'food' => 'Fruit Salad',
                'name' => 'Fresh Bowl Bar',
                'address' => 'Dataran Pahlawan Area, Melaka',
                'latitude' => 2.1908,
                'longitude' => 102.2516,
                'geofence_radius_m' => 500,
            ],
            [
                'food' => 'Iced Lemon Tea',
                'name' => 'Cooling Sips Kopitiam',
                'address' => 'Jonker Walk Area, Melaka',
                'latitude' => 2.1956,
                'longitude' => 102.2496,
                'geofence_radius_m' => 500,
            ],
            [
                'food' => 'Fried Rice',
                'name' => 'Quick Wok Diner',
                'address' => 'Melaka Raya, Melaka',
                'latitude' => 2.1929,
                'longitude' => 102.2618,
                'geofence_radius_m' => 500,
            ],
            [
                'food' => 'Oatmeal',
                'name' => 'Healthy Morning Café',
                'address' => 'Banda Hilir, Melaka',
                'latitude' => 2.1902,
                'longitude' => 102.2538,
                'geofence_radius_m' => 500,
            ],
            [
                'food' => 'Pasta Aglio Olio',
                'name' => 'Italian Simple Kitchen',
                'address' => 'Taman Kota Laksamana, Melaka',
                'latitude' => 2.1978,
                'longitude' => 102.2467,
                'geofence_radius_m' => 500,
            ],
        ];

        foreach ($restaurants as $r) {
            if (!isset($foods[$r['food']])) {
                continue;
            }

            DB::table('restaurants')->updateOrInsert(
                ['name' => $r['name'], 'address' => $r['address']],
                [
                    'food_id' => $foods[$r['food']],
                    'name' => $r['name'],
                    'address' => $r['address'],
                    'latitude' => $r['latitude'],
                    'longitude' => $r['longitude'],
                    'geofence_radius_m' => $r['geofence_radius_m'],
                    'opening_hours' => null,
                    'phone' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}