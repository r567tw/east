<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

class LineWebhookMiddlewareTest extends TestCase
{
    /**
     * 測試 LineWebhookMiddleware 驗證簽名
     */
    public function test_line_webhook_middleware_valid_signature()
    {
        $body = '{"events":[]}';
        $channelSecret = config('line.line_channel_secret', 'test_secret');
        $signature = base64_encode(hash_hmac('sha256', $body, $channelSecret, true));

        $response = $this->withHeaders([
            'X-Line-Signature' => $signature,
        ])->postJson('/line/webhook', json_decode($body, true));

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_line_webhook_middleware_invalid_signature()
    {
        $fake_body = '{"events":[]}';

        $actual_body = '{"events":[{"type":"message","replyToken":"nHuyWiB7yP5Zw52FIkcQobQuGDXCTA","source":{"userId":"U4af4980629...","type":"user"},"timestamp":1462629479859,"message":{"id":"325708","type":"text","text":"Hello, world"}}]}';
        $channelSecret = config('line.line_channel_secret', 'test_secret');
        $signature = base64_encode(hash_hmac('sha256', $fake_body, $channelSecret, true));

        $response = $this->withHeaders([
            'X-Line-Signature' => $signature,
        ])->postJson('/line/webhook', json_decode($actual_body, true));

        $this->assertEquals(400, $response->getStatusCode());
    }
}
