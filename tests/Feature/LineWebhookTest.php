<?php

namespace Tests\Feature;

use App\Services\LineWebhookService;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;
use Tests\TestCase;

class LineWebhookTest extends TestCase
{
    public function test_line_webhook_bind_command()
    {
        $this->withoutMiddleware();
        $this->mock(LineWebhookService::class, function (MockInterface $mock) {
            $mock->shouldReceive('bind')
                ->once()
                ->with('123456', 'U123456')
                ->andReturn('綁定成功');
        });

        Http::fake();

        $payload = [
            'events' => [[
                'type' => 'message',
                'replyToken' => 'reply123',
                'source' => ['userId' => 'U123456'],
                'message' => [
                    'type' => 'text',
                    'text' => '/綁定:123456',
                ],
            ]],
        ];

        $response = $this->postJson('/line/webhook', $payload);
        $response->assertStatus(200);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.line.me/v2/bot/message/reply';
        });
    }

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

        $response = $this->postJson('/line/webhook', $payload);
        $response->assertStatus(200);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.line.me/v2/bot/message/reply';
        });
    }

    public function test_line_webhook_bind_command_no_invite_code()
    {
        $this->withoutMiddleware();
        Http::fake();

        $payload = [
            'events' => [[
                'type' => 'message',
                'replyToken' => 'reply123',
                'source' => ['userId' => 'U123456'],
                'message' => [
                    'type' => 'text',
                    'text' => '/綁定:',
                ],
            ]],
        ];

        $response = $this->postJson('/line/webhook', $payload);
        $response->assertStatus(200);
        Http::assertSent(function ($request) {
            $data = $request['messages'] ?? [];

            return isset($data[0]['text']) && $data[0]['text'] === '請提供邀請碼。';
        });
    }
}
