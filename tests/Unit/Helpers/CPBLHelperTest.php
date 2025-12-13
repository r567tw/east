<?php

namespace Tests\Unit\Helpers;

use App\Helpers\CPBLHelper;
use Illuminate\Support\Facades\Http;
use Tests\TestCase; // 因為用到 HTTP Facade，所以需要改繼承 TestCase

class CPBLHelperTest extends TestCase
{
    public function test_get_cpbl(): void
    {
        Http::fake([
            '*' => Http::response('', 200),
        ]);

        $service = new CPBLHelper;

        $result = $service->get();
        $this->assertIsString($result);
    }
}
