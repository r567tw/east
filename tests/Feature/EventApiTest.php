<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    private function authHeader(User $user)
    {
        $token = JWTAuth::fromUser($user);
        return ['Authorization' => "Bearer $token"];
    }

    public function test_index_and_show_are_public()
    {
        $event = Event::factory()->create();
        $response = $this->getJson('/api/events');
        $response->assertStatus(200);
        $show = $this->getJson("/api/events/{$event->id}");
        $show->assertStatus(200);
    }

    public function test_store_requires_auth()
    {
        $response = $this->postJson('/api/events', [
            'name' => 'Test Event',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHour()->toDateTimeString(),
        ]);
        $response->assertStatus(401);
    }

    public function test_store_with_auth()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Test Event',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHour()->toDateTimeString(),
        ];
        $response = $this->postJson('/api/events', $data, $this->authHeader($user));
        $response->assertStatus(201)->assertJsonFragment(['name' => 'Test Event']);
    }

    public function test_update_authorization_and_success()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);
        $data = [
            'name' => 'Updated Event',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHour()->toDateTimeString(),
        ];
        $update = $this->putJson("/api/events/{$event->id}", $data, $this->authHeader($user));
        $update->assertStatus(200)->assertJsonFragment(['name' => 'Updated Event']);
    }

    public function test_update_forbidden()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $other->id]);
        $data = [
            'name' => 'Updated Event',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHour()->toDateTimeString(),
        ];
        $update = $this->putJson("/api/events/{$event->id}", $data, $this->authHeader($user));
        $update->assertStatus(403);
    }

    public function test_destroy_authorization_and_success()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);
        $destroy = $this->deleteJson("/api/events/{$event->id}", [], $this->authHeader($user));
        $destroy->assertStatus(204);
        $this->assertNull(Event::find($event->id));
    }

    public function test_destroy_forbidden()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $other->id]);
        $destroy = $this->deleteJson("/api/events/{$event->id}", [], $this->authHeader($user));
        $destroy->assertStatus(403);
    }
}
