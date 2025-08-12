<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class AirQualityHelper
{
    public static function getAirQuality(float $lat, float $lng)
    {
        // 假設這裡有一個 API 可以獲取空氣品質數據
        $apiUrl = "https://tw-air-status.r567tw.workers.dev?log={$lng}&lat={$lat}";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();
            $air = $data["air"] ?? "結果取得失敗";
        } else {
            $air = "空氣品質Api回傳出現問題，請稍後再試。";
        }

        return "空氣品質：{$air}";
    }
}
