<?php

namespace Tests\Unit\Console;

use Tests\TestCase;

class CreateInviteCodeTest extends TestCase
{
    public function test_command_runs()
    {
        $this->artisan('app:create-invite-code', ['count' => 1])
            ->assertExitCode(0);
    }
}
