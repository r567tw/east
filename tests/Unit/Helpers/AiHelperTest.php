<?php

namespace Tests\Unit\Helpers;

use App\Helpers\AiHelper;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiHelperTest extends TestCase
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
        $result = AiHelper::summarizeText('這是一段很長的文字');
        $this->assertEquals('精簡後內容', $result);
    }

    public function test_ask_failed()
    {
        Http::fake([
            '*' => Http::response([], 500),
        ]);
        $result = AiHelper::ask('問題');
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
        $result = AiHelper::translate('hello');
        $this->assertEquals('翻譯後內容', $result);
    }
}
