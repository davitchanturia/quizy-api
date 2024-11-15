<?php
namespace App\Services;

use App\Models\Quiz;

class QuizService
{
    public function getQuizWithResults($quizId, $userId)
    {
        $quizResults = Quiz::where('id', $quizId)
            ->with(['questions' => function ($query) use ($userId) {
                $query->with(['userChoices' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }])
                ->with(['answers' => function ($query) {
                    $query->where('is_correct', true);
                }, 'userChoices']);
            }])
            ->first();

        $structuredQuiz = [
            'quiz_id' => $quizResults->id,
            'title' => $quizResults->title,
            'is_completed' => true,
            'created_at' => $quizResults->created_at->format('M d, Y'),
            'owner' => $quizResults->owner->name,
            'category' => $quizResults->category->name,
            'difficulty' => $quizResults->difficulty,
            'questions_count' => $quizResults->questions->count(),
            'questions' => $quizResults->questions->map(function ($question) {
                $userChoice = $question->userChoices->first();
                $correctAnswer = $question->answers->first(); // Assumes only one correct answer

                return [
                    'question_id' => $question->id,
                    'content' => $question->content,
                    'user_answer' => $userChoice->answer->content ?? null,
                    'is_correct' => $userChoice && $userChoice->answer_id == $correctAnswer->id,
                    'correct_answer_content' => $correctAnswer->content,
                ];
            })
        ];

        return $structuredQuiz;
    }
}
