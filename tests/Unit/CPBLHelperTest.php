<?php

namespace Tests\Unit;

use App\Helpers\CPBLHelper;
use Tests\TestCase; // 因為用到 HTTP Facade，所以需要改繼承 TestCase

class CPBLHelperTest extends TestCase
{
    public function test_get_cpbl(): void
    {
        $service = new CPBLHelper();

        $result = $service->get();
        $this->assertIsString($result);
    }
}
