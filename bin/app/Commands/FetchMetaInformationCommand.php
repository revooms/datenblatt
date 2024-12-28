<?php

namespace App\Commands;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class FetchMetaInformationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:meta

                            {url : The URL to fetch meta information for (required)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches meta information (HTTP Status, Length, MimeType, etc) for a given URL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->argument('url');

        // Make HEAD request to the url, save the results
        try {
            $httpClient = new Client([
                'verify' => false
            ]);
            $headResponse = $httpClient->head($url);
            if (!in_array($headResponse->getStatusCode(), [200, 201])) {
                dump($headResponse);
            }

            $getResponse = Http::withoutVerifying()->get($url);
            // create a new Simple HTML DOM instance and parse the HTML
            // $html = str_get_html($getResponse->body());

            dd($getResponse->body());
            
            $output = [
                'originalUrl' => $url,
                'statusCode' => $headResponse->getStatusCode(),
                'response' => [
                    'headers' => $headResponse->getHeaders()
                ],
                'meta' => [
                    'title' => $parsed->title,

                ]
            ];
            echo json_encode($output);
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
