<?php

namespace Tests\Unit;

use App\Helpers\AstroHelper;
use Tests\TestCase;

class AstroHelperTest extends TestCase
{
    public function test_get_astro(): void
    {
        $service = new AstroHelper;

        $result = $service->get();
        $this->assertStringContainsString('今日射手座解析', $result);
    }
}
