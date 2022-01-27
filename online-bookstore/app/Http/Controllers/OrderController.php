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

    // Show order details
    public function show($id)
    {
        try {
            $order = Order::with('book')->where('user_id', Auth::id())->findOrFail($id);
            return response()->json($order);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Create order
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
