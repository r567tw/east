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

    private function authHeader(User $user)
    {
        $token = JWTAuth::fromUser($user);
        return ['Authorization' => "Bearer $token"];
    }

    public function test_index_show_require_auth()
    {
        $event = Event::factory()->create();
        $response = $this->getJson("/api/events/{$event->id}/attendees");
        $response->assertStatus(401);
    }

    public function test_index_show_reject_by_gate()
    {
        $user_a = User::factory()->create();
        $user_b = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user_a->id]);
        $response = $this->getJson(
            "/api/events/{$event->id}/attendees",
            $this->authHeader($user_b)
        );
        $response->assertStatus(403);
    }

    public function test_index_show_with_auth()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);
        Attendee::factory()->count(2)->create(['event_id' => $event->id]);
        $response = $this->getJson("/api/events/{$event->id}/attendees", $this->authHeader($user));
        $response->assertStatus(200)->assertJsonCount(2, 'data');
    }

    public function test_store_attendee()
    {
        $event = Event::factory()->create();
        $data = ['name' => 'Test User'];
        $response = $this->postJson("/api/events/{$event->id}/attendees", $data);
        $this->assertTrue(in_array($response->status(), [201, 429, 422]));
    }

    public function test_store_repeat_email_attendee()
    {
        $attendee = Attendee::factory()->create();
        $event = $attendee->event;
        $data = ['name' => 'Test User', 'email' => $attendee->email];
        $response = $this->postJson("/api/events/{$event->id}/attendees", $data);
        $response->assertStatus(409);
    }

    public function test_store_success_attendee()
    {
        $event = Event::factory()->create();
        $data = ['name' => 'Test User', 'email' => 'test@example.com'];
        $response = $this->postJson("/api/events/{$event->id}/attendees", $data);
        $response->assertStatus(201);
    }

    public function test_show_attendee_reject_by_gate()
    {
        $user_a = User::factory()->create();
        $user_b = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user_a->id]);
        $attendee = Attendee::factory()->create(['event_id' => $event->id]);
        $response = $this->getJson(
            "/api/events/{$event->id}/attendees/{$attendee->id}",
            $this->authHeader($user_b)
        );
        $response->assertStatus(403);
    }

    public function test_show_attendee_success()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);
        $attendee = Attendee::factory()->create(['event_id' => $event->id]);
        $response = $this->getJson(
            "/api/events/{$event->id}/attendees/{$attendee->id}",
            $this->authHeader($user)
        );
        $response->assertStatus(200);
    }



    public function test_update_destroy_require_auth()
    {
        $attendee = Attendee::factory()->create();
        $event = $attendee->event;
        $attendeeId = $attendee->id;
        $response = $this->putJson("/api/events/{$event->id}/attendees/{$attendeeId}", ['name' => 'Updated']);
        $response->assertStatus(401);
        $response = $this->deleteJson("/api/events/{$event->id}/attendees/{$attendeeId}");
        $response->assertStatus(401);
    }

    public function test_update_attendee_with_auth()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);
        $attendee = Attendee::factory()->create(['event_id' => $event->id]);
        $update = $this->putJson("/api/events/{$event->id}/attendees/{$attendee->id}", [
            'email' => $attendee->email,
            'name' => 'Updated'
        ], $this->authHeader($user));
        $update->assertStatus(200);
    }

    public function test_update_attendee_no_same_email()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);
        $attendee = Attendee::factory()->create(['event_id' => $event->id]);
        $attendee2 = Attendee::factory()->create(['event_id' => $event->id]);

        $update = $this->putJson("/api/events/{$event->id}/attendees/{$attendee->id}", [
            'email' => $attendee2->email,
            'name' => 'Updated'
        ], $this->authHeader($user));

        $update->assertStatus(409);
    }
    public function test_destroy_attendee_with_auth()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);
        $attendee = Attendee::factory()->create(['event_id' => $event->id]);
        $destroy = $this->deleteJson("/api/events/{$event->id}/attendees/{$attendee->id}", [], $this->authHeader($user));
        $destroy->assertStatus(204);
        $this->assertNull(Attendee::find($attendee->id));
    }

    public function test_destroy_attendee_reject_by_gate()
    {
        $user_a = User::factory()->create();
        $user_b = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user_a->id]);
        $attendee = Attendee::factory()->create(['event_id' => $event->id]);
        $destroy = $this->deleteJson(
            "/api/events/{$event->id}/attendees/{$attendee->id}",
            [],
            $this->authHeader($user_b)
        );
        $destroy->assertStatus(403);
    }
}
