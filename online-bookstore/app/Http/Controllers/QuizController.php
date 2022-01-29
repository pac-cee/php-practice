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
