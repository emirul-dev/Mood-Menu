<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoodMenuController extends Controller
{
    public function index()
    {
        return view('moodmenu.index');
    }

    public function foodOptions(int $food)
    {
        $foodRow = DB::table('foods')->where('id', $food)->first();

        abort_if(!$foodRow, 404);

        return view('moodmenu.food-options', [
            'food' => $foodRow
        ]);
    }

    public function foodRecipes(int $food)
    {
        $foodRow = DB::table('foods')->where('id', $food)->first();
        abort_if(!$foodRow, 404);

        return view('moodmenu.food-recipes', [
            'food' => $foodRow
        ]);
    }

    public function foodRestaurants(int $food)
    {
        $foodRow = DB::table('foods')->where('id', $food)->first();
        abort_if(!$foodRow, 404);

        return view('moodmenu.food-restaurants', [
            'food' => $foodRow
        ]);
    }

    public function logRecommendation(Request $request)
    {
        $request->validate([
            'mood' => 'required|string',
            'food_ids' => 'required|array|min:1',
            'food_ids.*' => 'required|integer',
        ]);

        $userId = $request->user()->id;

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

        // 2) recommendation_logs
        $foodIds = $request->input('food_ids'); // array of ids
        foreach ($foodIds as $fid){
            DB::table('recommendation_logs')->insert([
                'mood_entry_id' => $moodEntryId,
                'food_id' => (int) $fid,
                'score' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return response()->json(['message' => 'Logged']);
    }
}