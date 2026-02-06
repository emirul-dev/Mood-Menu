<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavedItemController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $saved = DB::table('saved_items')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        $recipeIds = $saved->where('saveable_type', 'App\\Models\\Recipe')->pluck('saveable_id')->values();
        $restaurantIds = $saved->where('saveable_type', 'App\\Models\\Restaurant')->pluck('saveable_id')->values();

        $recipes = $recipeIds->isEmpty()
            ? collect()
            : DB::table('recipes')
                ->join('foods', 'foods.id', '=', 'recipes.food_id')
                ->whereIn('recipes.id', $recipeIds)
                ->select('recipes.*', 'foods.name as food_name')
                ->get()
                ->keyBy('id');

        $restaurants = $restaurantIds->isEmpty()
            ? collect()
            : DB::table('restaurants')
                ->join('foods', 'foods.id', '=', 'restaurants.food_id')
                ->whereIn('restaurants.id', $restaurantIds)
                ->select('restaurants.*', 'foods.name as food_name')
                ->get()
                ->keyBy('id');

        return view('moodmenu.saved', [
            'saved' => $saved,
            'recipes' => $recipes,
            'restaurants' => $restaurants,
        ]);
    }

    public function saveRecipe(Request $request, int $recipe)
    {
        DB::table('saved_items')->updateOrInsert(
            [
                'user_id' => $request->user()->id,
                'saveable_type' => 'App\\Models\\Recipe',
                'saveable_id' => $recipe,
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return back()->with('status', 'Recipe saved.');
    }

    public function unsaveRecipe(Request $request, int $recipe)
    {
        DB::table('saved_items')
            ->where('user_id', $request->user()->id)
            ->where('saveable_type', 'App\\Models\\Recipe')
            ->where('saveable_id', $recipe)
            ->delete();

        return back()->with('status', 'Recipe removed.');
    }

    public function saveRestaurant(Request $request, int $restaurant)
    {
        DB::table('saved_items')->updateOrInsert(
            [
                'user_id' => $request->user()->id,
                'saveable_type' => 'App\\Models\\Restaurant',
                'saveable_id' => $restaurant,
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return back()->with('status', 'Restaurant saved.');
    }

    public function unsaveRestaurant(Request $request, int $restaurant)
    {
        DB::table('saved_items')
            ->where('user_id', $request->user()->id)
            ->where('saveable_type', 'App\\Models\\Restaurant')
            ->where('saveable_id', $restaurant)
            ->delete();

        return back()->with('status', 'Restaurant removed.');
    }
}