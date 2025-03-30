<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('up', [HomeController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('events', EventController::class);
Route::apiResource('events.attendees', AttendeeController::class);
