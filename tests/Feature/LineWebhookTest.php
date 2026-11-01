<?php

namespace Tests\Feature;

use App\Events\Line\MessageEvent;
use App\Services\LineWebhookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LineWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_controller_passes_the_webhook_events_to_the_service(): void
    {
        $events = [[
            'type' => 'message',
            'replyToken' => 'service-reply-token',
            'source' => ['userId' => 'U654321'],
            'message' => ['type' => 'text', 'text' => 'hello'],
        ]];

        $service = $this->mock(LineWebhookService::class);
        $service->shouldReceive('handle')->once()->with($events);

        $this->withoutMiddleware()
            ->postJson('/api/line/webhook', ['events' => $events])
            ->assertOk();
    }

    public function test_line_webhook_replies_to_a_normal_message_using_the_line_client(): void
    {
        $this->withoutMiddleware();
        Http::fake();
        config(['line.line_access_token' => 'test-access-token']);
        $dispatchedMessages = [];
        Event::listen(MessageEvent::class, function ($event) use (&$dispatchedMessages): void {
            $dispatchedMessages[] = $event;
        });

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
        $this->assertCount(1, $dispatchedMessages);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.line.me/v2/bot/message/reply'
                && $request->hasHeader('Authorization')
                && $request->data()['replyToken'] === 'reply456'
                && $request->data()['messages'][0]['text'] === '你說的是：「哈囉」';
        });
    }

    public function test_line_webhook_replies_to_commands(): void
    {
        $this->withoutMiddleware();
        Http::fake();
        config(['line.line_access_token' => 'test-access-token']);

        $response = $this->postJson('/api/line/webhook', [
            'events' => [[
                'type' => 'message',
                'replyToken' => 'command-reply-token',
                'source' => ['userId' => 'U654321'],
                'message' => ['type' => 'text', 'text' => '/help'],
            ]],
        ]);

        $response->assertOk();
        Http::assertSent(fn ($request) => $request->data()['replyToken'] === 'command-reply-token'
            && str_contains($request->data()['messages'][0]['text'], '可用指令'));
    }

    public function test_unknown_command_does_not_stop_later_events_in_the_batch(): void
    {
        $this->withoutMiddleware();
        Http::fake();
        config(['line.line_access_token' => 'test-access-token']);

        $response = $this->postJson('/api/line/webhook', [
            'events' => [
                [
                    'type' => 'message',
                    'replyToken' => 'unknown-command-reply-token',
                    'source' => ['userId' => 'U654321'],
                    'message' => ['type' => 'text', 'text' => '/unknown'],
                ],
                [
                    'type' => 'message',
                    'replyToken' => 'message-reply-token',
                    'source' => ['userId' => 'U654321'],
                    'message' => ['type' => 'text', 'text' => 'hello'],
                ],
            ],
        ]);

        $response->assertOk();
        Http::assertSentCount(2);
        Http::assertSent(fn ($request) => $request->data()['replyToken'] === 'unknown-command-reply-token'
            && str_contains($request->data()['messages'][0]['text'], '未知指令'));
        Http::assertSent(fn ($request) => $request->data()['replyToken'] === 'message-reply-token');
    }
}
