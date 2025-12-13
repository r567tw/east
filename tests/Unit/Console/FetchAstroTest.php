<?php

namespace Tests\Unit\Console;

use Tests\TestCase;

class FetchAstroTest extends TestCase
{
    public function test_command_runs()
    {
        $this->artisan('app:fetch-astro')
            ->assertExitCode(0);
    }
}
