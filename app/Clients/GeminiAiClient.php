<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;

class GeminiAiClient
{
    public static function prompt(string $question): string
    {
        $apiKey = config('app.google_gemini_api_key'); // 請將 API Key 放在 .env
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";
        $payload = [
            'contents' => [[
                'parts' => [[
                    'text' => $question,
                ]],
            ]],
        ];

        $response = Http::post($url, $payload);

        if ($response->successful()) {
            $result = $response->json();
            $output = $result['candidates'][0]['content']['parts'][0]['text'];

            return $output ?? '';
        } else {
            return '';
        }
    }

    public static function summarizeText(string $text): string
    {
        return self::prompt("請在不改變意思的情況下，將以下文字精簡成 150 字以內。\n\n{$text}");
    }

    public static function translate(string $text): string
    {
        $question = "請將以下文字翻譯成繁體中文，如果文字用的語言是中文則就翻譯成英文：但如果中文遇到的可能是簡體或繁體以外的例如粵語或地方方言的類型,請一樣翻譯成中文\n\n{$text}";

        return self::prompt($question);
    }
}
