<?php

namespace Tests\Unit\Services;

use App\Services\ShortUrlService;
use PHPUnit\Framework\TestCase;

class ShortUrlServiceTest extends TestCase
{
    public function test_generate_code_returns_string_of_length_6()
    {
        $service = new ShortUrlService;
        $code = $service->generateCode();
        $this->assertIsString($code);
        $this->assertEquals(6, strlen($code));
    }
}
