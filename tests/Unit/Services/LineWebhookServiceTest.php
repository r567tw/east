<?php

namespace Tests\Unit\Services;

use App\Services\LineWebhookService;
use PHPUnit\Framework\TestCase;

class LineWebhookServiceTest extends TestCase
{
    public function test_process_returns_expected_string()
    {
        $service = new LineWebhookService;
        $result = $service->process('hello');
        $this->assertStringContainsString('你說的是', $result);
    }
}
