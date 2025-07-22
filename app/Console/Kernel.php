<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run credit expiration check daily at midnight
        $schedule->command('credits:expire')
                 ->daily()
                 ->description('Expire user credits that have passed their expiration date');
        
        // Alternatively, you can run it hourly for more frequent checks:
        // $schedule->command('credits:expire')->hourly();
        
        // Or every 30 minutes:
        // $schedule->command('credits:expire')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
