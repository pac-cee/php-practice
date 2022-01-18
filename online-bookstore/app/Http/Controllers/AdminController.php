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
