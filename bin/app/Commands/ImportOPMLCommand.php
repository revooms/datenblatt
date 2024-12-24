<?php

namespace App\Commands;

use SimpleXMLElement;
use DateTimeImmutable;

use Illuminate\Support\Str;
use function Termwind\render;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ImportOPMLCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'import:opml

                            {file : The name of the .opml file (required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Import an OPML file as categorized feed urls';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // 1. Create folder for the category
        // 2. Write every url as slug markdown file to the folder
        $baseFeedsOutputfolder = env('OUTPUTFOLDER_FEEDS');
        $feedsFile = $this->argument('file');
        $opml = file_get_contents($feedsFile);

        $xml = new SimpleXMLElement($opml);
        foreach ($xml->body->outline as $cat) {
            // Create .md Markdown file
            $filename = sprintf('%s/%s.md', $baseFeedsOutputfolder, Str::slug($cat->attributes()['text']));
            $date = new DateTimeImmutable();
            $filecontents = sprintf(
                "---\nlayout: feedlist\ntitle: %s\ncreated_at: %s\ngenerated_at: %s\ntags:\n- feed\n- rss\n- %s\n---\n",
                $cat->attributes()['text'],
                $xml->head->dateCreated,
                $date->format('Y-m-d H:i:s'),
                $cat->attributes()['text']
            );
            $filecontents .= sprintf("\n# %s\n", $cat->attributes()['text']);

            foreach ($cat->outline as $url) {
                // dump($url->attributes());
                $filecontents .= sprintf("\n- [%s](%s)\n%s\n", $url->attributes()['text'], $url->attributes()['htmlUrl'], $url->attributes()['xmlUrl']);
                if (!empty($url->attributes()['description'])) {
                    $filecontents .= sprintf("\n\t- \"_%s_\"\n", $url->attributes()['description']);
                }
            }

            // write to file:
            file_put_contents($filename, $filecontents);

            // Create .json JSON file
            $filename = sprintf('%s/%s.json', $baseFeedsOutputfolder, Str::slug($cat->attributes()['text']));
            $date = new DateTimeImmutable();

            $data = [];

            foreach ($cat->outline as $url) {
                $urlData = [
                    'text' => (string) $url->attributes()['text'][0],
                    'htmlUrl' => (string) $url->attributes()['htmlUrl'][0],
                    'xmlUrl' => (string) $url->attributes()['xmlUrl'][0],
                    'category' => (string) $cat->attributes()['text'],
                ];
                if (!empty($url->attributes()['description'])) {
                    $urlData['description'] = (string) $url->attributes()['description'][0];
                }
                $data[] = $urlData;
            }

            // write to file:
            file_put_contents($filename, json_encode($data));
        }
        // $this->notify("Hello Web Artisan", "Love beautiful..", "icon.png");
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
