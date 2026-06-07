<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'title', 'description', 'status', 'priority', 'created_at', 'updated_at']
                ],
                'message'
            ]);
    }

    public function test_can_filter_tasks_by_status(): void
    {
        Task::factory()->create(['status' => 'pending']);
        Task::factory()->create(['status' => 'completed']);

        $response = $this->getJson('/api/tasks?status=pending');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('pending', $response->json('data.0.status'));
    }

    public function test_can_create_task(): void
    {
        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'status' => 'pending',
            'priority' => 'high'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Task created successfully'
            ]);
        
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_cannot_create_duplicate_task_within_10_seconds(): void
    {
        $taskData = [
            'title' => 'Duplicate Task',
            'description' => 'Test description',
            'status' => 'pending',
            'priority' => 'medium'
        ];

        // Create first task
        $this->postJson('/api/tasks', $taskData);
        
        // Try to create duplicate immediately
        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(409)
            ->assertJson([
                'success' => false,
                'message' => 'A task with the same title was created less than 10 seconds ago. Please wait before creating another duplicate task.'
            ]);
    }

    public function test_can_update_task(): void
    {
        $task = Task::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'status' => 'completed',
            'priority' => 'low'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_validation_fails_for_invalid_data(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title' => '',
            'status' => 'invalid_status',
            'priority' => 'invalid_priority'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'status', 'priority']);
    }
}