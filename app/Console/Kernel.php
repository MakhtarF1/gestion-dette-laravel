<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ArchiveAllDettesCommand;
use App\Jobs\SendSmsJob;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ArchiveAllDettesCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Planifiez la commande d'archivage pour qu'elle s'exécute toutes les 30 secondes
        // $schedule->command('archive:all-dettes')->everyThirtySeconds();
        $schedule->job(new SendSmsJob())->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
