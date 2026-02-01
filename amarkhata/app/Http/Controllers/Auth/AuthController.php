<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\Account;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        // নতুন ইউজারের জন্য ডিফল্ট অ্যাকাউন্ট তৈরি করি
        $this->createDefaultAccountsForUser($user);
        
        // নতুন ইউজারের জন্য ডিফল্ট ক্যাটেগরি তৈরি করি
        $this->createDefaultCategoriesForUser($user);

        event(new Registered($user));
        
        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    /**
     * নতুন ইউজারের জন্য ডিফল্ট অ্যাকাউন্ট তৈরি করে
     */
    private function createDefaultAccountsForUser(User $user)
    {
        $accounts = [
            ['name' => 'Cash In Hand (হাতে)', 'type' => 'Cash', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'My Bank', 'type' => 'Bank', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'বিকাশ', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'Nagad', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'Rocket', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'Others', 'type' => 'Other', 'initial_balance' => 0, 'is_default' => true],
        ];
        
        foreach ($accounts as $account) {
            // চেক করি অ্যাকাউন্ট আগে থেকে আছে কিনা
            $exists = Account::where('user_id', $user->id)
                ->where('name', $account['name'])
                ->exists();
                
            if (!$exists) {
                Account::create([
                    'name' => $account['name'],
                    'type' => $account['type'],
                    'initial_balance' => $account['initial_balance'],
                    'current_balance' => $account['initial_balance'],
                    'user_id' => $user->id,
                    'is_default' => $account['is_default'],
                ]);
            }
        }
    }

    /**
     * নতুন ইউজারের জন্য ডিফল্ট ক্যাটেগরি তৈরি করে
     */
    private function createDefaultCategoriesForUser(User $user)
    {
        // প্রথমে সব ক্যাটেগরি মুছে ফেলি
        Category::where('user_id', $user->id)->delete();

        // আয়ের ক্যাটেগরি
        $incomeCategories = [
            ['name' => 'বেতন', 'color' => '#4CAF50', 'icon' => 'fa-money-bill'],
            ['name' => 'বোনাস', 'color' => '#8BC34A', 'icon' => 'fa-gift'],
            ['name' => 'বিক্রয়', 'color' => '#009688', 'icon' => 'fa-shopping-cart'],
            ['name' => 'অন্যান্য আয়', 'color' => '#607D8B', 'icon' => 'fa-plus-circle'],
        ];
        
        foreach ($incomeCategories as $category) {
            // চেক করি ক্যাটেগরি আগে থেকে আছে কিনা
            $exists = Category::where('user_id', $user->id)
                ->where('name', $category['name'])
                ->where('type', 'income')
                ->exists();
                
            if (!$exists) {
                Category::create([
                    'name' => $category['name'],
                    'type' => 'income',
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'user_id' => $user->id,
                    'is_default' => true,
                ]);
            }
        }
        
        // ব্যয়ের ক্যাটেগরি
        $expenseCategories = [
            ['name' => 'খাবার', 'color' => '#F44336', 'icon' => 'fa-utensils'],
            ['name' => 'পরিবহন', 'color' => '#FF9800', 'icon' => 'fa-bus'],
            ['name' => 'শিক্ষা', 'color' => '#3F51B5', 'icon' => 'fa-book'],
            ['name' => 'অন্যান্য ব্যয়', 'color' => '#9C27B0', 'icon' => 'fa-minus-circle'],
        ];
        
        foreach ($expenseCategories as $category) {
            // চেক করি ক্যাটেগরি আগে থেকে আছে কিনা
            $exists = Category::where('user_id', $user->id)
                ->where('name', $category['name'])
                ->where('type', 'expense')
                ->exists();
                
            if (!$exists) {
                Category::create([
                    'name' => $category['name'],
                    'type' => 'expense',
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'user_id' => $user->id,
                    'is_default' => true,
                ]);
            }
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'আপনি সফলভাবে লগআউট করেছেন');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function showVerifyEmail()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        
        event(new Verified($request->user()));

        return redirect()->route('dashboard');
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
