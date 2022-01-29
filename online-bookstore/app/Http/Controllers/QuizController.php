<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    // List quizzes for a book
    public function index($book_id)
    {
        try {
            $quizzes = Quiz::where('book_id', $book_id)->get();
            return response()->json($quizzes);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Submit quiz answers (mocked)
    public function submit(Request $request, $quiz_id)
    {
        try {
            $validated = $request->validate([
                'score' => 'required|integer|min:0|max:100',
            ]);
            $quizResult = QuizResult::create([
                'quiz_id' => $quiz_id,
                'user_id' => Auth::id(),
                'score' => $validated['score'],
                'date' => now(),
            ]);
            return response()->json(['message' => 'Quiz submitted', 'result' => $quizResult]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Get user's quiz results
    public function userResults()
    {
        try {
            $results = QuizResult::where('user_id', Auth::id())->with('quiz')->get();
            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
