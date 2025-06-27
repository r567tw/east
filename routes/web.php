<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LineWebhookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TaskController;

Route::get("/", [HomeController::class, 'home']);
Route::resource('tasks', TaskController::class);
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

Route::resource('books', BookController::class);
Route::resource('books.reviews', ReviewController::class)->only(['create', 'store'])->middleware('throttle:reviews');

Route::get('poll', [HomeController::class, 'poll'])->name('poll');
Route::get('test', [HomeController::class, 'testing'])->name('testing');

Route::post('/line/webhook', [LineWebhookController::class, 'handle'])->name('line.webhook');

Route::get('/gold-price', [HomeController::class, 'goldPrice'])->name('gold.price');
