<?php

namespace Tests\Unit\Console;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetGoldPriceTest extends TestCase
{
    public function test_command_runs()
    {
        Http::fake([
            'https://www.gold.org.tw/*' => Http::response(file_get_contents(__DIR__ . '/../../Stubs/gold_price_response.html'), 200),
        ]);
        $this->artisan('app:get-gold-price')
            ->assertExitCode(0);
    }
}
