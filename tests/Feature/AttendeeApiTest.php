<?php

namespace Tests\Feature;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AttendeeApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_attendees_index_show_require_auth()
    {
        $event = Event::factory()->create();
        $response = $this->getJson("/api/events/{$event->id}/attendees");
        $response->assertStatus(401);
    }

    public function test_attendees_index_show_with_auth()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(
            ['user_id' => $user->id]
        );
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', "Bearer $token")->getJson("/api/events/{$event->id}/attendees");
        $response->assertStatus(200);
    }

    public function test_attendees_store_requires_throttle_only()
    {
        $event = Event::factory()->create();
        $response = $this->postJson("/api/events/{$event->id}/attendees", [
            'name' => 'Test User',
        ]);
        // 429 or 201 depends on throttle,這裡只驗證未授權不會401
        $this->assertTrue(in_array($response->status(), [201, 429, 422]));
    }

    public function test_attendees_update_destroy_require_auth()
    {
        $attendee = Attendee::factory()->create();
        $event = $attendee->event;
        $attendeeId = $attendee->id;
        $response = $this->putJson("/api/events/{$event->id}/attendees/{$attendeeId}", ['name' => 'Updated']);
        $response->assertStatus(401);
        $response = $this->deleteJson("/api/events/{$event->id}/attendees/{$attendeeId}");
        $response->assertStatus(401);
    }
}
