<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchAstro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-astro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch daily astrology data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $helper = new \App\Helpers\AstroHelper();

        $progressBar = $this->output->createProgressBar(12);
        $progressBar->start();

        for ($i = 0; $i < 12; $i++) {
            $data = $helper->get($i);
            Cache::put("astro_{$i}", $data, now()->addHours(24));
            $progressBar->advance();
            usleep(rand(500000, 1500000));
        }

        $progressBar->finish();
    }
}
