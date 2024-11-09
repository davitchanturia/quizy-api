<?php

use App\Http\Controllers\QuizController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->get('/get', function(Request $request) {
    $users = User::all ();

    return response()->json(['users' => $users]);
});

Route::middleware(['auth:sanctum'])->get('/quiz', [QuizController::class, 'index']);

Route::middleware(['auth:sanctum'])->get('/quiz/categories', [QuizController::class, 'categories']);