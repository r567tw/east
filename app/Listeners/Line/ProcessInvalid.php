<?php

namespace App\Listeners\Line;

use App\Clients\LineClient;
use App\Events\Line\InvalidEvent;

class ProcessInvalid
{
    public function __construct(private readonly LineClient $lineClient) {}

    /**
     * Handle the event.
     */
    public function handle(InvalidEvent $event): void
    {
        //
        $this->lineClient->sendMessage($event->replyToken, '目前尚未支援的訊息類型，請使用文字訊息');

    }
}
