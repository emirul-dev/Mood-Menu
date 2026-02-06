<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\LogController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/recommendations', [RecommendationController::class, 'recommendFoods']);
Route::get('/foods/{food}/recipes', [RecipeController::class, 'recipesByFood']);
Route::get('/foods/{food}/restaurants/nearby', [LocationController::class, 'nearbyRestaurants']);
Route::post('/log/recommendation', [LogController::class, 'logRecommendation'])->middleware('auth:sanctum');