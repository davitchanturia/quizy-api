<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
