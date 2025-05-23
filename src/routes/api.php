<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\RomanNumberController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('up', [HomeController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::apiResource('events', EventController::class)->only(['store', 'update', 'destroy'])->middleware(['auth:sanctum', 'throttle:api']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['index', 'show']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['store', 'update', 'destroy'])->middleware(['auth:sanctum', 'throttle:api']);

Route::get('convert-to-roman', [RomanNumberController::class, 'convertToRoman'])->name('convertToRoman');
