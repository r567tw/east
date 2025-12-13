<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LineWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LineWebhookController extends Controller
{
    public function __construct(public LineWebhookService $lineWebhookService) {}

    public function handle(Request $request)
    {
        $events = $request->input('events', []);

        foreach ($events as $event) {
            // 簡單處理 text message
            if ($event['type'] === 'message' && $event['message']['type'] === 'text') {
                $replyToken = $event['replyToken'];
                $userId = $event['source']['userId'];
                $userMessage = $event['message']['text'];

                if (strpos($userMessage, '/綁定:') !== false) {
                    $inviteCode = trim(str_replace('/綁定:', '', $userMessage));
                    $message = $inviteCode; // 預設訊息為邀請碼
                    if (empty($inviteCode)) {
                        $message = '請提供邀請碼。';

                        return $this->replyText($replyToken, $message);
                    }
                    $message = $this->lineWebhookService->bind($inviteCode, $userId);
                } else {
                    $user = User::where('line_user_id', $userId)->first() ?? null;
                    $message = $this->lineWebhookService->process($userMessage, $user);
                }

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
                    ['type' => 'text', 'text' => $text],
                ],
            ]);
    }
}
