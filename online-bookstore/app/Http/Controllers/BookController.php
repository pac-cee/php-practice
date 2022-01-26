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
                'title' => 'required|string',
                'author_id' => 'required|exists:authors,id',
                'genre' => 'nullable|string',
                'format' => 'nullable|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'cover_image' => 'nullable|string',
            ]);
            $book = Book::create($validated);
            return response()->json($book, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Admin: update a book
    public function update(Request $request, $id)
    {
        try {
            $this->authorize('admin');
            $book = Book::findOrFail($id);
            $validated = $request->validate([
                'title' => 'sometimes|required|string',
                'author_id' => 'sometimes|required|exists:authors,id',
                'genre' => 'nullable|string',
                'format' => 'nullable|string',
                'description' => 'nullable|string',
                'price' => 'sometimes|required|numeric|min:0',
                'cover_image' => 'nullable|string',
            ]);
            $book->update($validated);
            return response()->json($book);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Book not found'], 404);
