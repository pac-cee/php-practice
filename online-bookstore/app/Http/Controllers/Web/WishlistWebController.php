<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistWebController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->with('book.author')->get();
        return view('wishlist.index', compact('wishlist'));
    }
}
