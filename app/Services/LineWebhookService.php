<?php

namespace App\Services;

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Cache;

class LineWebhookService
{
    public function process($message)
    {
        $message = trim($message); // 去除前後空白

        if (mb_substr($message, 0, 1) === '@') {
            return $this->processCommand($message);
        }

        return "你說的是：「{$message}」";
    }

    public function processCommand($message)
    {
        $command = mb_substr($message, 1); // 去除 '@' 符號
        $command = trim($command); // 去除前後空白

        if ($command === '黃金') {
            // 這裡可以呼叫 HomeController 的 goldPrice 方法來獲取黃金價格
            $goldBuyPrice = Cache::get('gold_buy_price', 0);
            $goldSellPrice = Cache::get('gold_sell_price', 0);

            return "黃金價格查詢結果：\n買進：{$goldBuyPrice} 元/克\n回售：{$goldSellPrice} 元/克";
        }

        if ($command === '天氣') {
            return "天氣查詢功能未來將實作。";
        }

        return "未知指令：{$command}，請使用 @help 查看可用指令。";
    }
}
