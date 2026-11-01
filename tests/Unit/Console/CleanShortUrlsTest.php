<?php

namespace Tests\Unit\Console;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CleanShortUrlsTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_runs()
    {
        $this->artisan('app:clean-short-url')
            ->assertExitCode(0);
    }
}
