<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    protected $translationService;
    
    public function __construct(TranslationService $translationService)
    {
        $this->middleware('auth')->except(['changeLanguage']);
        $this->translationService = $translationService;
    }
    
    public function changeLanguage(Request $request, $language)
    {
        // Check if language exists and is active
        $lang = Language::where('key', $language)
            ->where('is_active', true)
            ->first();
            
        if (!$lang) {
            return back()->withErrors(['error' => 'Language not available.']);
        }
        
        $this->translationService->setLanguage($language);
        
        return back();
    }
    
    public function index()
    {
        $languages = Language::all();
        return view('admin.languages.index', compact('languages'));
    }
    
    public function create()
    {
        return view('admin.languages.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:5|unique:languages,key',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);
        
        Language::create($validated);
        
        // Clear languages cache
        Cache::forget('available_languages');
        
        return redirect()->route('admin.languages.index')
            ->with('success', 'Language created successfully.');
    }
    
    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }
    
    public function update(Request $request, Language $language)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);
        
        $language->update($validated);
        
        // Clear languages cache
        Cache::forget('available_languages');
        
        return redirect()->route('admin.languages.index')
            ->with('success', 'Language updated successfully.');
    }
    
    public function translations(Language $language)
    {
        $translations = Translation::where('language_key', $language->key)
            ->orderBy('key')
            ->paginate(50);
            
        return view('admin.languages.translations', compact('language', 'translations'));
    }
    
    public function storeTranslation(Request $request, Language $language)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);
        
        $translation = Translation::updateOrCreate(
            [
                'language_key' => $language->key,
                'key' => $validated['key'],
            ],
            [
                'value' => $validated['value'],
            ]
        );
        
        // Clear translation cache
        Cache::forget("translation_{$language->key}_{$validated['key']}");
        
        return redirect()->route('admin.languages.translations', $language)
            ->with('success', 'Translation saved successfully.');
    }
    
    public function deleteTranslation(Translation $translation)
    {
        $language = Language::where('key', $translation->language_key)->first();
        
        $translation->delete();
        
        // Clear translation cache
        Cache::forget("translation_{$translation->language_key}_{$translation->key}");
        
        return redirect()->route('admin.languages.translations', $language)
            ->with('success', 'Translation deleted successfully.');
    }
}
