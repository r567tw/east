<?php

namespace App\Console\Commands;

use App\Models\ShortUrl;
use Illuminate\Console\Command;

class CleanShortUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-short-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up short URLs that are no longer in use';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ShortUrl::where('expires_at', '<=', now())->delete();
    }
}
