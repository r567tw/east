<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\HomeController;
use App\Models\Attendee;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('up', [HomeController::class, 'index']);
Route::apiResource('events', EventController::class);
Route::apiResource('events.attendees', AttendeeController::class);
