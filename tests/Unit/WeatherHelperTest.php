<?php

namespace Tests\Unit;

use App\Helpers\WeatherHelper;
use Tests\TestCase; // 因為 WeatherHelp 用到 Config Facade，所以需要改繼承 TestCase

class WeatherHelperTest extends TestCase
{
    public function test_get_weather(): void
    {
        $service = new WeatherHelper();

        $result = $service->getWeather('臺北市');
        $this->assertStringContainsString("天氣查詢結果", $result);
    }
}
