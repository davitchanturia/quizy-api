<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\UserChoice;
use App\Services\QuizService;
use Illuminate\Http\Request;

class UserChoiceController extends Controller
{

    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

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
            $userChoice = UserChoice::updateOrCreate(
                [
                    'owner_id' => $data['user_id'],
                    'quiz_id' => $data['quiz_id'],
                    'question_id' => $answer['question_id'],
                ],
                [
                    'answer_id' => $answer['answer_id'],
                    'created_at' => now(), 
                    'updated_at' => now(),
                ]
            );
        }

        // Mark the quiz as completed for the user
        $user = User::find($data['user_id']);
        $user->markQuizAsCompleted($data['quiz_id']);      

        $structuredQuiz = $this->quizService->getQuizWithResults($data['quiz_id'], $data['user_id']);
        return response()->json($structuredQuiz);
    }
}
