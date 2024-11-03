<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'question_id' => null, // Will be set when creating
            'content' => $this->faker->sentence(4),
            'is_correct' => $this->faker->boolean(25), // 25% chance for the answer to be correct
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
