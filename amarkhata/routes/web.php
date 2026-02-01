<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Language\LanguageController;
use App\Http\Controllers\Loan\LoanController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

// Language Switcher
Route::get('/language/{language}', function($language) {
    if (!in_array($language, ['en', 'bn', 'hi'])) {
        $language = 'bn';
    }
    
    session(['locale' => $language]);
    app()->setLocale($language);
    
    $minutes = 60 * 24 * 365; // 1 year
    Cookie::queue('preferred_language', $language, $minutes);
    
    return redirect()->back()->withCookie(cookie('preferred_language', $language, $minutes));
})->name('language.change');

// Debug route for language
Route::get('/debug-language', function() {
    return [
        'app_locale' => app()->getLocale(),
        'session_locale' => session('locale'),
        'cookie_locale' => request()->cookie('preferred_language')
    ];
});

// Guest routes
Route::middleware('guest')->group(function () {
    // Landing page
    Route::get('/', function () {
        return view('landing');
    })->name('landing');
    
    // Auth routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Test route for debugging
    Route::get('/test-auth', function() {
        return [
            'user_id' => Auth::id(),
            'categories_count' => \App\Models\Category::where('user_id', Auth::id())->count(),
            'income_count' => \App\Models\Category::where('user_id', Auth::id())->where('type', 'income')->count(),
            'expense_count' => \App\Models\Category::where('user_id', Auth::id())->where('type', 'expense')->count(),
        ];
    });
    
    // Email verification
    Route::get('/email/verify', [AuthController::class, 'showVerifyEmail'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->middleware(['throttle:6,1'])->name('verification.send');

    // Routes requiring verified email
    // Route::middleware('verified')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Accounts
        Route::resource('accounts', AccountController::class);
        
        // Categories
        Route::resource('categories', CategoryController::class);
        Route::get('/categories/by-type', [CategoryController::class, 'getByType'])->name('categories.by-type');
        
        // Transactions
        Route::resource('transactions', TransactionController::class);
        Route::post('/transactions/quick-add', [TransactionController::class, 'quickAdd'])->name('transactions.quick-add');
        
        // Loans
        Route::resource('loans', LoanController::class);
        Route::get('/loans/{loan}/payment', [LoanController::class, 'paymentForm'])->name('loans.payment.form');
        Route::post('/loans/{loan}/payment', [LoanController::class, 'recordPayment'])->name('loans.payment.store');
        
        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/reports/yearly', [ReportController::class, 'yearly'])->name('reports.yearly');
        Route::get('/reports/custom', [ReportController::class, 'custom'])->name('reports.custom');
        Route::get('/reports/download', [ReportController::class, 'downloadPdf'])->name('reports.download');
        
        // Profile
        Route::get('/profile', function() {
            return view('profile.edit');
        })->name('profile.edit');
        Route::post('/profile', function() {
            // প্রোফাইল আপডেট লজিক এখানে যুক্ত করতে হবে
            return back()->with('success', 'প্রোফাইল আপডেট হয়েছে');
        })->name('profile.update');
        
        // Settings
        Route::get('/settings', function() {
            return view('settings.index');
        })->name('settings.index');
        Route::post('/settings', function() {
            // সেটিংস আপডেট লজিক এখানে যুক্ত করতে হবে
            return back()->with('success', 'সেটিংস আপডেট হয়েছে');
        })->name('settings.update');

    // Account Management Routes
    Route::post('/account/deactivate', function() {
        $user = Auth::user();
        $user->is_active = false;
        $user->save();
        Auth::logout();
        return redirect()->route('login')->with('success', 'আপনার অ্যাকাউন্ট ডিঅ্যাক্টিভেট করা হয়েছে');
    })->name('account.deactivate');

    Route::post('/account/delete', function() {
        $user = Auth::user();
        
        // Validate password
        request()->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('আপনার পাসওয়ার্ড সঠিক নয়');
                }
            }],
        ]);
        
        // Delete all user data
        $user->accounts()->delete();
        $user->categories()->delete();
        $user->transactions()->delete();
        $user->loans()->delete();
        $user->delete();
        Auth::logout();
        return redirect()->route('login')->with('success', 'আপনার অ্যাকাউন্ট ডিলিট করা হয়েছে');
    })->name('account.delete');

    // Password Update Routes
    Route::get('/password/update', function () {
        return view('settings.password');
    })->name('password.update');

    Route::post('/password/update', function() {
        $request = request();
        
        // Validate request
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('বর্তমান পাসওয়ার্ড সঠিক নয়');
                }
            }],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Update password
        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে');
    })->name('password.update.post');
    // });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', function() {
        return redirect()->route('admin.users');
    })->name('dashboard');

    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::get('/users/{user}/change-password', [AdminController::class, 'showChangePassword'])->name('users.change-password');
    Route::post('/users/{user}/change-password', [AdminController::class, 'changePassword'])->name('users.update-password');

    // Languages
    Route::resource('languages', LanguageController::class);
    Route::get('/languages/{language}/translations', [LanguageController::class, 'translations'])->name('languages.translations');
    Route::post('/languages/{language}/translations', [LanguageController::class, 'storeTranslation'])->name('languages.translations.store');
    Route::delete('/translations/{translation}', [LanguageController::class, 'deleteTranslation'])->name('translations.delete');
});

