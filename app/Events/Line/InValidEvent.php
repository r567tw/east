<?php

namespace App\Events\Line;

class InValidEvent
{
    public function __construct(
        public readonly string $replyToken
    ) {}
}
