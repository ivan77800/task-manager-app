<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks with optional status filtering.
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::filterByStatus($request->get('status'))
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tasks,
            'message' => 'Tasks retrieved successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created task.
     */
    public function store(TaskRequest $request): JsonResponse
    {
        // Check for duplicate task within 10 seconds
        $existingTask = Task::where('title', $request->title)
            ->where('created_at', '>=', now()->subSeconds(10))
            ->first();

        if ($existingTask) {
            return response()->json([
                'success' => false,
                'message' => 'A task with the same title was created less than 10 seconds ago. Please wait before creating another duplicate task.',
                'data' => $existingTask
            ], Response::HTTP_CONFLICT);
        }

        $task = Task::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task created successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified task.
     */
    public function update(TaskRequest $request, string $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $task->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task updated successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified task.
     */
    public function destroy(string $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ], Response::HTTP_OK);
    }
}
