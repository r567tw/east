<?php

use App\Http\Controllers\Api\AstroController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\GoldPriceController;
use App\Http\Controllers\Api\JWTAuthController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RomanNumberController;
use App\Http\Controllers\Api\ShortUrlController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('me', [JWTAuthController::class, 'me'])->middleware('jwt.auth');
Route::post('login', [JWTAuthController::class, 'login']);
Route::post('refresh', [JWTAuthController::class, 'refresh'])->middleware('jwt.auth');
Route::post('logout', [JWTAuthController::class, 'logout'])->middleware('jwt.auth');

Route::post('customer/register', [CustomerController::class, 'register']);

// Production Useful Routes
Route::get('gold-price', [GoldPriceController::class, 'index'])->name('gold.price')->middleware('throttle:30,1');
Route::get('astro/{name}', [AstroController::class, 'show'])->name('astro.show')->middleware('throttle:30,1');
Route::apiResource('short-url', ShortUrlController::class)->only(['index', 'store'])->middleware(['jwt.auth', 'throttle:30,1']);

// For Line Bot Custom Integration
Route::post('get-our-location', [LocationController::class, 'getOurLocation'])->name('get.our.location')->middleware(['throttle:10,1']);
Route::post('set-our-location', [LocationController::class, 'setOurLocation'])->name('set.our.location')->middleware(['jwt.auth', 'throttle:api']);
