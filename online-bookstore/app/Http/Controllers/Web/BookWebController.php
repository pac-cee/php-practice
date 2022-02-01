<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('author');
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('genre') && $request->genre) {
            $query->where('genre', $request->genre);
        }
        $books = $query->paginate(20);
