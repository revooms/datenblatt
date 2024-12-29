<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class CheckFoldersCaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:folders';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes sure folders are always lowercase and their .meta.yml file exists';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rootpath = config('datenblatt.base_path');
        $this->info('Checking folders in ' . $rootpath);
        
        $level = 0;
        do {
            $pattern = $rootpath . str_repeat("/**", $level) . '/*';
            $folders = glob($pattern, \GLOB_ONLYDIR);
            // dump($folders);
            foreach($folders as $folder) {
                $fullPath = $folder;
                $folder = str_replace($rootpath, '', $folder);
                if(strtolower($folder) !== $folder) {
                    $this->warn($folder . ' needs renaming');
                    if(rename($fullPath, strtolower($fullPath))) {
                        $this->info(' - Renamed succesfully');
                    } else {
                        $this->error('Could not rename ' . $fullPath);
                    }
                } else {
                    // $this->info($folder . ' is OK');
                }
            }
            $level++;
        } while (count($folders) > 0);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
