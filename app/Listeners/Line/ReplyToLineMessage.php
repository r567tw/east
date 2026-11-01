<?php

namespace App\Listeners\Line;

use App\Clients\GeminiAiClient;
use App\Clients\LineClient;
use App\Events\Line\MessageEvent;
use App\Models\User;

class ReplyToLineMessage
{
    public function __construct(private readonly LineClient $lineClient) {}

    public function handle(MessageEvent $event): void
    {
        $message = trim(str_replace('／', '/', mb_strtolower($event->message)));
        $user = $event->userId === null
            ? null
            : User::where('line_user_id', $event->userId)->first();

        $reply = $user === null
            ? "你說的是：「{$message}」"
            : GeminiAiClient::prompt($message);

        $this->lineClient->sendMessage($event->replyToken, $reply);
    }
}
