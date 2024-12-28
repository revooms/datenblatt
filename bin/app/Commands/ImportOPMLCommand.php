<?php

namespace App\Commands;

use DateTime;
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
        // 1. Write everything to one single file
        
        $baseFeedsOutputfolder = config('datenblatt.urls_output_path');
        $feedsFile = $this->argument('file');
        $opml = file_get_contents($feedsFile);

        $xml = new SimpleXMLElement($opml);
        $date = new DateTimeImmutable();
        $markdownMeta = [
            'title' => 'RSS/Atom feed URLs',
            'created_at' => $date->format('Y-m-d H:i:s'),
            'tags' => ['feed', 'atom', 'rss', 'url'],
        ];
        $markdown = "---";
        foreach ($markdownMeta as $key => $value) {
            if(!is_array($value)) {
                $markdown .= sprintf("\n%s: %s", $key, $value);
            } else {
                $markdown .= sprintf("\n%s: %s", $key, "\n  - " . implode("\n  - ", $value));
            }
        }
        $markdown .= "\n---";
        
        $markdown .= "\n\n# " . $markdownMeta['title'];
        // $markdown .= " (" . $markdownMeta['title'] . ")";
        $markdown .= "\nListe einiger RSS-/Atom-Feeds, sortiert nach Kategorie";

        foreach ($xml->body->outline as $cat) {
            $markdown .= "\n## " . $cat->attributes()['text'];

            // Create .md Markdown file
            // $filename = sprintf('%s/%s.md', $baseFeedsOutputfolder, Str::slug($cat->attributes()['text']));
            // $this->info(sprintf('Writing to file %s', str_replace($baseFeedsOutputfolder, env('OUTPUTFOLDER_FEEDS'), $filename)));
            // $date = new DateTimeImmutable();
            // $filecontents = sprintf(
            //     "---\nlayout: feedlist\ntitle: %s\ncreated_at: %s\ngenerated_at: %s\ntags:\n- feed\n- rss\n- %s\n---\n",
            //     $cat->attributes()['text'],
            //     $xml->head->dateCreated,
            //     $date->format('Y-m-d H:i:s'),
            //     $cat->attributes()['text']
            // );
            // $filecontents .= sprintf("\n# %s\n", $cat->attributes()['text']);

            foreach ($cat->outline as $url) {
                // dd($url->attributes());
                $title = $url->attributes()['text'];
                $description = $url->attributes()['description'] ?? null;
                $xmlUrl = $url->attributes()['xmlUrl'];
                $url = $url->attributes()['htmlUrl'];

                $markdown .= "\n- [$title]($url)";
                $markdownTemplate = "\n### [{$title}]($url)";
                if(!empty($description)) {
                    $markdown .= "\n\"_<small>{$description}</small>_\"";
                    $markdownTemplate .= "\n\"_<small>{$description}</small>_\"";
                }
                // $markdownTemplate .= "\n[$url]($url)";
                // $filecontents .= $markdownTemplate;
            }

            // write to file:
            // file_put_contents($filename, $filecontents);

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

        $filename = $baseFeedsOutputfolder . '/index.md';
        $this->info(sprintf('Writing to file %s', str_replace($baseFeedsOutputfolder, config('datenblatt.urls_output_path'), $filename)));
        file_put_contents($filename, $markdown);

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
