<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Answer extends Model
{
    use HasFactory;

    protected function getIsCorrectAttribute($value)
    {
        return (bool) $value;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'content',
        'is_correct',
    ];

    /**
     * Get the question that owns the answer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userChoices()
    {
        return $this->hasMany(UserChoice::class);
    }
}
