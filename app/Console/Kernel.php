<?php

namespace App\Console;

use App\Jobs\SendWeeklyDigestEmail;
use App\Jobs\SendMonthlyDigestEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send weekly digest emails (Monday at 8 AM)
        $schedule->job(new SendWeeklyDigestEmail)
            ->weekly()
            ->mondays()
            ->at('08:00')
            ->timezone('UTC')
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Weekly digest job failed');
            });

        // Send monthly digest emails (1st of month at 8 AM)
        $schedule->job(new SendMonthlyDigestEmail)
            ->monthlyOn(1, '08:00')
            ->timezone('UTC')
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Monthly digest job failed');
            });

        // Clean up old jobs from queue table (daily at 2 AM)
        $schedule->command('queue:prune-batches')
            ->daily()
            ->at('02:00')
            ->timezone('UTC');

        // Prune failed jobs (weekly)
        $schedule->command('queue:prune-failed')
            ->weekly()
            ->sundays()
            ->at('03:00')
            ->timezone('UTC');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
