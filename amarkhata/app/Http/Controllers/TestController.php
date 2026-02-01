<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Create a debug route to test category loading
        $income = Category::where('user_id', Auth::id())
            ->where('type', 'income')
            ->get();
            
        $expense = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();
            
        // Check if we have any categories
        $counts = [
            'income' => $income->count(),
            'expense' => $expense->count(),
            'user_id' => Auth::id(),
            'total_categories' => Category::count(),
        ];
        
        // Log the information
        Log::info('Category Debug', $counts);
        
        return response()->json($counts);
    }
}
