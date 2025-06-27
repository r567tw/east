<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class gold
{

    public static function getGoldPrice(): array
    {
        $goldSellPrice = Cache::remember('gold_sell_price', 3600, function () {
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
                return intval(str_replace('回售', '', preg_replace('/\s+/', '', $value)));
            } else {
                echo "查無資料";
            }
        });

        $goldBuyPrice = Cache::remember('gold_buy_price', 3600, function () {
            $url = 'https://rate.bot.com.tw/gold?Lang=zh-TW';
            $response = file_get_contents($url);

            libxml_use_internal_errors(true); // ignore HTML parsing errors
            $dom = new \DOMDocument();
            $dom->loadHTML($response);
            $xpath = new \DOMXPath($dom);

            $rows = $xpath->query('//table[1]/tbody/tr[1]/td[3]');
            if ($rows->length > 0) {
                $cell = $rows->item(0); // DOMElement
                $value = trim($cell->nodeValue); // 取出文字內容
                return intval(str_replace('買進', '', preg_replace('/\s+/', '', $value)));
            } else {
                echo "查無資料";
            }
        });

        return [$goldSellPrice, $goldBuyPrice];
    }
}
