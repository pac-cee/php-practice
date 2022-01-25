<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // List/search books
    public function index(Request $request)
    {
        $query = Book::query();
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('genre')) {
            $query->where('genre', $request->genre);
        }
        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }
        $books = $query->with('author')->paginate(20);
        return response()->json($books);
    }

    // Show book details
    public function show($id)
    {
        $book = Book::with('author')->findOrFail($id);
        return response()->json($book);
    }

    // Admin: create a book
    public function store(Request $request)
    {
        try {
            $this->authorize('admin');
            $validated = $request->validate([
