<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    /**
     * Change the application language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $locale
     * @return \Illuminate\Http\Response
     */
    public function changeLanguage(Request $request, $locale)
    {
        // ভ্যালিড ল্যাঙ্গুয়েজ চেক
        if (!in_array($locale, ['en', 'bn', 'hi'])) {
            $locale = 'bn';
        }
        
        // সেশনে সেট করি
        session(['locale' => $locale]);
        
        // এপ্লিকেশনে সেট করি
        app()->setLocale($locale);
        
        // কুকিতে সেট করি
        $minutes = 60 * 24 * 365; // 1 year
        Cookie::queue('preferred_language', $locale, $minutes);
        
        // ডিবাগিং লগ
        Log::debug('Language changed to: ' . $locale, [
            'session_locale' => session('locale'),
            'cookie_locale' => $request->cookie('preferred_language'),
            'app_locale' => app()->getLocale(),
            'ref_url' => $request->query('ref', url()->previous())
        ]);
        
        // ক্যাশে ক্লিয়ার করি
        try {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
        } catch (\Exception $e) {
            // ক্যাশে ক্লিয়ার করতে না পারলেও চলবে
            Log::error('Failed to clear cache: ' . $e->getMessage());
        }
        
        // রেফারেন্স URL থেকে রিডাইরেক্ট করি
        $redirectUrl = $request->query('ref', url()->previous());
        return redirect($redirectUrl)->withCookie(cookie('preferred_language', $locale, $minutes));
    }
} 