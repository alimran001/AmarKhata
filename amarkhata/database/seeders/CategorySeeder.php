<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // সব ইউজারের জন্য ডিফল্ট ক্যাটেগরি তৈরি করা
        $users = User::all();
        
        foreach ($users as $user) {
            // আয় ক্যাটেগরি
            $this->createCategory($user->id, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', true);
            $this->createCategory($user->id, 'বোনাস', 'income', '#8BC34A', 'fa-gift', true);
            $this->createCategory($user->id, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', true);
            $this->createCategory($user->id, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', true);
            
            // ব্যয় ক্যাটেগরি
            $this->createCategory($user->id, 'খাবার', 'expense', '#F44336', 'fa-utensils', true);
            $this->createCategory($user->id, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', true);
            $this->createCategory($user->id, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', true);
            $this->createCategory($user->id, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', true);
        }
    }
    
    /**
     * ক্যাটেগরি তৈরি করার হেল্পার ফাংশন
     */
    private function createCategory($userId, $name, $type, $color, $icon, $isDefault = false)
    {
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
