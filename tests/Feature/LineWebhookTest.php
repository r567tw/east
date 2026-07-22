<?php

namespace Tests\Feature;

use App\Services\LineWebhookService;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;
use Tests\TestCase;

class LineWebhookTest extends TestCase
{
    public function test_line_webhook_normal_message()
    {
        $this->withoutMiddleware();
        Http::fake();

        $payload = [
            'events' => [[
                'type' => 'message',
                'replyToken' => 'reply456',
                'source' => ['userId' => 'U654321'],
                'message' => [
                    'type' => 'text',
                    'text' => '哈囉',
                ],
            ]],
        ];

        $response = $this->postJson('/api/line/webhook', $payload);
        $response->assertStatus(200);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.line.me/v2/bot/message/reply';
        });
    }
}
