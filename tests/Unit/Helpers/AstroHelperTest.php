<?php

namespace Tests\Unit\Helpers;

use App\Helpers\AstroHelper;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AstroHelperTest extends TestCase
{
    public function test_get_astro(): void
    {
        Http::fake([
            'https://astro.click108.com.tw/daily_1.php?iAcDay='.date('Ymd').'&iAstro=9' => Http::response(file_get_contents(__DIR__.'/../../Stubs/astro_response.html'), 200),
        ]);
        $service = new AstroHelper;

        $result = $service->get();
        $this->assertStringContainsString('今日射手座解析', $result);
    }
}
