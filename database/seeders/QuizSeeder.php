<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QuizCategory;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quizCategories = QuizCategory::factory(20)->create();

        // Create 2 quizzes
        Quiz::factory(5)->create([
            'category_id' => $quizCategories->random()->id,
        ])->each(function ($quiz) {
            // Create 10 questions for each quiz
            Question::factory(10)->create([
                'quiz_id' => $quiz->id,
            ])->each(function ($question) {
                // Create 4 answers for each question
                $answers = Answer::factory(4)->create([
                    'question_id' => $question->id,
                ]);
                
                // Randomly select one answer as correct
                $answers->random(1)->first()->update(['is_correct' => true]);
            });
        });
    }
}
