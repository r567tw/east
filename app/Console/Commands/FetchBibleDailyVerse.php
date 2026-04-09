<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FetchBibleDailyVerse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-bible-daily-verse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the daily Bible verse and store it in the cache for 24 hours.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var \Illuminate\Http\Client\Response $response */
        $response = Http::retry(3, 5000)->get('https://taiwanbible.com/blog/dailyverse.jsp');
        if ($response->successful()) {
            $result = trim(str_replace(["\r", "\n", "\t"], "", $response->body()));
            Cache::put('bible_daily_verse', $result, now()->addHours(24));
        } else {
            $this->error('Failed to fetch the daily verse. Status: ' . $response->status());
            Cache::put('bible_daily_verse', "查詢錯誤", now()->addHours(24));
        }
    }
}
