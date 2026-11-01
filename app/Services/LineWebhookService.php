<?php

namespace App\Services;

use App\Events\Line\CommandEvent;
use App\Events\Line\InValidEvent;
use App\Events\Line\MessageEvent;

class LineWebhookService
{
    /**
     * @param  array<int, array<string, mixed>>  $events
     */
    public function handle(array $events): void
    {
        foreach ($events as $event) {
            $lineEvent = match ($event['type'] ?? null) {
                'message' => $this->processMessage($event),
                default => new InValidEvent($event['replyToken']),
            };

            event($lineEvent);
        }
    }

    /**
     * @param  array<string, mixed>  $event
     */
    private function processMessage(array $event): CommandEvent|MessageEvent|InValidEvent
    {
        $replyToken = $event['replyToken'];
        $message = $event['message'] ?? [];
        if (! is_array($message) || ($message['type'] ?? null) !== 'text' || ! is_string($message['text'] ?? null)) {
            return new InValidEvent($replyToken);
        }

        $replyToken = $event['replyToken'] ?? null;
        if (! is_string($replyToken) || $replyToken === '') {
            return new InValidEvent($replyToken);
        }

        $text = $message['text'];
        $userId = $event['source']['userId'] ?? null;
        $normalizedText = trim(str_replace('／', '/', $text));

        if (! is_string($userId) || $userId === '') {
            return new InValidEvent($replyToken);
        }

        if (mb_substr($normalizedText, 0, 1) === '/') {
            return new CommandEvent($replyToken, $userId, $text);
        }

        return new MessageEvent($replyToken, $userId, $text);
    }
}
