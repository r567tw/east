<?php

namespace Tests\Unit\Console;

use Tests\TestCase;

class CleanInviteCodeTest extends TestCase
{
    public function test_command_runs()
    {
        $this->artisan('app:clean-invite-code')
            ->assertExitCode(0);
    }
}
