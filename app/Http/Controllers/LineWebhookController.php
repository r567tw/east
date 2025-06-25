<?php

namespace App\Http\Controllers;

use App\Services\LineWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LineWebhookController extends Controller
{
    public function __construct(public LineWebhookService $lineWebhookService) {}

    public function handle(Request $request)
    {
        // 驗證簽名（選擇性，但建議做）
        $channelSecret = config('line.line_channel_secret'); // .env 中設定
        $signature = $request->header('X-Line-Signature');

        $body = $request->getContent();
        $hash = base64_encode(hash_hmac('sha256', $body, $channelSecret, true));
        if ($signature !== $hash) {
            return response('Invalid signature', 400);
        }

        $events = $request->input('events', []);

        foreach ($events as $event) {
            // 簡單處理 text message
            if ($event['type'] === 'message' && $event['message']['type'] === 'text') {
                $replyToken = $event['replyToken'];
                $userMessage = $event['message']['text'];

                $message = $this->lineWebhookService->process($userMessage);

                $this->replyText($replyToken, $message);
            }
        }

        return response('OK', 200);
    }

    private function replyText($replyToken, $text)
    {
        $accessToken = config('line.line_access_token'); // .env 中設定

        Http::withToken($accessToken)
            ->post('https://api.line.me/v2/bot/message/reply', [
                'replyToken' => $replyToken,
                'messages' => [
                    ['type' => 'text', 'text' => $text]
                ],
            ]);
    }
}
