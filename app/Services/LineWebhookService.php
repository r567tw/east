<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LineWebhookService
{
    public function bind($inviteCode, $lineUserId)
    {
        $inviteCode = DB::table('invite_codes')
            ->where('code', $inviteCode)
            ->where('expires_at', '>', now())
            ->first();

        if (!$inviteCode) {
            return "無效的邀請碼。";
        }
        $userId = $inviteCode->user_id;
        User::where('id', $userId)->update(['line_user_id' => $lineUserId]);
        return "成功綁定 LINE 帳號！";
    }

    public function process($message, $user = null)
    {
        $message = trim($message); // 去除前後空白
        $message = mb_strtolower($message);
        $message = str_replace('／', '/', $message); // 將全形斜線轉為半形斜線


        // 第一個字元是 '/'，表示這是一個指令 例如 '/黃金' 或 '/天氣'
        if (mb_substr($message, 0, 1) === '/') {
            $message = mb_substr($message, 1); // 去除 '/' 符號
            $message = trim($message); // 去除前後空白
            return $this->processCommand($message, $user);
        }

        // 改成問 AI
        $helper = new \App\Helpers\AiHelper();
        $message = $helper->ask($message);
        if (empty($message)) {
            return "你說的是：「{$message}」";
        } else {
            return $message;
        }
    }

    public function processCommand($command, $user = null)
    {
        if ($command === '黃金') {
            $goldBuyPrice = Cache::get('gold_buy_price', 0);
            $goldSellPrice = Cache::get('gold_sell_price', 0);

            return "黃金價格查詢結果：\n買進：{$goldBuyPrice} 元/克\n回售：{$goldSellPrice} 元/克";
        }

        if ($command === '天氣') {
            if ($user == null) {
                return "請先綁定 LINE 帳號。";
            }

            if (empty($user->location)) {
                return "請先設定你的位置。";
            }
            return (new \App\Helpers\WeatherHelper())->getWeather($user->location);
        }

        if ($command === '空氣') {
            if ($user == null) {
                return "請先綁定 LINE 帳號。";
            }

            if (empty($user->location)) {
                return "請先設定你的位置。";
            }
            return (new \App\Helpers\AirQualityHelper())->getAirQuality($user->lat, $user->lng);
        }

        if ($command === '位置') {
            if ($user == null) {
                return "請先綁定 LINE 帳號。";
            }

            if (empty($user->location)) {
                return "請先設定你的位置。";
            }
            return "你的經緯度: {$user->lat},{$user->lng}\n城市：{$user->location}";
        }

        if ($command === 'cpbl') {
            $result = (new \App\Helpers\CPBLHelper())->get();
            return rtrim($result, "\n");
        }

        if (strpos($command, '運勢') === 0) {
            // 例如 '運勢,射手座' 表示查詢射手座
            $astroName = str_replace('運勢:', '', $command);
            $astroName = str_replace('運勢', '', $astroName);
            $astroName = trim($astroName);

            if (empty($astroName)) {
                $astroName = "射手座"; // 預設為射手座
            }

            $astroMap = config('astro.chinese');
            $astroIndex = $astroMap[$astroName] ?? null;

            if ($astroIndex === null) {
                return "未知的星座名稱：{$astroName}。目前尚未支援";
            }

            if (Cache::has("astro_{$astroIndex}")) {
                return Cache::get("astro_{$astroIndex}");
            } else {
                $astroHelper = new \App\Helpers\AstroHelper();
                $result = $astroHelper->get($astroIndex);
                return $result;
            }
        }

        if (strpos($command, '精簡') === 0) {
            $text = str_replace('精簡', '', $command);
            $helper = new \App\Helpers\AiHelper();
            return $helper->summarizeText($text);

            return $this->bind($inviteCode, $user->line_user_id ?? null);
        }

        if ($command === 'help') {
            return "可用指令：\n/黃金 - 查詢黃金價格(每小時一次)\n/天氣 - 查詢天氣\n/空氣 - 查詢空汙\n/位置 - 查詢你綁定帳號後的經緯度和城市\n綁定 LINE 帳號請使用 /綁定:<邀請碼>\n例如：/綁定:123456";
        }

        return "未知指令：{$command}，請使用 /help 查看可用指令。";
    }
}
