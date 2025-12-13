<?php

namespace Tests\Unit\Console;

use Tests\TestCase;

class CleanShortUrlsTest extends TestCase
{
    public function test_command_runs()
    {
        $this->artisan('app:clean-short-url')
            ->assertExitCode(0);
    }
}
