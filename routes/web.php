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

// Book Review System routes
Route::resource('books', BookController::class);
Route::resource('books.reviews', ReviewController::class)->only(['create', 'store'])->middleware('throttle:reviews');

// Poll routes
Route::get('poll', [HomeController::class, 'poll'])->name('poll');

// BMI Page
Route::get('bmi', [HomeController::class, 'bmi'])->name('bmi');

// Line Services
Route::post('/line/webhook', [LineWebhookController::class, 'handle'])->name('line.webhook');
// Short URL redirect
Route::get('s/{code}', [ShortRedirectController::class, 'redirect'])->name('short.redirect');

// Presentation and Portal routes
Route::get('present', [HomeController::class, 'present'])->name('present');
Route::get('portal', [HomeController::class, 'portal'])->name('portal');

// ChangeLog route
Route::get('changelog', [HomeController::class, 'changelog'])->name('changelog');

// Swagger UI routes
Route::get('demo/swagger', [HomeController::class, 'demo'])->name('demo.swagger');
Route::get('production/swagger', [HomeController::class, 'production'])->name('production.swagger');
