<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Category;

class UpdateCategories extends Command
{
    protected $signature = 'categories:update';
    protected $description = 'সব ইউজারের ক্যাটেগরি আপডেট করে';

    public function handle()
    {
        $users = User::all();
        $this->info("মোট {$users->count()} জন ইউজারের ক্যাটেগরি আপডেট করা হচ্ছে...");

        foreach ($users as $user) {
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
                Category::create([
                    'name' => $category['name'],
                    'type' => 'income',
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'user_id' => $user->id,
                    'is_default' => true,
                ]);
            }
            
            // ব্যয়ের ক্যাটেগরি
            $expenseCategories = [
                ['name' => 'খাবার', 'color' => '#F44336', 'icon' => 'fa-utensils'],
                ['name' => 'পরিবহন', 'color' => '#FF9800', 'icon' => 'fa-bus'],
                ['name' => 'শিক্ষা', 'color' => '#3F51B5', 'icon' => 'fa-book'],
                ['name' => 'অন্যান্য ব্যয়', 'color' => '#9C27B0', 'icon' => 'fa-minus-circle'],
            ];
            
            foreach ($expenseCategories as $category) {
                Category::create([
                    'name' => $category['name'],
                    'type' => 'expense',
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'user_id' => $user->id,
                    'is_default' => true,
                ]);
            }

            $this->info("ইউজার {$user->name} এর ক্যাটেগরি আপডেট করা হয়েছে।");
        }

        $this->info('সব ইউজারের ক্যাটেগরি আপডেট করা হয়েছে!');
    }
} 