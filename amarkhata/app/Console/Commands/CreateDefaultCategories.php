<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;

class CreateDefaultCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-default-categories {user_id? : The ID of the user to create categories for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ইউজারের জন্য ডিফল্ট ক্যাটেগরি তৈরি করে';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("ইউজার আইডি {$userId} পাওয়া যায়নি!");
                return 1;
            }
            
            $this->createCategoriesForUser($user->id);
            $this->info("ইউজার {$user->name} এর জন্য ক্যাটেগরি তৈরি করা হয়েছে।");
        } else {
            $users = User::all();
            $count = 0;
            
            foreach ($users as $user) {
                $this->createCategoriesForUser($user->id);
                $count++;
            }
            
            $this->info("{$count} জন ইউজারের জন্য ক্যাটেগরি তৈরি করা হয়েছে।");
        }
        
        return 0;
    }
    
    /**
     * একজন ইউজারের জন্য ক্যাটেগরি তৈরি করা
     */
    private function createCategoriesForUser($userId)
    {
        // আয় ক্যাটেগরি
        $this->createCategory($userId, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', true);
        $this->createCategory($userId, 'বোনাস', 'income', '#8BC34A', 'fa-gift', true);
        $this->createCategory($userId, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', true);
        $this->createCategory($userId, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', true);
        
        // ব্যয় ক্যাটেগরি
        $this->createCategory($userId, 'খাবার', 'expense', '#F44336', 'fa-utensils', true);
        $this->createCategory($userId, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', true);
        $this->createCategory($userId, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', true);
        $this->createCategory($userId, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', true);
    }
    
    /**
     * ক্যাটেগরি তৈরি করার হেল্পার ফাংশন
     */
    private function createCategory($userId, $name, $type, $color, $icon, $isDefault = false)
    {
        // চেক করা যে ক্যাটেগরি আগে থেকে আছে কিনা
        $exists = Category::where('user_id', $userId)
            ->where('name', $name)
            ->where('type', $type)
            ->exists();
            
        if (!$exists) {
            Category::create([
                'user_id' => $userId,
                'name' => $name,
                'type' => $type,
                'color' => $color,
                'icon' => $icon,
                'is_default' => $isDefault,
            ]);
        }
    }
}
