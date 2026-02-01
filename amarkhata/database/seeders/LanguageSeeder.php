<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create languages
        $languages = [
            [
                'key' => 'bn',
                'name' => 'বাংলা',
                'is_active' => true,
            ],
            [
                'key' => 'en',
                'name' => 'English',
                'is_active' => true,
            ],
            [
                'key' => 'hi',
                'name' => 'हिन्दी',
                'is_active' => true,
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['key' => $language['key']],
                $language
            );
        }

        // Create translations
        $translations = [
            // Bengali translations
            [
                'language_key' => 'bn',
                'key' => 'dashboard',
                'value' => 'ড্যাশবোর্ড',
            ],
            [
                'language_key' => 'bn',
                'key' => 'accounts',
                'value' => 'অ্যাকাউন্টস',
            ],
            [
                'language_key' => 'bn',
                'key' => 'transactions',
                'value' => 'লেনদেন',
            ],
            [
                'language_key' => 'bn',
                'key' => 'categories',
                'value' => 'ক্যাটাগরি',
            ],
            [
                'language_key' => 'bn',
                'key' => 'loans',
                'value' => 'ঋণ',
            ],
            [
                'language_key' => 'bn',
                'key' => 'reports',
                'value' => 'রিপোর্ট',
            ],
            [
                'language_key' => 'bn',
                'key' => 'settings',
                'value' => 'সেটিংস',
            ],
            [
                'language_key' => 'bn',
                'key' => 'logout',
                'value' => 'লগআউট',
            ],
            
            // English translations
            [
                'language_key' => 'en',
                'key' => 'dashboard',
                'value' => 'Dashboard',
            ],
            [
                'language_key' => 'en',
                'key' => 'accounts',
                'value' => 'Accounts',
            ],
            [
                'language_key' => 'en',
                'key' => 'transactions',
                'value' => 'Transactions',
            ],
            [
                'language_key' => 'en',
                'key' => 'categories',
                'value' => 'Categories',
            ],
            [
                'language_key' => 'en',
                'key' => 'loans',
                'value' => 'Loans',
            ],
            [
                'language_key' => 'en',
                'key' => 'reports',
                'value' => 'Reports',
            ],
            [
                'language_key' => 'en',
                'key' => 'settings',
                'value' => 'Settings',
            ],
            [
                'language_key' => 'en',
                'key' => 'logout',
                'value' => 'Logout',
            ],
            
            // Hindi translations
            [
                'language_key' => 'hi',
                'key' => 'dashboard',
                'value' => 'डैशबोर्ड',
            ],
            [
                'language_key' => 'hi',
                'key' => 'accounts',
                'value' => 'खाते',
            ],
            [
                'language_key' => 'hi',
                'key' => 'transactions',
                'value' => 'लेन-देन',
            ],
            [
                'language_key' => 'hi',
                'key' => 'categories',
                'value' => 'श्रेणियाँ',
            ],
            [
                'language_key' => 'hi',
                'key' => 'loans',
                'value' => 'ऋण',
            ],
            [
                'language_key' => 'hi',
                'key' => 'reports',
                'value' => 'रिपोर्ट',
            ],
            [
                'language_key' => 'hi',
                'key' => 'settings',
                'value' => 'सेटिंग्स',
            ],
            [
                'language_key' => 'hi',
                'key' => 'logout',
                'value' => 'लॉग आउट',
            ],
        ];

        foreach ($translations as $translation) {
            Translation::updateOrCreate(
                [
                    'language_key' => $translation['language_key'],
                    'key' => $translation['key'],
                ],
                $translation
            );
        }
    }
}
