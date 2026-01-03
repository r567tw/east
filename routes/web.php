<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LineWebhookController;
use App\Http\Controllers\ShortRedirectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

// Task routes
Route::resource('tasks', TaskController::class);
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

// Line Services
Route::post('/line/webhook', [LineWebhookController::class, 'handle'])->name('line.webhook')->middleware('line.webhook');

// Short URL redirect
Route::get('s/{code}', [ShortRedirectController::class, 'redirect'])->name('short.redirect');

// Presentation and Portal routes
Route::get('present', [HomeController::class, 'present'])->name('present');

// ChangeLog route
Route::get('changelog', [HomeController::class, 'changelog'])->name('changelog');

// Swagger UI routes
Route::get('demo/swagger', [HomeController::class, 'demo'])->name('demo.swagger');
