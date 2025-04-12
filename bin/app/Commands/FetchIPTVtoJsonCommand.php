<?php

namespace App\Commands;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class FetchIPTVtoJsonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:iptv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the latest iptv.org channels list for DE and parses it a .json file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://raw.githubusercontent.com/iptv-org/iptv/refs/heads/master/streams/de.m3u';

        try {
            $httpClient = new Client([
                'verify' => false
            ]);
            $headResponse = $httpClient->head($url);
            if (!in_array($headResponse->getStatusCode(), [200, 201])) {
                dump($headResponse);
            }

            $getResponse = Http::withoutVerifying()->get($url);
            $m3ufile = $getResponse->body();

            $re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
            $attributes = '/([a-zA-Z0-9\-\_]+?)="([^"]*)"/';

            $m3ufile = str_replace('tvg-logo', 'thumb_square', $m3ufile);
            $m3ufile = str_replace('tvg-id', 'id', $m3ufile);
            $m3ufile = str_replace('tvg-name', 'author', $m3ufile);
            $m3ufile = str_replace('group-title', 'group', $m3ufile);
            $m3ufile = str_replace('tvg-country', 'country', $m3ufile);
            $m3ufile = str_replace('tvg-language', 'language', $m3ufile);

            preg_match_all($re, $m3ufile, $matches);
            
            $items = [];
            $itemsGeoblocked = [];

            foreach ($matches[0] as $list) {
                preg_match($re, $list, $matchList);
                $mediaURL = preg_replace("/[\n\r]/", "", $matchList[3]);
                $mediaURL = preg_replace('/\s+/', '', $mediaURL);
                $newdata =  array(
                    // 'service' => "iptv",
                    'title' => $matchList[2],
                    'url' => $mediaURL,
                    'url_playlist' => $url,
                    'url_media' => $mediaURL,
                );

                preg_match_all($attributes, $list, $matches, PREG_SET_ORDER);
                foreach ($matches as $match) {
                    $newdata[$match[1]] = $match[2];
                }

                // Check if title contains the phrase [Geo-blocked]:
                if (strstr($newdata['title'], '[Geo-blocked]')) {
                    $itemsGeoblocked[] = $newdata;
                } else {
                    $items[] = $newdata;
                }
            }

            $data = [
                'title' => "IPTV Streams DE",
                'created_at' => date('Y-m-d H:i:s'),
                'channels' => $items,
                'channels_geoblocked' => $itemsGeoblocked,
            ];

            // Write JSON to .json file in data folder
            file_put_contents("../data/api/iptv_channels_de.json", json_encode($data));
            
            exit();
        } catch (\Throwable $th) {
            throw $th;
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
