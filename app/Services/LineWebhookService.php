<?php

namespace App\Services;

use App\Events\Line\CommandEvent;
use App\Events\Line\MessageEvent;
use InvalidArgumentException;

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
                default => null,
            };

            if ($lineEvent !== null) {
                event($lineEvent);
            }
        }
    }

    /**
     * @param  array<string, mixed>  $event
     */
    private function processMessage(array $event): CommandEvent|MessageEvent|null
    {
        $message = $event['message'] ?? [];
        if (! is_array($message) || ($message['type'] ?? null) !== 'text' || ! is_string($message['text'] ?? null)) {
            return null;
        }

        $replyToken = $event['replyToken'] ?? null;
        if (! is_string($replyToken) || $replyToken === '') {
            throw new InvalidArgumentException('A reply token is required for LINE text messages.');
        }

        $text = $message['text'];
        $userId = $event['source']['userId'] ?? null;
        $normalizedText = trim(str_replace('／', '/', $text));

        if (! is_string($userId) || $userId === '') {
            throw new InvalidArgumentException('A user ID is required for LINE text messages.');
        }

        if (mb_substr($normalizedText, 0, 1) === '/') {
            return new CommandEvent($replyToken, $userId, $text);
        }

        return new MessageEvent($replyToken, $userId, $text);
    }
}
