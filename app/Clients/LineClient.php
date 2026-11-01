<?php

namespace App\Clients;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class LineClient
{
    public function sendMessage(string $replyToken, string $message): Response
    {
        $lineAccessToken = config('line.line_access_token');
        if (! is_string($lineAccessToken) || $lineAccessToken === '') {
            throw new RuntimeException('LINE channel access token is not configured.');
        }

        return Http::withToken($lineAccessToken)
            ->post('https://api.line.me/v2/bot/message/reply', [
                'replyToken' => $replyToken,
                'messages' => [
                    ['type' => 'text', 'text' => $message],
                ],
            ])
            ->throw();
    }
}
