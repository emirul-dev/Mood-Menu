<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    // GET /api/foods/{food}/recipes
    public function recipesByFood(int $food)
    {
        $recipes = DB::table('recipes')
            ->where('food_id', $food)
            ->orderBy('title')
            ->get();

        return response()->json([
            'food_id' => $food,
            'results' => $recipes
        ]);
    }
}