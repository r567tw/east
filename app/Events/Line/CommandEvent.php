<?php

namespace App\Events\Line;

class CommandEvent
{
    public function __construct(
        public readonly string $replyToken,
        public readonly ?string $userId,
        public readonly string $command,
    ) {}
}
