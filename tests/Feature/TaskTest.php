<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_tasks()
    {
        Task::factory()->count(3)->create();
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
        $response->assertViewHas('tasks');
    }

    public function test_create_displays_form()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
    }

    public function test_store_creates_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Short desc',
            'long_description' => 'Long desc',
        ];
        $response = $this->post(route('tasks.store'), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_show_displays_task()
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', $task));
        $response->assertStatus(200);
        $response->assertViewHas('task', $task);
    }

    public function test_edit_displays_form()
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.edit', $task));
        $response->assertStatus(200);
    }

    public function test_update_modifies_task()
    {
        $task = Task::factory()->create();
        $data = [
            'title' => 'Updated',
            'description' => 'Updated desc',
            'long_description' => 'Updated long desc',
        ];
        $response = $this->put(route('tasks.update', $task), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated']);
    }

    public function test_destroy_deletes_task()
    {
        $task = Task::factory()->create();
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_toggle_switches_completed()
    {
        $task = Task::factory()->create(['completed' => false]);
        $response = $this->patch(route('tasks.toggle', $task));
        $response->assertRedirect();
        $this->assertTrue($task->fresh()->completed);
    }
}
