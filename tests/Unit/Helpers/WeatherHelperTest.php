<?php

namespace Tests\Unit\Helpers;

use App\Helpers\WeatherHelper;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherHelperTest extends TestCase
{
    public function test_get_weather_successful_response()
    {
        Http::fake([
            '*' => Http::response([
                'records' => [
                    'location' => [[
                        'weatherElement' => [
                            [
                                'elementName' => 'Wx',
                                'time' => [[
                                    'parameter' => ['parameterName' => '晴'],
                                ]],
                            ],
                            [
                                'elementName' => 'PoP',
                                'time' => [[
                                    'parameter' => ['parameterName' => '10'],
                                ]],
                            ],
                            [
                                'elementName' => 'CI',
                                'time' => [[
                                    'parameter' => ['parameterName' => '舒適'],
                                ]],
                            ],
                        ],
                    ]],
                ],
            ], 200),
        ]);
        $helper = new WeatherHelper;
        $result = $helper->getWeather('高雄市');
        $this->assertStringContainsString('天氣查詢結果', $result);
        $this->assertStringContainsString('晴', $result);
        $this->assertStringContainsString('舒適', $result);
        $this->assertStringContainsString('10', $result);
    }

    public function test_get_weather_failed_response()
    {
        Http::fake([
            '*' => Http::response([], 500),
        ]);
        $helper = new WeatherHelper;
        $result = $helper->getWeather('高雄市');
        $this->assertStringContainsString('天氣查詢失敗', $result);
    }
}
