<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'quiz_id' => null, // Will be set when creating
            'content' => fake()->sentence(6, true) . '?',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the question belongs to a specific quiz.
     *
     * @param int $quizId
     * @return $this
     */
    public function forQuiz($quizId)
    {
        return $this->state([
            'quiz_id' => $quizId,
        ]);
    }
}
