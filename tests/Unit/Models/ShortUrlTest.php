<?php

namespace Tests\Unit\Models;

use App\Models\ShortUrl;
use PHPUnit\Framework\TestCase;

class ShortUrlTest extends TestCase
{
    public function test_model_instantiable()
    {
        $model = new ShortUrl;
        $this->assertInstanceOf(ShortUrl::class, $model);
    }

    // 若有自訂方法可於此補充
}
