<?php

namespace App\Http\Controllers;

use App\Models\UserChoice;
use Illuminate\Http\Request;

class UserChoiceController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'user_id' => 'required',
            'choices' => 'required|array',
            'choices.*.question_id' => 'required|exists:questions,id',
            'choices.*.answer_id' => 'required|exists:answers,id',
        ]);
            
        foreach ($data['choices'] as $answer) {
            UserChoice::create([
                'owner_id' => $data['user_id'],
                // 'quiz_id' => $data['quiz_id'],
                'question_id' => $answer['question_id'],
                'answer_id' => $answer['answer_id'],
            ]);
        }
    
        return response()->json(['message' => 'Quiz results saved successfully.']);
    
    }
}
