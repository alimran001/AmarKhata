<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // সরাসরি বাংলা ভাষা সেট করি
        App::setLocale('bn');
        
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Set session and cookie configuration
        Config::set('session.secure', false);
        Config::set('session.same_site', null);
        Config::set('session.cookie', 'amarkhata_session');
        
        // Register TranslationService
        $this->app->singleton('App\Services\TranslationService', function ($app) {
            return new \App\Services\TranslationService();
        });
    }

    /**
     * নতুন ইউজারের জন্য ডিফল্ট অ্যাকাউন্ট তৈরি করে
     */
    private function createDefaultAccountsForUser(User $user)
    {
        $accounts = [
            ['name' => 'Cash In Hand', 'type' => 'Cash', 'initial_balance' => 0],
            ['name' => 'My Bank', 'type' => 'Bank', 'initial_balance' => 0],
            ['name' => 'bKash', 'type' => 'Mobile Banking', 'initial_balance' => 0],
            ['name' => 'Nagad', 'type' => 'Mobile Banking', 'initial_balance' => 0],
            ['name' => 'Rocket', 'type' => 'Mobile Banking', 'initial_balance' => 0],
            ['name' => 'Others', 'type' => 'Other', 'initial_balance' => 0],
        ];
        
        foreach ($accounts as $account) {
            Account::create([
                'name' => $account['name'],
                'type' => $account['type'],
                'initial_balance' => $account['initial_balance'],
                'current_balance' => $account['initial_balance'],
                'user_id' => $user->id,
            ]);
        }
    }
    
    /**
     * নতুন ইউজারের জন্য ডিফল্ট ক্যাটেগরি তৈরি করে
     */
    private function createDefaultCategoriesForUser(User $user)
    {
        // আয়ের ক্যাটেগরি
        $incomeCategories = [
            ['name' => 'Salary', 'color' => '#28a745', 'icon' => 'fas fa-money-bill-wave'],
            ['name' => 'Bonus', 'color' => '#17a2b8', 'icon' => 'fas fa-gift'],
            ['name' => 'Rent', 'color' => '#6610f2', 'icon' => 'fas fa-home'],
            ['name' => 'Sales', 'color' => '#fd7e14', 'icon' => 'fas fa-shopping-cart'],
            ['name' => 'Profit', 'color' => '#20c997', 'icon' => 'fas fa-chart-line'],
            ['name' => 'Others', 'color' => '#6c757d', 'icon' => 'fas fa-ellipsis-h'],
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
            ['name' => 'Food', 'color' => '#dc3545', 'icon' => 'fas fa-utensils'],
            ['name' => 'Transport', 'color' => '#fd7e14', 'icon' => 'fas fa-bus'],
            ['name' => 'Bills', 'color' => '#6610f2', 'icon' => 'fas fa-file-invoice'],
            ['name' => 'Medical', 'color' => '#17a2b8', 'icon' => 'fas fa-pills'],
            ['name' => 'Clothing', 'color' => '#20c997', 'icon' => 'fas fa-tshirt'],
            ['name' => 'Education', 'color' => '#28a745', 'icon' => 'fas fa-graduation-cap'],
            ['name' => 'Entertainment', 'color' => '#e83e8c', 'icon' => 'fas fa-film'],
            ['name' => 'Others', 'color' => '#6c757d', 'icon' => 'fas fa-ellipsis-h'],
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
    }
}
