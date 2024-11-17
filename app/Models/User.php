<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function quizzesTaken()
    {
        return $this->belongsToMany(Quiz::class, 'user_choices')
            ->withPivot(['question_id', 'answer_id'])
            ->withTimestamps();
    }

    public function completedQuizzes()
    {
        return $this->belongsToMany(Quiz::class)->withPivot('completed')->withTimestamps();
    }

    public function createdQuizzes()
    {
        return $this->hasMany(Quiz::class, 'owner_id');
    }

    public function markQuizAsCompleted(int $quizId): void
    {
        if (!$this->completedQuizzes()->where('quiz_id', $quizId)->exists()) 
        {
            $this->completedQuizzes()->attach($quizId, ['completed' => true]);
        } else {
            $this->completedQuizzes()->updateExistingPivot($quizId, [
                'updated_at' => now(),
            ]);
        }
    }

}
