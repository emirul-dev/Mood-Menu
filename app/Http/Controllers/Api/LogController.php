<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    // POST /api/log/recommendation
    public function logRecommendation(Request $request)
    {
        $request->validate([
            'mood' => 'required|string',
            'food_ids' => 'required|array',
            'food_ids.*' => 'integer',
        ]);

        $userId = $request->user()?->id; // if called from web session, might be null in api guard
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $moodName = strtolower(trim($request->input('mood')));
        $moodId = DB::table('moods')->where('name', $moodName)->value('id');

        if (!$moodId) {
            return response()->json(['message' => 'Mood not found'], 404);
        }

        // 1) mood_entries
        $moodEntryId = DB::table('mood_entries')->insertGetId([
            'user_id' => $userId,
            'mood_id' => $moodId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2) recommendation_logs (store JSON list of food ids)
        DB::table('recommendation_logs')->insert([
            'user_id' => $userId,
            'mood_entry_id' => $moodEntryId,
            'recommended_food_ids' => json_encode($request->input('food_ids')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Logged', 'mood_entry_id' => $moodEntryId]);
    }
}