<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // যেসকল আইডির ব্যবহারকারীরা অ্যাডমিন হিসেবে ব্যবহার করতে পারবে
        $adminIds = [1, 2, 3]; // আপনার ব্যবহারকারী আইডি এখানে যোগ করুন

        // Check if user is admin (any user with ID in the adminIds array)
        if (Auth::check() && in_array(Auth::id(), $adminIds)) {
            return $next($request);
        }
        
        abort(403, 'Unauthorized access');
    }
}
