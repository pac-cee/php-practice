<?php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Get user wishlist
    public function index()
    {
        try {
            $wishlist = Wishlist::where('user_id', Auth::id())->with('book')->get();
            return response()->json($wishlist);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Add book to wishlist
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'book_id' => 'required|exists:books,id',
            ]);
            $item = Wishlist::firstOrCreate([
                'user_id' => Auth::id(),
                'book_id' => $validated['book_id'],
            ]);
            return response()->json($item, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Remove book from wishlist
    public function destroy($book_id)
    {
        try {
            $deleted = Wishlist::where('user_id', Auth::id())->where('book_id', $book_id)->delete();
            if ($deleted) {
                return response()->json(['message' => 'Removed from wishlist']);
            } else {
                return response()->json(['message' => 'Item not found in wishlist'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
