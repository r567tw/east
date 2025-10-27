<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class AiHelper
{
    /**
     * 使用 Google Gemini API 精簡文字
     *
     * @param string $text 要精簡的文字
     * @return string 精簡後的文字或錯誤訊息
     */
    public static function summarizeText(string $text): string
    {
        $apiKey = config('app.google_gemini_api_key'); // 請將 API Key 放在 .env
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";
        $payload = [
            "contents" => [[
                "parts" => [[
                    "text" => "請在不改變意思的情況下，將以下文字精簡成 100 字以內。\n\n{$text}"
                ]]
            ]]
        ];

        $response = Http::post($url, $payload);

        if ($response->successful()) {
            $result = $response->json();
            $output = $result['candidates'][0]['content']['parts'][0]['text'];
            return $output ?? "結果取得失敗";
        } else {
            return "API 請求失敗，狀態碼：" . $response->status();
        }
    }
}
