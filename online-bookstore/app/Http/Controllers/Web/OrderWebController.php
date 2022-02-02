<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderWebController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('book')->get();
        return view('orders.index', compact('orders'));
    }
}
