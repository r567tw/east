<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_index_and_show_are_public()
    {
        $response = $this->getJson('/api/events');
        $response->assertStatus(200);
    }

    public function test_events_store_requires_auth()
    {
        $response = $this->postJson('/api/events', [
            'name' => 'Test Event',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHour()->toDateTimeString(),
        ]);
        $response->assertStatus(401);
    }

    public function test_events_store_with_auth()
    {
        $user = User::factory()->create();
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $response = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/events', [
            'name' => 'Test Event',
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()->addHour()->toDateTimeString(),
        ]);
        $response->assertStatus(201);
    }
}
