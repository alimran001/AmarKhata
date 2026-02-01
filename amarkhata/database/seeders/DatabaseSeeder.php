<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Delete all old accounts first
        $this->deleteOldAccounts();
        
        // Default income categories
        $this->createIncomeCategories();
        
        // Default expense categories
        $this->createExpenseCategories();
        
        // Default accounts
        $this->createAccounts();
    }
    
    private function deleteOldAccounts()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            // Delete accounts with Bengali names
            Account::where('user_id', $user->id)
                ->whereIn('name', ['নগদ', 'বাংলাদেশ ব্যাংক', 'বিকাশ'])
                ->delete();
                
            // Delete duplicate accounts
            $uniqueNames = ['Cash In Hand', 'My Bank', 'Bangladesh Bank', 'bKash', 'Nagad', 'Rocket', 'Others'];
            
            foreach ($uniqueNames as $name) {
                $accounts = Account::where('user_id', $user->id)
                    ->where('name', $name)
                    ->get();
                
                // Keep one, delete others
                if ($accounts->count() > 1) {
                    for ($i = 1; $i < $accounts->count(); $i++) {
                        $accounts[$i]->delete();
                    }
                }
            }
            
            // Rename Bangladesh Bank to My Bank if exists
            $bangladeshBank = Account::where('user_id', $user->id)
                ->where('name', 'Bangladesh Bank')
                ->first();
                
            if ($bangladeshBank) {
                $bangladeshBank->name = 'My Bank';
                $bangladeshBank->save();
            }
            
            // Rename Nagod to Nagad if exists
            $nagod = Account::where('user_id', $user->id)
                ->where('name', 'Nagod')
                ->first();
                
            if ($nagod) {
                $nagod->name = 'Nagad';
                $nagod->save();
            }
            
            // Delete all Bengali categories
            Category::where('user_id', $user->id)
                ->whereIn('name', ['বেতন', 'বোনাস', 'ভাড়া', 'বিক্রয়', 'মুনাফা', 'অন্যান্য', 
                                  'খাবার', 'পরিবহন', 'বিল', 'চিকিৎসা', 'কাপড়', 'শিক্ষা', 'মনোরঞ্জন'])
                ->delete();
            
            // Check for duplicate English categories and remove them
            $incomeCategories = ['Salary', 'Bonus', 'Rent', 'Sales', 'Profit', 'Others'];
            $expenseCategories = ['Food', 'Transport', 'Bills', 'Medical', 'Clothing', 'Education', 'Entertainment', 'Others'];
            
            $allCategories = array_merge($incomeCategories, $expenseCategories);
            
            foreach ($allCategories as $name) {
                $categories = Category::where('user_id', $user->id)
                    ->where('name', $name)
                    ->get();
                
                // Keep one, delete others
                if ($categories->count() > 1) {
                    for ($i = 1; $i < $categories->count(); $i++) {
                        $categories[$i]->delete();
                    }
                }
            }
        }
    }
    
    private function createIncomeCategories()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            $categories = [
                ['name' => 'Salary', 'color' => '#28a745', 'icon' => 'fas fa-money-bill-wave'],
                ['name' => 'Bonus', 'color' => '#17a2b8', 'icon' => 'fas fa-gift'],
                ['name' => 'Rent', 'color' => '#6610f2', 'icon' => 'fas fa-home'],
                ['name' => 'Sales', 'color' => '#fd7e14', 'icon' => 'fas fa-shopping-cart'],
                ['name' => 'Profit', 'color' => '#20c997', 'icon' => 'fas fa-chart-line'],
                ['name' => 'Others', 'color' => '#6c757d', 'icon' => 'fas fa-ellipsis-h'],
            ];
            
            foreach ($categories as $category) {
                // Skip if the user already has this category
                if (Category::where('user_id', $user->id)
                    ->where('type', 'income')
                    ->where('name', $category['name'])
                    ->exists()) {
                    continue;
                }
                
                Category::create([
                    'name' => $category['name'],
                    'type' => 'income',
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'user_id' => $user->id,
                    'is_default' => true,
                ]);
            }
        }
    }
    
    private function createExpenseCategories()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            $categories = [
                ['name' => 'Food', 'color' => '#dc3545', 'icon' => 'fas fa-utensils'],
                ['name' => 'Transport', 'color' => '#fd7e14', 'icon' => 'fas fa-bus'],
                ['name' => 'Bills', 'color' => '#6610f2', 'icon' => 'fas fa-file-invoice'],
                ['name' => 'Medical', 'color' => '#17a2b8', 'icon' => 'fas fa-pills'],
                ['name' => 'Clothing', 'color' => '#20c997', 'icon' => 'fas fa-tshirt'],
                ['name' => 'Education', 'color' => '#28a745', 'icon' => 'fas fa-graduation-cap'],
                ['name' => 'Entertainment', 'color' => '#e83e8c', 'icon' => 'fas fa-film'],
                ['name' => 'Others', 'color' => '#6c757d', 'icon' => 'fas fa-ellipsis-h'],
            ];
            
            foreach ($categories as $category) {
                // Skip if the user already has this category
                if (Category::where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->where('name', $category['name'])
                    ->exists()) {
                    continue;
                }
                
                Category::create([
                    'name' => $category['name'],
                    'type' => 'expense',
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'user_id' => $user->id,
                    'is_default' => true,
                ]);
            }
        }
    }
    
    private function createAccounts()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            $accounts = [
                ['name' => 'Cash In Hand', 'type' => 'Cash', 'initial_balance' => 0, 'is_default' => true],
                ['name' => 'My Bank', 'type' => 'Bank', 'initial_balance' => 0, 'is_default' => true],
                ['name' => 'bKash', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
                ['name' => 'Nagad', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
                ['name' => 'Rocket', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
                ['name' => 'Others', 'type' => 'Other', 'initial_balance' => 0, 'is_default' => true],
            ];
            
            foreach ($accounts as $account) {
                // Skip if the user already has this account
                if (Account::where('user_id', $user->id)
                    ->where('name', $account['name'])
                    ->exists()) {
                    continue;
                }
                
                Account::create([
                    'name' => $account['name'],
                    'type' => $account['type'],
                    'initial_balance' => $account['initial_balance'],
                    'current_balance' => $account['initial_balance'],
                    'user_id' => $user->id,
                    'is_default' => $account['is_default'],
                ]);
            }
        }
    }
}
