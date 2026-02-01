<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * These schedules define the application's command schedule. These schedules are run in the background and do not affect the user experience.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire:inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        // রেজিস্ট্রেশনের পর ডিফল্ট অ্যাকাউন্ট তৈরি করার কমান্ড যোগ করা
        $this->commands([
            \App\Console\Commands\CreateDefaultAccountsForExistingUsers::class,
            \App\Console\Commands\FixUserAccounts::class,
        ]);

        $this->commands = [
            Commands\UpdateCategories::class,
            Commands\FixDuplicateCategories::class,
        ];
    }
} 