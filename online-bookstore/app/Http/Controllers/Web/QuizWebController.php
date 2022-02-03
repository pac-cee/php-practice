<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Book;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;

class QuizWebController extends Controller
{
    public function index($book_id)
    {
        $book = Book::findOrFail($book_id);
        $quizzes = Quiz::where('book_id', $book_id)->get();
        return view('quiz.index', compact('book', 'quizzes'));
    }

    public function results()
    {
        $results = QuizResult::where('user_id', Auth::id())->with('quiz.book')->get();
        return view('quiz.results', compact('results'));
    }
}
