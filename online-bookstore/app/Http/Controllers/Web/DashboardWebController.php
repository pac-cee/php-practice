<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;

class DashboardWebController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('book')->get();
        $wishlist = Wishlist::where('user_id', Auth::id())->with('book.author')->get();
        $results = QuizResult::where('user_id', Auth::id())->with('quiz.book')->get();
        return view('dashboard', compact('orders', 'wishlist', 'results'));
    }
}
