<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LineWebhookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShortRedirectController;
use App\Http\Controllers\TaskController;

Route::get("/", [HomeController::class, 'home']);
Route::resource('tasks', TaskController::class);
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

Route::resource('books', BookController::class);
Route::resource('books.reviews', ReviewController::class)->only(['create', 'store'])->middleware('throttle:reviews');

Route::get('poll', [HomeController::class, 'poll'])->name('poll');

Route::post('/line/webhook', [LineWebhookController::class, 'handle'])->name('line.webhook');
Route::get('s/{code}', [ShortRedirectController::class, 'redirect'])->name('short.redirect');

Route::get('events/{event}', [EventController::class, 'show'])->name('page.event.show');

Route::get('present', [HomeController::class, 'present'])->name('present');
Route::get('swagger', [HomeController::class, 'swagger'])->name('swagger');
Route::get('production/swagger', [HomeController::class, 'production'])->name('production.swagger');
