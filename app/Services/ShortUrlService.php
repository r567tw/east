<?php

namespace App\Services;

use Illuminate\Support\Str;

class ShortUrlService
{
    // 這裡可以放置與短網址相關的商業邏輯
    public function generateCode(): string
    {
        return Str::random(6);
    }
}
