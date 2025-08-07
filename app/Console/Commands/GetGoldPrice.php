<?php

namespace App\Console\Commands;

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
        $url = 'https://rate.bot.com.tw/gold?Lang=zh-TW';
        $response = file_get_contents($url);

        libxml_use_internal_errors(true); // ignore HTML parsing errors
        $dom = new \DOMDocument();
        $dom->loadHTML($response);
        $xpath = new \DOMXPath($dom);

        $rows = $xpath->query('//table[1]/tbody/tr[2]/td[3]');
        if ($rows->length > 0) {
            $cell = $rows->item(0); // DOMElement
            $value = trim($cell->nodeValue); // 取出文字內容
            $goldSellPrice = intval(str_replace('回售', '', preg_replace('/\s+/', '', $value)));
            Cache::put('gold_sell_price', $goldSellPrice, 3600);
        }

        $rows = $xpath->query('//table[1]/tbody/tr[1]/td[3]');
        if ($rows->length > 0) {
            $cell = $rows->item(0); // DOMElement
            $value = trim($cell->nodeValue); // 取出文字內容
            $goldBuyPrice = intval(str_replace('買進', '', preg_replace('/\s+/', '', $value)));
            Cache::put('gold_buy_price', $goldBuyPrice, 3600);
        }
    }
}
