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
        \App\Console\Commands\Api\Personal::class,
        \App\Console\Commands\Api\Projects::class,
        \App\Console\Commands\Api\Tasks::class,
        \App\Console\Commands\Api\TimeRecords::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('api:personal')->dailyAt('21:00');
        $schedule->command('api:projects')->dailyAt('21:30');
        $schedule->command('api:tasks')->dailyAt('22:00');

        $schedule->command('api:timerecords')->dailyAt('22:30');
        $schedule->command('api:timerecords')->dailyAt('23:00');

        $schedule->command('emails:closed-time')->weekly()->mondays()->at('8:00');
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
