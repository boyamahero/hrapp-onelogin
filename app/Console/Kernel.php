<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('modelCache:clear')
                 ->dailyAt('07:00')
                 ->timezone('Asia/Bangkok');

        $schedule->command('scout:flush "App\Employee"')
                 ->dailyAt('07:01')
                 ->timezone('Asia/Bangkok');

        $schedule->command('scout:import "App\Employee"')
                 ->dailyAt('07:02')
                 ->timezone('Asia/Bangkok');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
