<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Remove the middleware from the constructor
    }
    
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('type')
            ->orderBy('name')
            ->get();
            
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        Category::create($validated);
        
        return redirect()->route('categories.index')
            ->with('success', 'বিভাগ সফলভাবে তৈরি করা হয়েছে।');
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
        ]);
        
        // Cannot change the type after creation
        
        $category->update($validated);
        
        return redirect()->route('categories.index')
            ->with('success', 'বিভাগ সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        
        // Check if category is used in any transactions
        if ($category->transactions()->count() > 0) {
            return back()->withErrors(['error' => 'লেনদেনে ব্যবহৃত বিভাগ মুছা যাবে না।']);
        }
        
        if ($category->is_default) {
            return back()->withErrors(['error' => 'ডিফল্ট বিভাগ মুছা যাবে না।']);
        }
        
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success', 'বিভাগ সফলভাবে মুছে ফেলা হয়েছে।');
    }
    
    public function show(Category $category)
    {
        $this->authorize('view', $category);
        
        $transactions = $category->transactions()
            ->with(['account'])
            ->orderBy('date', 'desc')
            ->paginate(15);
            
        return view('categories.show', compact('category', 'transactions'));
    }
    
    public function getByType(Request $request)
    {
        try {
            // সিকিউরিটি চেক - শুধুমাত্র অথেনটিকেটেড ইউজাররা অ্যাক্সেস করতে পারবে
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            // Check if type parameter exists
            if (!$request->has('type')) {
                return response()->json(['error' => 'Type parameter is required'], 400);
            }
            
            $type = $request->input('type');
            
            // Validate type
            if (!in_array($type, ['income', 'expense'])) {
                return response()->json(['error' => 'Invalid type parameter'], 400);
            }
            
            // ডেবাগিং
            \Log::info('Category request received', [
                'user_id' => Auth::id(),
                'type' => $type,
                'time' => now()->toDateTimeString(),
                'random' => rand(1000, 9999)
            ]);
            
            // সব ক্যাটেগরি লোড করার চেষ্টা
            $rawSql = "SELECT * FROM categories WHERE type = '{$type}' AND (user_id = " . Auth::id() . " OR is_default = 1) ORDER BY name";
            \Log::info('Raw SQL query', ['sql' => $rawSql]);
            
            // ম্যানুয়ালি যোগ করা ক্যাটেগরি সহ সব ক্যাটেগরি লোড করা
            $categories = DB::select($rawSql);
            
            \Log::info('Categories found with raw SQL', [
                'count' => count($categories),
                'categories' => $categories
            ]);
            
            // যদি কোন ক্যাটেগরি না থাকে তবে ডিফল্ট ক্যাটেগরি রিটার্ন করা
            if (empty($categories)) {
                \Log::info('No categories found, returning defaults');
                return $this->getDefaultCategories($type);
            }
            
            // অবজেক্ট থেকে অ্যারেতে রূপান্তর করা
            $formattedCategories = [];
            foreach ($categories as $category) {
                $formattedCategories[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'type' => $category->type,
                    'color' => $category->color,
                    'icon' => $category->icon,
                    'is_default' => (bool)$category->is_default,
                    'user_id' => $category->user_id
                ];
            }
            
            \Log::info('Formatted categories', [
                'count' => count($formattedCategories),
                'first_category' => isset($formattedCategories[0]) ? $formattedCategories[0] : null
            ]);
            
            // ক্যাশিং বন্ধ করার জন্য হেডার যোগ করা
            return response()->json($formattedCategories)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0')
                ->header('Content-Type', 'application/json; charset=utf-8');
                
        } catch (\Exception $e) {
            \Log::error('Error retrieving categories', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'type' => $request->input('type', 'unknown')
            ]);
            
            // এরর হলে ডিফল্ট ক্যাটেগরি রিটার্ন করা
            return $this->getDefaultCategories($request->query('type', 'expense'));
        }
    }
    
    /**
     * ডিফল্ট ক্যাটেগরি রিটার্ন করা
     */
    private function getDefaultCategories($type)
    {
        $categories = [];
        
        if ($type === 'income') {
            $categories = [
                ['id' => 1, 'name' => 'বেতন', 'color' => '#4CAF50', 'icon' => 'fa-money-bill', 'is_default' => true, 'type' => 'income'],
                ['id' => 2, 'name' => 'বোনাস', 'color' => '#8BC34A', 'icon' => 'fa-gift', 'is_default' => true, 'type' => 'income'],
                ['id' => 3, 'name' => 'বিক্রয়', 'color' => '#009688', 'icon' => 'fa-shopping-cart', 'is_default' => true, 'type' => 'income'],
                ['id' => 4, 'name' => 'লাভ', 'color' => '#00BCD4', 'icon' => 'fa-chart-line', 'is_default' => true, 'type' => 'income'],
                ['id' => 5, 'name' => 'ভাড়া', 'color' => '#3F51B5', 'icon' => 'fa-home', 'is_default' => true, 'type' => 'income'],
                ['id' => 6, 'name' => 'অন্যান্য আয়', 'color' => '#607D8B', 'icon' => 'fa-plus-circle', 'is_default' => true, 'type' => 'income']
            ];
        } else {
            $categories = [
                ['id' => 7, 'name' => 'খাবার', 'color' => '#F44336', 'icon' => 'fa-utensils', 'is_default' => true, 'type' => 'expense'],
                ['id' => 8, 'name' => 'পরিবহন', 'color' => '#FF9800', 'icon' => 'fa-bus', 'is_default' => true, 'type' => 'expense'],
                ['id' => 9, 'name' => 'শিক্ষা', 'color' => '#3F51B5', 'icon' => 'fa-book', 'is_default' => true, 'type' => 'expense'],
                ['id' => 10, 'name' => 'চিকিৎসা', 'color' => '#E91E63', 'icon' => 'fa-medkit', 'is_default' => true, 'type' => 'expense'],
                ['id' => 11, 'name' => 'বিল', 'color' => '#673AB7', 'icon' => 'fa-file-invoice', 'is_default' => true, 'type' => 'expense'],
                ['id' => 12, 'name' => 'বিনোদন', 'color' => '#2196F3', 'icon' => 'fa-film', 'is_default' => true, 'type' => 'expense'],
                ['id' => 13, 'name' => 'পোশাক', 'color' => '#795548', 'icon' => 'fa-tshirt', 'is_default' => true, 'type' => 'expense'],
                ['id' => 14, 'name' => 'অন্যান্য ব্যয়', 'color' => '#9C27B0', 'icon' => 'fa-minus-circle', 'is_default' => true, 'type' => 'expense']
            ];
        }
        
        return response()->json([
            'categories' => $categories,
            'timestamp' => now()->timestamp,
            'random' => rand(1000, 9999)
        ])
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0')
        ->header('Content-Type', 'application/json; charset=utf-8');
    }
}
