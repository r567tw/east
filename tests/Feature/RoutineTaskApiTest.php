<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoutineTaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_routine_tasks_index_unauthorized()
    {
        $response = $this->getJson('/api/routine-tasks');
        $response->assertStatus(401);
    }

    public function test_routine_tasks_index_authorized()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', "Bearer $token");
        $response = $this->getJson('/api/routine-tasks');
        $response->assertStatus(200);
    }
}
