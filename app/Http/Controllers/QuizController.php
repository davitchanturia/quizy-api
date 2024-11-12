<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
use App\Models\QuizCategory;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'categories' => 'array',
        ]);

        $difficulty = $request->query('difficulty');
        $search = $request->query('search');
        $categories = $request->input('categories');
        
        $quizzes = Quiz::with(['owner', 'category'])
            ->when($difficulty, function ($query, $difficulty) {
                return $query->where('difficulty', $difficulty);
            })
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->when(!empty($categories), function ($query) use ($categories) {
                return $query->whereIn('category_id', $categories);
            })
            ->get();
    
        return response()->json($quizzes);
    }

    public function categories()
    {
        return response()->json(QuizCategory::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $quiz = Quiz::with(['owner', 'category', 'questions.answers'])->find($id);
    
        return response()->json($quiz);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
