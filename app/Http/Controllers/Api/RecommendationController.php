<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    // GET /api/recommendations?mood=happy&limit=3
    public function recommendFoods(Request $request)
    {
        $mood = strtolower(trim((string) $request->query('mood', '')));
        $limit = (int) $request->query('limit', 3);
        $limit = $limit > 0 ? min($limit, 20) : 3;

        if ($mood === '') {
            return response()->json([
                'message' => 'Mood is required. Example: /api/recommendations?mood=happy'
            ], 422);
        }

        // 1) Find mood_id
        $moodRow = DB::table('moods')->where('name', $mood)->first();
        if (!$moodRow) {
            return response()->json([
                'message' => "Mood '$mood' not found in database."
            ], 404);
        }

        // 2) Get tags mapped to this mood
        $tagIds = DB::table('mood_tag_map')
            ->where('mood_id', $moodRow->id)
            ->pluck('tag_id');

        if ($tagIds->isEmpty()) {
            return response()->json([
                'message' => "No tag mapping found for mood '$mood'. Seed mood_tag_map first."
            ], 404);
        }

        // 3) Score foods by number of matching tags
        $foods = DB::table('foods')
            ->select('foods.*', DB::raw('COUNT(food_tag.tag_id) as score'))
            ->join('food_tag', 'foods.id', '=', 'food_tag.food_id')
            ->where('foods.is_active', 1)
            ->whereIn('food_tag.tag_id', $tagIds)
            ->groupBy('foods.id')
            ->orderByDesc('score')
            ->orderBy('foods.name')
            ->limit($limit)
            ->get();

        return response()->json([
            'mood' => $mood,
            'limit' => $limit,
            'tag_ids_used' => $tagIds->values(),
            'results' => $foods
        ]);
    }
}