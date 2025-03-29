<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Task::factory(3)->create();

        // Book::factory(10)->create()->each(function (Book $book) {
        //     $number = random_int(1, 5);

        //     Review::factory()->count($number)->good()->for($book)->create();

        //     $number = random_int(1, 5);

        //     Review::factory()->count($number)->bad()->for($book)->create();
        // });

        $this->call(EventSeeder::class);
        $this->call(AttendeeSeeder::class);
    }
}
