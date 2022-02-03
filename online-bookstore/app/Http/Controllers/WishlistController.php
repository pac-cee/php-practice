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
