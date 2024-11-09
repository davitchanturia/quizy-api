<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'owner_id' => User::factory(), // Assuming you have a User model
            'is_active' => true,
            'category_id' => null,
            'difficulty' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
