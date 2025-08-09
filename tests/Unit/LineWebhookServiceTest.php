<?php

namespace Tests\Unit;

use App\Services\LineWebhookService;
use Tests\TestCase; // 因為 LineWebhookService 有用到 Laravel 的 Facades, 用純 PHPUnit 會有問題

class LineWebhookServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_gold_price(): void
    {
        $service = new LineWebhookService();

        $result = $service->process("/黃金");
        $this->assertStringContainsString("黃金價格查詢結果", $result);
    }

    public function test_get_weather(): void
    {
        $service = new LineWebhookService();

        $result = $service->process("/天氣");
        $this->assertStringContainsString("天氣查詢結果", $result);
    }
}
