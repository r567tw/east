<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\Task;

Route::get("/", [HomeController::class, 'home']);

Route::get('/tasks', function () {
    $tasks = Task::latest()->get();
    return view('index', ['tasks' => $tasks]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')->name('tasks.create');

Route::get('/tasks/{id}', function ($id) {
    $task = Task::findOrFail($id);
    return view('show', ['task' => $task]);
})->name('tasks.show');

Route::post('/tasks', function () {
    $task = new Task();
    $task->title = request('title');
    $task->description = request('description');
    $task->save();
    return redirect()->route('tasks.index');
})->name('tasks.store');
