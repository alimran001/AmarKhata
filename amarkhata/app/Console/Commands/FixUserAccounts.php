<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Account;

class FixUserAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ডুপ্লিকেট অ্যাকাউন্ট মুছে ফেলে এবং নিশ্চিত করে যে সব ইউজারের ডিফল্ট অ্যাকাউন্ট আছে';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('ইউজারদের অ্যাকাউন্ট ঠিক করা হচ্ছে...');
        
        $users = User::all();
        $defaultAccounts = [
            ['name' => 'Cash In Hand', 'type' => 'Cash', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'My Bank', 'type' => 'Bank', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'bKash', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'Nagad', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'Rocket', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
            ['name' => 'Others', 'type' => 'Other', 'initial_balance' => 0, 'is_default' => true],
        ];
        
        foreach ($users as $user) {
            $this->info("ইউজার {$user->name} ({$user->id}) এর অ্যাকাউন্ট ঠিক করা হচ্ছে...");
            
            // Rename old accounts
            $this->renameOldAccounts($user);
            
            // Remove duplicates
            $this->removeDuplicateAccounts($user);
            
            // Ensure all default accounts exist
            $this->ensureDefaultAccounts($user, $defaultAccounts);
            
            $this->info("ইউজার {$user->name} এর অ্যাকাউন্ট ঠিক করা হয়েছে।");
        }
        
        $this->info('সব ইউজারের অ্যাকাউন্ট ঠিক করা হয়েছে!');
        
        return Command::SUCCESS;
    }
    
    /**
     * পুরানো অ্যাকাউন্টের নাম পরিবর্তন করে
     */
    private function renameOldAccounts(User $user)
    {
        // Rename Bangladesh Bank to My Bank
        $bangladeshBank = Account::where('user_id', $user->id)
            ->where('name', 'Bangladesh Bank')
            ->first();
            
        if ($bangladeshBank) {
            $bangladeshBank->name = 'My Bank';
            $bangladeshBank->save();
            $this->line("- 'Bangladesh Bank' অ্যাকাউন্টের নাম 'My Bank' করা হয়েছে");
        }
        
        // Rename Nagod to Nagad
        $nagod = Account::where('user_id', $user->id)
            ->where('name', 'Nagod')
            ->first();
            
        if ($nagod) {
            $nagod->name = 'Nagad';
            $nagod->save();
            $this->line("- 'Nagod' অ্যাকাউন্টের নাম 'Nagad' করা হয়েছে");
        }
    }
    
    /**
     * ডুপ্লিকেট অ্যাকাউন্ট মুছে ফেলে
     */
    private function removeDuplicateAccounts(User $user)
    {
        $uniqueNames = ['Cash In Hand', 'My Bank', 'bKash', 'Nagad', 'Rocket', 'Others'];
        
        foreach ($uniqueNames as $name) {
            $accounts = Account::where('user_id', $user->id)
                ->where('name', $name)
                ->orderBy('created_at')
                ->get();
            
            // Keep the first one, delete others
            if ($accounts->count() > 1) {
                $this->line("- {$name}: {$accounts->count()} টি অ্যাকাউন্ট পাওয়া গেছে, অতিরিক্তগুলো মুছে ফেলা হচ্ছে");
                
                // Keep the first one (oldest)
                $keep = $accounts->first();
                
                // Delete the rest
                for ($i = 1; $i < $accounts->count(); $i++) {
                    $accounts[$i]->delete();
                }
            }
        }
    }
    
    /**
     * নিশ্চিত করে যে সব ডিফল্ট অ্যাকাউন্ট আছে
     */
    private function ensureDefaultAccounts(User $user, array $defaultAccounts)
    {
        foreach ($defaultAccounts as $account) {
            $exists = Account::where('user_id', $user->id)
                ->where('name', $account['name'])
                ->exists();
                
            if (!$exists) {
                $this->line("- '{$account['name']}' অ্যাকাউন্ট নেই, তৈরি করা হচ্ছে");
                
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