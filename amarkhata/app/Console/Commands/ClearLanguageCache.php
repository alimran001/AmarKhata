<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class ClearLanguageCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'language:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear language cache';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Clearing language cache...');
        
        // Clear all cache
        Cache::flush();
        
        // Clear session
        Session::flush();
        
        $this->info('Language cache cleared successfully.');
        
        return Command::SUCCESS;
    }
} 