<?php

namespace Tests\Unit\Helpers;

use App\Helpers\AirQualityHelper;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AirQualityHelperTest extends TestCase
{
    public function test_get_air_quality_success()
    {
        Http::fake([
            '*' => Http::response([
                'air' => '良好',
            ], 200),
        ]);
        $result = AirQualityHelper::getAirQuality(22.6, 120.3);
        $this->assertStringContainsString('空氣品質：良好', $result);
    }

    public function test_get_air_quality_failed()
    {
        Http::fake([
            '*' => Http::response([], 500),
        ]);
        $result = AirQualityHelper::getAirQuality(22.6, 120.3);
        $this->assertStringContainsString('空氣品質Api回傳出現問題', $result);
    }
}
