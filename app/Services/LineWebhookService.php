<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class LineWebhookService
{
    public function process($message)
    {
        $message = trim($message); // 去除前後空白
        $message = mb_strtolower($message);
        $message = str_replace('／', '/', $message); // 將全形斜線轉為半形斜線


        // 第一個字元是 '/'，表示這是一個指令 例如 '/黃金' 或 '/天氣'
        if (mb_substr($message, 0, 1) === '/') {
            $message = mb_substr($message, 1); // 去除 '/' 符號
            $message = trim($message); // 去除前後空白
            return $this->processCommand($message);
        }

        return "你說的是：「{$message}」";
    }

    public function processCommand($command)
    {
        if ($command === '黃金') {
            $goldBuyPrice = Cache::get('gold_buy_price', 0);
            $goldSellPrice = Cache::get('gold_sell_price', 0);

            return "黃金價格查詢結果：\n買進：{$goldBuyPrice} 元/克\n回售：{$goldSellPrice} 元/克";
        }

        if ($command === '天氣') {
            return (new \App\Helpers\WeatherHelper())->getWeather("高雄市");
        }

        return "未知指令：{$command}，請使用 /help 查看可用指令。";
    }
}
