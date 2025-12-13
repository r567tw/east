<?php

namespace Tests\Unit\Policies;

use App\Models\Event;
use App\Models\User;
use App\Policies\EventPolicy;
use PHPUnit\Framework\TestCase;

class EventPolicyTest extends TestCase
{
    public function test_view_any_returns_true()
    {
        $policy = new EventPolicy;
        $user = $this->createMock(User::class);
        $this->assertTrue($policy->viewAny($user));
    }

    public function test_view_returns_true()
    {
        $policy = new EventPolicy;
        $user = $this->createMock(User::class);
        $event = $this->createMock(Event::class);
        $this->assertTrue($policy->view($user, $event));
    }

    public function test_create_returns_true()
    {
        $policy = new EventPolicy;
        $user = $this->createMock(User::class);
        $this->assertTrue($policy->create($user));
    }
}
