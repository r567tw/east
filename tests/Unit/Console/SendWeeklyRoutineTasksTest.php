<?php

namespace Tests\Unit\Console;

use Tests\TestCase;

class SendWeeklyRoutineTasksTest extends TestCase
{
    public function test_command_runs()
    {
        $this->artisan('app:routine-reminder')
            ->assertExitCode(0);
    }
}
