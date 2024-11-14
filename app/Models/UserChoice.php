<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChoice extends Model
{
    protected $fillable = ['owner_id', 'quiz_id', 'question_id', 'answer_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}

