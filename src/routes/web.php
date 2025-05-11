<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TaskController;

Route::get("/", [HomeController::class, 'home']);
Route::resource('tasks', TaskController::class);
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

Route::resource('books', BookController::class);
Route::resource('books.reviews', ReviewController::class)->only(['create', 'store'])->middleware('throttle:reviews');

Route::get('poll', [HomeController::class, 'poll'])->name('poll');

Route::get('testing', function () {
    // 原始的多維關聯陣列
    $originalArray = [
        "user" => [
            "name" => "Alice",
            "age" => 30,
            "email" => "alice@example.com"
        ],
        "preferences" => [
            "language" => "zh-TW",
            "timezone" => "Asia/Taipei"
        ],
        "skills" => ["PHP", "JavaScript", "Golang"]
    ];

    // 將陣列序列化成 JSON 字串
    $jsonString = json_encode($originalArray);

    // 顯示 JSON 字串
    // echo "序列化後的 JSON 字串:\n$jsonString\n\n";

    // 將 JSON 字串還原回陣列
    $restoredArray = json_decode($jsonString, true);

    // 顯示還原後的陣列
    echo "還原後的陣列結構:\n";
    print_r($restoredArray);
});
