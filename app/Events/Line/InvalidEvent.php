<?php

namespace App\Events\Line;

class InvalidEvent
{
    public function __construct(
        public readonly string $replyToken,
    ) {}
}
