<?php

namespace App\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Date;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ImportAudioFilesCommand extends Command
{

    private $_wildcards = [
        'ogg',
        'mp3',
        'wav',
        'aiff',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:audio

                            {folder : The name of the folder to import audiofiles from (required)}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports audio files from a folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $wildcard = sprintf('*.{%s}', implode(',', $this->_wildcards));
        $pattern = sprintf('%s/%s', $this->argument('folder'), $wildcard);
        $data = '';
        $this->line(sprintf("Working with %s", $pattern));
        foreach (glob($pattern, GLOB_BRACE) as $audio) {
            $htmlUrl = str_replace('../data/', '', $audio);
            $this->line(sprintf("-- %s", $audio));
            $filesize = filesize($audio);
            $filemtime = filemtime($audio);
            $fileatime = fileatime($audio);
            $file = pathinfo($audio);

            // write to file:
            // $filename = str_replace(['.ogg', '.mp3'], '.md', $audio);
            $filename = basename($audio) . '.md';
            $filename = Str::slug($filename);
            $meta = [
                'layout' => 'audiofile',
                'title' => $file['filename'],
                'created_at' => Date::today(),
                'tags' => ['audio'],
                'size' => $filesize,
                'modified' => $filemtime,
                'time' => $fileatime,
            ];
            $filecontents = sprintf("---\n%s\n---\n", implode("\n", $meta));
            $filecontents .= sprintf("\n# %s\n", $file['filename']);
            $filecontents .= sprintf("\nSize: %s\n", $filesize);
            $filecontents .= sprintf("\nModified: %s\n", $filemtime);
            $filecontents .= sprintf("\nTime: %s\n", $fileatime);
            $filecontents .= sprintf("\nExtension: %s\n", $file['extension']);
            $filecontents .= sprintf("\n<audio src=\"%s\" controls loop>\n", $htmlUrl);

            file_put_contents($filename, $filecontents);
        }
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
