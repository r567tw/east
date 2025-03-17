<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\Task;

Route::get("/", [HomeController::class, 'home']);



Route::get('/tasks', function () {
    $tasks = Task::all();
    return view('index', ['tasks' => $tasks]);
})->name('tasks.index');

Route::get('/tasks/{id}', function ($id) {
    $task = Task::findOrfail($id);
    return view('show', ['task' => $task]);
})->name('tasks.show');
