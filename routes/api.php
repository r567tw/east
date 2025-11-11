<?php

use App\Http\Controllers\Api\AstroController;
use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\GoldPriceController;
use App\Http\Controllers\Api\JWTAuthController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RomanNumberController;
use App\Http\Controllers\Api\RoutineTaskController;
use App\Http\Controllers\Api\ShortUrlController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Event\Runtime\PHP;

// Authentication Routes
Route::post('register', [AuthController::class, 'register'])->middleware('throttle:5,1');
Route::post('login', [JWTAuthController::class, 'login']);
Route::post('refresh', [JWTAuthController::class, 'refresh'])->middleware('jwt.auth');
Route::post('me', [JWTAuthController::class, 'me'])->middleware('jwt.auth');
Route::post('logout', [JWTAuthController::class, 'logout'])->middleware('jwt.auth');

// Event and Attendee Routes
Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::apiResource('events', EventController::class)->only(['store', 'update', 'destroy'])->middleware(['jwt.auth', 'throttle:api']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['index', 'show'])->middleware(['jwt.auth', 'throttle:api']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['store'])->middleware(['throttle:api']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['update'])->middleware(['jwt.auth', 'throttle:api']);
Route::apiResource('events.attendees', AttendeeController::class)->only(['destroy'])->middleware(['jwt.auth', 'throttle:api']);

// Production Useful Routes
Route::get('gold-price', [GoldPriceController::class, 'index'])->name('gold.price')->middleware('throttle:5,1');
Route::get('convert-to-roman', [RomanNumberController::class, 'convertToRoman'])->name('convertToRoman');
Route::get('astro/{name}', [AstroController::class, 'show'])->name('astro.show')->middleware('throttle:5,1');
Route::apiResource('short-url', ShortUrlController::class)->only(['index', 'store'])->middleware(['jwt.auth', 'throttle:30,1']);
Route::apiResource('routine-tasks', RoutineTaskController::class)->middleware(['jwt.auth', 'throttle:api']);

// For Line Bot Custom Integration
Route::post('get-our-location', [LocationController::class, 'getOurLocation'])->name('get.our.location')->middleware(['throttle:5,1']);
Route::post('set-our-location', [LocationController::class, 'setOurLocation'])->name('set.our.location')->middleware(['jwt.auth', 'throttle:api']);
