<?php

namespace Tests\Unit\Console;

use Tests\TestCase;

class GetGoldPriceTest extends TestCase
{
    public function test_command_runs()
    {
        $this->artisan('app:get-gold-price')
            ->assertExitCode(0);
    }
}
