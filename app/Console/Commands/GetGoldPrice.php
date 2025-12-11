<?php

namespace App\Console\Commands;

use App\Helpers\GoldPriceHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GetGoldPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-gold-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Gold Price';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$goldSellPrice, $goldBuyPrice] = (new GoldPriceHelper)->getGoldPrice();
        Cache::put('gold_sell_price', $goldSellPrice, 3600);
        Cache::put('gold_buy_price', $goldBuyPrice, 3600);
    }
}
