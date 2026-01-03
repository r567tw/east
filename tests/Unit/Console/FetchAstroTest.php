<?php

namespace Tests\Unit\Console;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FetchAstroTest extends TestCase
{
    public function test_command_runs()
    {
        Http::fake([
            '*' => Http::response(file_get_contents(__DIR__ . '/../../Stubs/astro_response.html'), 200),
        ]);
        $this->artisan('app:fetch-astro')
            ->assertExitCode(0);
    }
}
