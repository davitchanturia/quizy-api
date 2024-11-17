<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
use App\Models\QuizCategory;
use App\Models\User;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{

    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

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

        $userId = auth()->user()->id; // Get the authenticated user's ID     
        
        $isCompletedSubQuery = DB::table('quiz_user')
            ->select('completed')
            ->whereColumn('quiz_user.quiz_id', 'quizzes.id')
            ->where('quiz_user.user_id', $userId)
            ->where('quiz_user.completed', true)
            ->limit(1);

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
            ->addSelect(['is_completed' => $isCompletedSubQuery])
            ->get();
    
        return response()->json($quizzes);
    }

    public function userQuizzes(User $user)
    {
        $quizzes = $user->createdQuizzes()->with(['category'])->get();

        return response()->json($quizzes);
    }

    public function categories()
    {
        return response()->json(QuizCategory::all());
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
    
        if (!$quiz) {
            return response()->json(['error' => 'Quiz not found'], 404);
        }
    
        $userId = auth()->id();
        $quiz->is_completed = $quiz->isCompletedBy($userId);
    
    
        return response()->json($quiz);
    }

    public function results($quizId)
    {
        return $this->quizService->getQuizWithResults($quizId, auth()->id());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $validated = $request->validated();

        $quiz->update($validated);
        $quiz->save();

        return response()->json($quiz);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
