<?php

namespace Tests\Unit\Services;

use App\Services\LineWebhookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LineWebhookServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_returns_expected_string()
    {
        $service = new LineWebhookService;
        $result = $service->process('hello');
        $this->assertStringContainsString('你說的是', $result);
    }

    public function test_process_returns_command_string()
    {
        $service = new LineWebhookService;
        $result = $service->process('/hello');
        $this->assertStringNotContainsString('你說的是', $result);
    }

    public function test_process_command_astro()
    {
        Http::fake([
            '*' => Http::response(file_get_contents(__DIR__.'/../../Stubs/astro_response.html'), 200),
        ]);
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('運勢');
        $this->assertStringContainsString('射手座', $result);
    }

    public function test_process_command_weather_no_user()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('天氣');
        $this->assertStringContainsString('請先綁定 LINE 帳號', $result);
    }

    public function test_process_command_weather_no_location()
    {
        $user = (object) ['location' => null];
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('天氣', $user);
        $this->assertStringContainsString('請先設定你的位置', $result);
    }

    public function test_process_command_air_no_user()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('空氣');
        $this->assertStringContainsString('請先綁定 LINE 帳號', $result);
    }

    public function test_process_command_air_no_location()
    {
        $user = (object) ['location' => null];
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('空氣', $user);
        $this->assertStringContainsString('請先設定你的位置', $result);
    }

    public function test_process_command_unknown()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('not-a-command');
        $this->assertStringContainsString('未知指令', $result);
    }

    public function test_process_command_help()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('help');
        $this->assertStringContainsString('可用指令', $result);
    }

    public function test_process_command_version()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('version');
        $this->assertStringContainsString('Laravel Version', $result);
    }

    public function test_process_command_location_no_user()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('位置');
        $this->assertStringContainsString('請先綁定 LINE 帳號', $result);
    }

    public function test_process_command_location_no_location()
    {
        $user = (object) ['location' => null];
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('位置', $user);
        $this->assertStringContainsString('請先設定你的位置', $result);
    }

    public function test_process_command_location_with_location()
    {
        $user = (object) ['lat' => 123, 'lng' => 456, 'location' => '台北市'];
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('位置', $user);
        $this->assertStringContainsString('城市：台北市', $result);
    }

    public function test_process_command_cpbl()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('cpbl');
        $this->assertIsString($result);
    }

    public function test_process_command_simple()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('精簡');
        $this->assertIsString($result);
    }

    public function test_process_command_translate()
    {
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('翻譯');
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
        $user = (object) ['location' => '高雄市'];

        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('天氣', $user);
        $this->assertStringContainsString('天氣查詢結果', $result);
    }
}
