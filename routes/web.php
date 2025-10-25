<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LineWebhookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShortRedirectController;
use App\Http\Controllers\TaskController;

Route::get("/", [HomeController::class, 'home'])->name('home');

// Task routes
Route::resource('tasks', TaskController::class);
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

// Book and Review routes
Route::resource('books', BookController::class);
Route::resource('books.reviews', ReviewController::class)->only(['create', 'store'])->middleware('throttle:reviews');

Route::get('poll', [HomeController::class, 'poll'])->name('poll');

// Line Services
Route::post('/line/webhook', [LineWebhookController::class, 'handle'])->name('line.webhook');
// Short URL redirect
Route::get('s/{code}', [ShortRedirectController::class, 'redirect'])->name('short.redirect');
// Event routes
Route::get('events/{event}', [EventController::class, 'show'])->name('page.event.show');

// Presentation route
Route::get('present', [HomeController::class, 'present'])->name('present');

// ChangeLog route
Route::get('changelog', [HomeController::class, 'changelog'])->name('changelog');

// Swagger UI routes
Route::get('demo/swagger', [HomeController::class, 'swagger'])->name('demo.swagger');
Route::get('production/swagger', [HomeController::class, 'production'])->name('production.swagger');
