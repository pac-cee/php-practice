<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // List user orders
    public function index()
    {
        try {
            $orders = Order::where('user_id', Auth::id())->with('book')->get();
            return response()->json($orders);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
