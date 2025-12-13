<?php

namespace Tests\Unit\Events;

use App\Events\EventRegistered;
use App\Models\Attendee;
use Illuminate\Broadcasting\PrivateChannel;
use PHPUnit\Framework\TestCase;

class EventRegisteredTest extends TestCase
{
    public function test_event_can_be_instantiated_with_attendee()
    {
        $attendee = $this->createMock(Attendee::class);
        $event = new EventRegistered($attendee);
        $this->assertSame($attendee, $event->attendee);
    }

    public function test_broadcast_on_returns_private_channel()
    {
        $attendee = $this->createMock(Attendee::class);
        $event = new EventRegistered($attendee);
        $channels = $event->broadcastOn();
        $this->assertIsArray($channels);
        $this->assertInstanceOf(PrivateChannel::class, $channels[0]);
        // $this->assertEquals('channel-name', $channels[0]->getName());
    }
}
