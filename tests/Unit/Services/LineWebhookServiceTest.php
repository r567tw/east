<?php

namespace Tests\Unit\Services;

use App\Events\Line\CommandEvent;
use App\Events\Line\InValidEvent;
use App\Events\Line\MessageEvent;
use App\Listeners\Line\ReplyToLineCommand;
use App\Models\User;
use App\Services\LineWebhookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LineWebhookServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_dispatches_text_messages_and_commands(): void
    {
        Event::fake([
            CommandEvent::class,
            InValidEvent::class,
            MessageEvent::class,
        ]);

        $service = app(LineWebhookService::class);
        $service->handle([
            [
                'type' => 'message',
                'replyToken' => 'message-reply-token',
                'source' => ['userId' => 'U123'],
                'message' => ['type' => 'text', 'text' => 'hello'],
            ],
            [
                'type' => 'message',
                'replyToken' => 'command-reply-token',
                'source' => ['userId' => 'U123'],
                'message' => ['type' => 'text', 'text' => '/help'],
            ],
            [
                'type' => 'message',
                'replyToken' => 'ignored-reply-token',
                'source' => ['userId' => 'U123'],
                'message' => ['type' => 'image'],
            ],
            [
                'type' => 'message',
                'replyToken' => 'missing-text-reply-token',
                'source' => ['userId' => 'U123'],
                'message' => ['type' => 'text'],
            ],
            [
                'type' => 'message',
                'replyToken' => 'missing-user-reply-token',
                'source' => [],
                'message' => ['type' => 'text', 'text' => 'hello'],
            ],
            [
                'type' => 'follow',
                'replyToken' => 'unsupported-event-reply-token',
            ],
        ]);

        Event::assertDispatched(MessageEvent::class, fn (MessageEvent $event) => $event->message === 'hello'
            && $event->replyToken === 'message-reply-token'
            && $event->userId === 'U123');
        Event::assertDispatched(CommandEvent::class, fn (CommandEvent $event) => $event->command === '/help'
            && $event->replyToken === 'command-reply-token');
        Event::assertDispatchedTimes(MessageEvent::class, 1);
        Event::assertDispatchedTimes(CommandEvent::class, 1);
        Event::assertDispatchedTimes(InValidEvent::class, 4);
        Event::assertDispatched(InValidEvent::class, fn (InValidEvent $event) => $event->replyToken === 'ignored-reply-token');
        Event::assertDispatched(InValidEvent::class, fn (InValidEvent $event) => $event->replyToken === 'missing-text-reply-token');
        Event::assertDispatched(InValidEvent::class, fn (InValidEvent $event) => $event->replyToken === 'missing-user-reply-token');
        Event::assertDispatched(InValidEvent::class, fn (InValidEvent $event) => $event->replyToken === 'unsupported-event-reply-token');
    }

    public function test_process_returns_expected_string()
    {
        $this->assertStringContainsString('請先綁定 LINE 帳號', $this->commandReply('天氣'));
    }

    public function test_process_returns_command_string()
    {
        $this->assertStringContainsString('未知指令', $this->commandReply('hello'));
    }

    public function test_process_command_astro()
    {
        Http::fake([
            '*' => Http::response(file_get_contents(__DIR__.'/../../Stubs/astro_response.html'), 200),
        ]);
        $result = $this->commandReply('運勢');
        $this->assertStringContainsString('射手座', $result);
    }

    public function test_process_command_weather_no_user()
    {
        $result = $this->commandReply('天氣');
        $this->assertStringContainsString('請先綁定 LINE 帳號', $result);
    }

    public function test_process_command_weather_no_location()
    {
        $result = $this->commandReply('天氣', ['location' => null]);
        $this->assertStringContainsString('請先設定你的位置', $result);
    }

    public function test_process_command_air_no_user()
    {
        $result = $this->commandReply('空氣');
        $this->assertStringContainsString('請先綁定 LINE 帳號', $result);
    }

    public function test_process_command_air_no_location()
    {
        $result = $this->commandReply('空氣', ['location' => null]);
        $this->assertStringContainsString('請先設定你的位置', $result);
    }

    public function test_process_command_unknown()
    {
        $result = $this->commandReply('not-a-command');
        $this->assertStringContainsString('未知指令', $result);
    }

    public function test_process_command_help()
    {
        $result = $this->commandReply('help');
        $this->assertStringContainsString('可用指令', $result);
    }

    public function test_process_command_version()
    {
        $result = $this->commandReply('version');
        $this->assertStringContainsString('Laravel Version', $result);
    }

    public function test_process_command_location_no_user()
    {
        $result = $this->commandReply('位置');
        $this->assertStringContainsString('請先綁定 LINE 帳號', $result);
    }

    public function test_process_command_location_no_location()
    {
        $result = $this->commandReply('位置', ['location' => null]);
        $this->assertStringContainsString('請先設定你的位置', $result);
    }

    public function test_process_command_location_with_location()
    {
        $result = $this->commandReply('位置', ['lat' => 123, 'lng' => 456, 'location' => '台北市']);
        $this->assertStringContainsString('城市：台北市', $result);
    }

    public function test_process_command_simple()
    {
        $result = $this->commandReply('精簡');
        $this->assertIsString($result);
    }

    public function test_process_command_translate()
    {
        $result = $this->commandReply('翻譯');
        $this->assertIsString($result);
    }

    public function test_process_command_weather_success()
    {
        Http::fake([
            '*' => Http::response([
                'records' => [
                    'location' => [[
                        'weatherElement' => [
                            [
                                'elementName' => 'Wx',
                                'time' => [[
                                    'parameter' => ['parameterName' => '晴'],
                                ]],
                            ],
                            [
                                'elementName' => 'PoP',
                                'time' => [[
                                    'parameter' => ['parameterName' => '10'],
                                ]],
                            ],
                            [
                                'elementName' => 'CI',
                                'time' => [[
                                    'parameter' => ['parameterName' => '舒適'],
                                ]],
                            ],
                        ],
                    ]],
                ],
            ], 200),
        ]);
        $result = $this->commandReply('天氣', ['location' => '高雄市']);
        $this->assertStringContainsString('天氣查詢結果', $result);
    }

    /**
     * @param  array<string, mixed>|null  $userAttributes
     */
    private function commandReply(string $command, ?array $userAttributes = null): string
    {
        Http::fake(function ($request) {
            if ($request->url() === 'https://api.line.me/v2/bot/message/reply') {
                return Http::response([], 200);
            }

            if (str_contains($request->url(), 'astro.click108.com.tw')) {
                return Http::response(file_get_contents(__DIR__.'/../../Stubs/astro_response.html'), 200);
            }

            if (str_contains($request->url(), 'opendata.cwa.gov.tw')) {
                return Http::response([
                    'records' => [
                        'location' => [[
                            'weatherElement' => [
                                ['elementName' => 'Wx', 'time' => [['parameter' => ['parameterName' => '晴']]]],
                                ['elementName' => 'PoP', 'time' => [['parameter' => ['parameterName' => '10']]]],
                                ['elementName' => 'CI', 'time' => [['parameter' => ['parameterName' => '舒適']]]],
                            ],
                        ]],
                    ],
                ], 200);
            }

            return Http::response([
                'candidates' => [['content' => ['parts' => [['text' => 'processed']]]]],
            ], 200);
        });
        config(['line.line_access_token' => 'test-access-token']);

        $userId = null;
        if ($userAttributes !== null) {
            $user = User::factory()->make();
            $user->forceFill($userAttributes + ['line_user_id' => 'U_COMMAND_TEST'])->save();
            $userId = $user->line_user_id;
        }

        app(ReplyToLineCommand::class)->handle(new CommandEvent('test-reply-token', $userId, '/'.$command));

        $request = Http::recorded(
            fn ($request) => $request->url() === 'https://api.line.me/v2/bot/message/reply'
        )->last()[0];

        return $request->data()['messages'][0]['text'];
    }
}
