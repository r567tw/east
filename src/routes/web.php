<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;

Route::get("/", [HomeController::class, 'home']);
Route::resource('tasks', TaskController::class);
