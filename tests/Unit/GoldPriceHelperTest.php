<?php

namespace Tests\Unit;

use Tests\TestCase;

class GoldPriceHelperTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $goldPriceHelper = new \App\Helpers\GoldPriceHelper;
        $result = $goldPriceHelper->getGoldPrice();
        $this->assertIsInt($result[0]);
        $this->assertIsInt($result[1]);
        $this->assertGreaterThanOrEqual(0, $result[0]);
        $this->assertGreaterThanOrEqual(0, $result[1]);
    }
}
