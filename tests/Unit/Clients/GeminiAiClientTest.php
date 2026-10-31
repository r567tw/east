<?php

namespace Tests\Unit\Helpers;

use App\Clients\GeminiAiClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiAiClientTest extends TestCase
{
    public function test_summarize_text_success()
    {
        Http::fake([
            '*' => Http::response([
                'candidates' => [[
                    'content' => [
                        'parts' => [[
                            'text' => '精簡後內容',
                        ]],
                    ],
                ]],
            ], 200),
        ]);
        $result = GeminiAiClient::summarizeText('這是一段很長的文字');
        $this->assertEquals('精簡後內容', $result);
    }

    public function test_prompt_failed()
    {
        Http::fake([
            '*' => Http::response([], 500),
        ]);
        $result = GeminiAiClient::prompt('問題');
        $this->assertEquals('', $result);
    }

    public function test_translate_success()
    {
        Http::fake([
            '*' => Http::response([
                'candidates' => [[
                    'content' => [
                        'parts' => [[
                            'text' => '翻譯後內容',
                        ]],
                    ],
                ]],
            ], 200),
        ]);
        $result = GeminiAiClient::translate('hello');
        $this->assertEquals('翻譯後內容', $result);
    }
}
