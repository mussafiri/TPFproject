<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        commands\ContributorsUpload::class,
        commands\MembersUpload::class,
        commands\ContributionsUpload::class,
        commands\UsersUpload::class,
        commands\SectionsUpload::class,
        commands\ContributorMemberUpload::class,
        commands\ArrearCheck::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('ArrearCheck')->monthlyOn(1)->timezone('Africa/Dar_es_Salaam')->at('00:01');
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
