<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use Database\Factories\CourseFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Course::factory(5)->create()->each(function ($course) {
            Quiz::factory(5)->create(['course_id' => $course->id])->each(function ($quiz) {
                $quiz->questions()->saveMany(Question::factory(5)->make());
            });
        });

        // soal tanpa quiz
        Question::factory(5)->create();
    }
}
