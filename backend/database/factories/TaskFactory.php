<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(Task::getStatuses()),
            'priority' => $this->faker->randomElement(Task::getPriorities()),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now()
        ];
    }
}