<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Get analytics reports
    public function reports(Request $request)
    {
        try {
            $query = Report::query();
            if ($request->has('type')) {
                $query->where('type', $request->type);
            }
            $reports = $query->with('school')->get();
            return response()->json($reports);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // List all users
    public function users()
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Update user (admin)
    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $validated = $request->validate([
                'name' => 'sometimes|required|string',
                'email' => 'sometimes|required|email',
                'role' => 'sometimes|required|string',
                'school_id' => 'nullable|exists:schools,id',
            ]);
            $user->update($validated);
            return response()->json($user);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Delete user (admin)
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User deleted']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Admin CRUD for books
    public function storeBook(Request $request)
    {
        try {
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
    public function updateBook(Request $request, $id)
