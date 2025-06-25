<?php

namespace App\Services;

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
            return "黃金價格查詢功能未來將實作。";
        }

        if ($command === '天氣') {
            return "天氣查詢功能未來將實作。";
        }

        return "未知指令：{$command}，請使用 @help 查看可用指令。";
    }
}
