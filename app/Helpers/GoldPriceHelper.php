<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GoldPriceHelper
{
    public function getGoldPrice(): array
    {
        $url = 'https://rate.bot.com.tw/gold?Lang=zh-TW';
        $response = Http::retry(3, 5000)->get($url)->body();

        libxml_use_internal_errors(true); // ignore HTML parsing errors

        $dom = new \DOMDocument();
        $dom->loadHTML($response);
        $xpath = new \DOMXPath($dom);

        $rows = $xpath->query('//table[1]/tbody/tr[2]/td[3]');
        if ($rows->length > 0) {
            $cell = $rows->item(0); // DOMElement
            $value = trim($cell->nodeValue); // 取出文字內容
            $goldSellPrice = intval(str_replace('回售', '', preg_replace('/\s+/', '', $value)));
        }

        $rows = $xpath->query('//table[1]/tbody/tr[1]/td[3]');
        if ($rows->length > 0) {
            $cell = $rows->item(0); // DOMElement
            $value = trim($cell->nodeValue); // 取出文字內容
            $goldBuyPrice = intval(str_replace('買進', '', preg_replace('/\s+/', '', $value)));
        }

        return [
            $goldSellPrice ?? 0,
            $goldBuyPrice ?? 0,
        ];
    }
}
