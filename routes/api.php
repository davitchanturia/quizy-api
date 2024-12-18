<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserChoiceController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->get('/users/{user}/quizzes', [QuizController::class, 'userQuizzes']);

Route::middleware('auth:sanctum')->post('/user/avatar', [UserController::class, 'uploadAvatar']);

Route::middleware(['auth:sanctum'])->get('/get', function(Request $request) {
    $users = User::all ();

    return response()->json(['users' => $users]);
});

Route::middleware(['auth:sanctum'])->post('/quizzes', [QuizController::class, 'index']);
Route::middleware(['auth:sanctum'])->patch('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
Route::put('/quizzes/{quizId}/questions', [QuestionController::class, 'updateQuestions']);

Route::middleware(['auth:sanctum'])->get('/quiz/categories', [QuizController::class, 'categories']);
Route::middleware(['auth:sanctum'])->get('/quiz/{id}', [QuizController::class, 'show']);
Route::middleware(['auth:sanctum'])->post('/quiz/create', [QuizController::class, 'store']);
Route::middleware(['auth:sanctum'])->delete('/quiz/delete', [QuizController::class, 'destroy']);

Route::middleware(['auth:sanctum'])->get('/quiz/{id}/results', [QuizController::class, 'results']);
Route::middleware(['auth:sanctum'])->post('/quiz/{id}/choices', [UserChoiceController::class, 'store']);
