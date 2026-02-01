<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;

class FixDuplicateCategories extends Command
{
    protected $signature = 'categories:fix-duplicates';
    protected $description = 'ডুপ্লিকেট ক্যাটেগরি ফিক্স করুন';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $categories = Category::where('user_id', $user->id)->get();
            $uniqueCategories = [];

            foreach ($categories as $category) {
                $key = strtolower($category->name) . '_' . $category->type;
                
                if (!isset($uniqueCategories[$key])) {
                    $uniqueCategories[$key] = $category;
                } else {
                    // ডুপ্লিকেট ক্যাটেগরি মুছে ফেলি
                    $category->delete();
                }
            }

            $this->info("ইউজার {$user->name} এর ডুপ্লিকেট ক্যাটেগরি ফিক্স করা হয়েছে।");
        }
    }
}

 