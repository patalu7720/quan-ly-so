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
        // $schedule->command('auto-alert-contract-mail')->dailyAt('8:00');
        $schedule->command('warning-time-out-approve-x-x-d-h')->everyThirtyMinutes()->between('8:00', '17:00');;
        $schedule->command('warning-time-out-approve-t-k-s-x')->everyThirtyMinutes()->between('8:00', '17:00');;
        // $schedule->command('warning-time-out_-x-n-d-h_-t-d-g')->everyFourHours();
        $schedule->command('warning-time-out_-t-d-g_-h-d')->everyFourHours();
        // $schedule->command('warning-time-out_-h-d_-scan')->everyFourHours();
        // $schedule->command('warning-time-out-confirm-bao-gia')->everyFourHours();
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
