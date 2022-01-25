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