// Debug routes
Route::get('/debug/categories', App\Http\Controllers\TestController::class)->middleware('auth');

// Test route for AJAX
Route::get('/test-ajax', function() {
    return view('test-ajax');
})->name('test.ajax');

// Direct test route for categories
Route::get('/direct-test-categories/{type}', function($type) {
    if (!in_array($type, ['income', 'expense'])) {
        $type = 'expense';
    }
    
    // ডিফল্ট ক্যাটেগরি তৈরি করি
    $categories = [];
    
    if ($type === 'income') {
        $categories = [
            ['id' => 1, 'name' => 'বেতন'],
            ['id' => 2, 'name' => 'বোনাস'],
            ['id' => 3, 'name' => 'বিক্রয়'],
            ['id' => 4, 'name' => 'অন্যান্য আয়']
        ];
    } else {
        $categories = [
            ['id' => 5, 'name' => 'খাবার'],
            ['id' => 6, 'name' => 'পরিবহন'],
            ['id' => 7, 'name' => 'শিক্ষা'],
            ['id' => 8, 'name' => 'অন্যান্য ব্যয়']
        ];
    }
    
    return response()->json($categories);
})->name('direct.test.categories');

// Test route for categories
Route::get('/test-categories/{type}', function($type) {
    if (!in_array($type, ['income', 'expense'])) {
        return response()->json(['error' => 'Invalid type parameter'], 400);
    }
    
    $categories = \App\Models\Category::where('user_id', \Illuminate\Support\Facades\Auth::id())
        ->where('type', $type)
        ->orderBy('name')
        ->get();
    
    return response()->json($categories);
})->name('test.categories');

// New test route for categories by type
Route::get('/debug/categories-by-type', function() {
    $type = request()->query('type', 'expense');
    
    if (!in_array($type, ['income', 'expense'])) {
        $type = 'expense';
    }
    
    $categories = \App\Models\Category::where('user_id', \Illuminate\Support\Facades\Auth::id())
        ->where('type', $type)
        ->orderBy('name')
        ->get();
    
    return [
        'type' => $type,
        'user_id' => \Illuminate\Support\Facades\Auth::id(),
        'count' => $categories->count(),
        'categories' => $categories->toArray()
    ];
})->middleware('auth')->name('debug.categories-by-type');

// Help Desk Route
Route::get('/help-desk', function () {
    return view('help.desk');
})->name('help.desk');

// Privacy Policy Route
Route::get('/privacy-policy', function () {
    return view('privacy.policy');
})->name('privacy.policy');

// About Us Route
Route::get('/about-us', function () {
    return view('about.us');
})->name('about.us');

// লোন পেমেন্ট রাউট
Route::post('/loan-payments', [App\Http\Controllers\Loan\LoanPaymentController::class, 'store'])->name('loan-payments.store');
Route::delete('/loan-payments/{payment}', [App\Http\Controllers\Loan\LoanPaymentController::class, 'destroy'])->name('loan-payments.destroy');
