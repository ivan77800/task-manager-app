<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::create([
            'title' => 'Sample Task 1',
            'description' => 'This is a sample task to demonstrate the application',
            'status' => 'pending',
            'priority' => 'high'
        ]);

        Task::create([
            'title' => 'Sample Task 2',
            'description' => 'Another example task with medium priority',
            'status' => 'completed',
            'priority' => 'medium'
        ]);

        // Create additional sample tasks using factory
        Task::factory()->count(10)->create();
    }
}