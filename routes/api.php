<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RomanNumberController;
use App\Http\Controllers\Api\ShortUrlController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('register', [AuthController::class, 'register'])->middleware('throttle:5,1');

Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::apiResource('events', EventController::class)->only(['store', 'update', 'destroy'])->middleware(['auth:sanctum', 'throttle:api']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['index', 'show'])->middleware(['auth:sanctum', 'throttle:api']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['store', 'update'])->middleware(['throttle:api']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['destroy'])->middleware(['auth:sanctum', 'throttle:api']);

Route::get('gold-price', [HomeController::class, 'goldPrice'])->name('gold.price')->middleware('throttle:5,1');
Route::get('convert-to-roman', [RomanNumberController::class, 'convertToRoman'])->name('convertToRoman');
Route::post('get-our-location', [LocationController::class, 'getOurLocation'])->name('get.our.location');
Route::post('set-our-location', [LocationController::class, 'setOurLocation'])->name('set.our.location')->middleware(['auth:sanctum', 'throttle:api']);
Route::apiResource('short-url', ShortUrlController::class)->only(['index', 'store'])->middleware(['auth:sanctum', 'throttle:5,1']);
