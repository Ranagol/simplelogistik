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
        // $schedule->command('inspire')->hourly();

        // Export all customers that are new or have changed( exported_at != updated_at) to a file every day at 02:00
        $schedule->command('customers-export')->everyMinute();

        // Pamyra cronjob test
        $schedule->command('pamyraorders')->everyMinute();

        // Handle Pamyra orders
        $schedule->command('handlePamyraOrders')->everyFifteenMinutes();
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
