<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * ব্যবহারকারীদের তালিকা দেখাবে
     */
    public function users(Request $request)
    {
        $query = User::query();
        
        // সার্চ করার জন্য
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * ব্যবহারকারীর বিস্তারিত তথ্য দেখাবে
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * ব্যবহারকারীর পাসওয়ার্ড পরিবর্তন পেজ দেখাবে
     */
    public function showChangePassword(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }
    
    /**
     * ব্যবহারকারীর পাসওয়ার্ড পরিবর্তন করবে
     */
    public function changePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'ব্যবহারকারীর পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে।');
    }
    
    /**
     * ব্যবহারকারীর তথ্য সম্পাদনা পেজ দেখাবে
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * ব্যবহারকারীর তথ্য আপডেট করবে
     */
    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'ব্যবহারকারীর তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }
} 