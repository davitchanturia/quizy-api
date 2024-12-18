<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'owner_id',
        'is_active',
        'finished_at',
        'difficulty',
    ];

    /**
     * The user who owns the quiz.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(User::class)->withPivot('completed')->withTimestamps();
    }


    /**
     * Get the questions for the quiz.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

        /**
     * Get the quiz categories for the quiz.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->hasOne(QuizCategory::class, 'id', 'category_id');
    }

    /**
     * Scope a query to only include active quizzes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Determine if a user owns this quiz.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function isOwnedBy(User $user)
    {
        return $this->owner_id === $user->id;
    }

    public function userChoices()
    {
        return $this->hasMany(UserChoice::class);
    }

    public function markAsFinished()
    {
        $this->finished_at = now();
        $this->save();
    }

    protected function getIsCompletedAttribute($value)
    {
        return (bool) $value;
    }

    protected function getIsActiveAttribute($value)
    {
        return (bool) $value;
    }

    protected function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function isCompletedBy($userId)
    {
        return DB::table('quiz_user')
            ->where('quiz_id', $this->id)
            ->where('user_id', $userId)
            ->where('completed', true)
            ->exists();
    }

    public function updateQuestions(array $questions)
    {
        DB::transaction(function () use ($questions) {
            $this->deleteOldQuestions();
            $this->attachNewQuestions($questions);
        });
    }

    private function deleteOldQuestions()
    {
        $this->questions()->each(function ($question) {
            $question->answers()->delete();
            $question->delete();
        });
    }

    private function attachNewQuestions(array $questions)
    {
        foreach ($questions as $questionData) {
            $question = $this->questions()->create([
                'content' => $questionData['content'],
            ]);

            $question->answers()->createMany($questionData['answers']);
        }
    }

}
