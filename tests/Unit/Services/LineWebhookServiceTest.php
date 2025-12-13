<?php

namespace Tests\Unit\Services;

use App\Services\LineWebhookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('運勢');
        $this->assertStringContainsString('射手座', $result);
    }

    public function test_process_command_gold()
    {
        \Illuminate\Support\Facades\Cache::shouldReceive('get')->with('gold_buy_price', 0)->andReturn(123);
        \Illuminate\Support\Facades\Cache::shouldReceive('get')->with('gold_sell_price', 0)->andReturn(456);
        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('黃金');
        $this->assertStringContainsString('黃金價格查詢結果', $result);
        $this->assertStringContainsString('123', $result);
        $this->assertStringContainsString('456', $result);
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

    public function test_bind_with_invalid_invite_code_returns_error()
    {
        \Illuminate\Support\Facades\DB::shouldReceive('table')->with('invite_codes')->andReturnSelf();
        \Illuminate\Support\Facades\DB::shouldReceive('where')->with('code', 'badcode')->andReturnSelf();
        \Illuminate\Support\Facades\DB::shouldReceive('where')->with('expires_at', '>', \Mockery::any())->andReturnSelf();
        \Illuminate\Support\Facades\DB::shouldReceive('first')->andReturn(null);
        $service = new \App\Services\LineWebhookService;
        $result = $service->bind('badcode', 'U123');
        $this->assertStringContainsString('無效的邀請碼', $result);
    }

    public function test_bind_with_valid_invite_code_updates_user_and_returns_success()
    {
        // 建立測試用 invite_codes 與 user
        $user = \App\Models\User::factory()->create(['line_user_id' => null]);
        DB::table('invite_codes')->insert([
            'code' => 'goodcode',
            'user_id' => $user->id,
            'expires_at' => now()->addDay(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $service = new \App\Services\LineWebhookService;
        $result = $service->bind('goodcode', 'U123');
        $this->assertStringContainsString('成功綁定', $result);
        $user->refresh();
        $this->assertEquals('U123', $user->line_user_id);
    }

    public function test_process_command_weather_success()
    {
        $user = (object) ['location' => '高雄市'];

        $service = new \App\Services\LineWebhookService;
        $result = $service->processCommand('天氣', $user);
        $this->assertStringContainsString('天氣查詢結果', $result);
    }
}
