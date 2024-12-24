<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use LaravelZero\Framework\Commands\Command;

class RunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a series of commands to generate the site';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('import:audio', [
            'folder' => 'data/media/audio/songs'
        ]);

        Artisan::call('import:opml', [
            'file' => '../feeds_2024-11-30.opml.xml'
        ]);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
