<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Account;

class CreateDefaultAccountsForExistingUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:create-defaults {--user=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'বিদ্যমান ইউজারদের জন্য ডিফল্ট অ্যাকাউন্ট তৈরি করে';

    // ডিফল্ট অ্যাকাউন্টের তালিকা
    protected $defaultAccounts = [
        ['name' => 'Cash In Hand', 'type' => 'Cash', 'initial_balance' => 0, 'is_default' => true],
        ['name' => 'My Bank', 'type' => 'Bank', 'initial_balance' => 0, 'is_default' => true],
        ['name' => 'bKash', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
        ['name' => 'Nagad', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
        ['name' => 'Rocket', 'type' => 'Mobile Banking', 'initial_balance' => 0, 'is_default' => true],
        ['name' => 'Others', 'type' => 'Other', 'initial_balance' => 0, 'is_default' => true],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user');
        $force = $this->option('force');
        
        if ($userId) {
            // নির্দিষ্ট ইউজারের জন্য অ্যাকাউন্ট তৈরি করা
            $user = User::find($userId);
            if (!$user) {
                $this->error("ইউজার আইডি {$userId} পাওয়া যায়নি!");
                return Command::FAILURE;
            }
            
            $this->createDefaultAccountsForUser($user, $force);
        } else {
            // সব ইউজারের জন্য অ্যাকাউন্ট তৈরি করা
            $users = User::all();
            $this->info("মোট {$users->count()} জন ইউজারের জন্য ডিফল্ট অ্যাকাউন্ট তৈরি করা হচ্ছে...");
            
            $bar = $this->output->createProgressBar(count($users));
            $bar->start();
            
            foreach ($users as $user) {
                $this->createDefaultAccountsForUser($user, $force);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();
            $this->info('সব ইউজারের জন্য ডিফল্ট অ্যাকাউন্ট তৈরি করা হয়েছে!');
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * নির্দিষ্ট ইউজারের জন্য ডিফল্ট অ্যাকাউন্ট তৈরি করে
     */
    private function createDefaultAccountsForUser(User $user, bool $force = false)
    {
        $createdCount = 0;
        $skippedCount = 0;
        
        foreach ($this->defaultAccounts as $accountData) {
            // চেক করি অ্যাকাউন্ট আগে থেকে আছে কিনা
            $exists = Account::where('user_id', $user->id)
                ->where('name', $accountData['name'])
                ->exists();
                
            if ($exists && !$force) {
                $skippedCount++;
                continue;
            }
            
            if ($exists && $force) {
                // আগের অ্যাকাউন্ট মুছে নতুন অ্যাকাউন্ট তৈরি করা
                Account::where('user_id', $user->id)
                    ->where('name', $accountData['name'])
                    ->delete();
            }
            
            // নতুন অ্যাকাউন্ট তৈরি করা
            Account::create([
                'name' => $accountData['name'],
                'type' => $accountData['type'],
                'initial_balance' => $accountData['initial_balance'],
                'current_balance' => $accountData['initial_balance'],
                'user_id' => $user->id,
                'is_default' => $accountData['is_default'],
            ]);
            
            $createdCount++;
        }
        
        if ($this->option('user')) {
            $this->info("ইউজার {$user->name} ({$user->id}) এর জন্য {$createdCount}টি অ্যাকাউন্ট তৈরি করা হয়েছে, {$skippedCount}টি অ্যাকাউন্ট আগে থেকেই ছিল।");
        }
    }
}
