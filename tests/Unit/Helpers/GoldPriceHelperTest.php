<?php

namespace Tests\Unit\Helpers;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoldPriceHelperTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        Http::fake([
            'https://www.gold.org.tw/*' => Http::response(file_get_contents(__DIR__.'/../../Stubs/gold_price_response.html'), 200),
        ]);

        $goldPriceHelper = new \App\Helpers\GoldPriceHelper;
        $result = $goldPriceHelper->getGoldPrice();
        $this->assertIsInt($result[0]);
        $this->assertIsInt($result[1]);
        $this->assertGreaterThanOrEqual(0, $result[0]);
        $this->assertGreaterThanOrEqual(0, $result[1]);
    }
}
