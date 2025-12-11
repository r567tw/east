<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\RoutineTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoutineTaskApiTest extends TestCase
{
    use RefreshDatabase;

    private function authHeader(User $user)
    {
        $token = JWTAuth::fromUser($user);
        return ['Authorization' => "Bearer $token"];
    }

    public function test_index_unauthorized()
    {
        $response = $this->getJson('/api/routine-tasks');
        $response->assertStatus(401);
    }

    public function test_index_authorized()
    {
        $user = User::factory()->create();
        RoutineTask::factory()->count(2)->create();
        $response = $this->getJson('/api/routine-tasks', $this->authHeader($user));
        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_store_and_show()
    {
        $user = User::factory()->create();
        $data = [
            'title' => 'Test Task',
            'description' => 'desc',
            'weeks_of_month' => 2,
            'day_of_week' => 3,
            'active' => true,
        ];
        $store = $this->postJson('/api/routine-tasks', $data, $this->authHeader($user));
        $store->assertStatus(201)->assertJsonFragment(['title' => 'Test Task']);
        $id = $store->json('id');
        $show = $this->getJson("/api/routine-tasks/$id", $this->authHeader($user));
        $show->assertStatus(200)->assertJsonFragment(['title' => 'Test Task']);
    }

    public function test_show_not_found()
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/routine-tasks/999', $this->authHeader($user));
        $response->assertStatus(404);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $task = RoutineTask::factory()->create(['title' => 'Old']);
        $update = $this->putJson("/api/routine-tasks/{$task->id}", ['title' => 'New'], $this->authHeader($user));
        $update->assertStatus(200)->assertJsonFragment(['title' => 'New']);
    }

    public function test_update_not_found()
    {
        $user = User::factory()->create();
        $update = $this->putJson('/api/routine-tasks/999', ['title' => 'New'], $this->authHeader($user));
        $update->assertStatus(404);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        $task = RoutineTask::factory()->create();
        $destroy = $this->deleteJson("/api/routine-tasks/{$task->id}", [], $this->authHeader($user));
        $destroy->assertStatus(200)->assertJson(['success' => true]);
        $this->assertNull(RoutineTask::find($task->id));
    }

    public function test_destroy_not_found()
    {
        $user = User::factory()->create();
        $destroy = $this->deleteJson('/api/routine-tasks/999', [], $this->authHeader($user));
        $destroy->assertStatus(404);
    }
}
