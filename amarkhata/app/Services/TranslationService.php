<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class TranslationService
{
    protected $language;

    public function __construct()
    {
        $this->language = Session::get('language', 'bn');
    }

    public function setLanguage($language)
    {
        $this->language = $language;
        Session::put('language', $language);
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function translate($key, $default = null)
    {
        $cacheKey = "translation_{$this->language}_{$key}";
        
        return Cache::remember($cacheKey, 86400, function () use ($key, $default) {
            $translation = Translation::where('language_key', $this->language)
                ->where('key', $key)
                ->first();
            
            if ($translation) {
                return $translation->value;
            }
            
            // If not found in current language, try English as fallback
            if ($this->language !== 'en') {
                $fallback = Translation::where('language_key', 'en')
                    ->where('key', $key)
                    ->first();
                
                if ($fallback) {
                    return $fallback->value;
                }
            }
            
            return $default ?? $key;
        });
    }

    public function getAvailableLanguages()
    {
        return Cache::remember('available_languages', 86400, function () {
            return Language::where('is_active', true)->get();
        });
    }
} 