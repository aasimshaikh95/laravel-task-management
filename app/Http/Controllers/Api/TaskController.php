<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::forUser($request->user())
            ->filter($request->only(['status', 'due_date']))
            ->latest()
            ->paginate(10);

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $request->user()->tasks()->create($request->validated());

        return response()->json([
            'message' => 'Task created.',
            'task' => $task,
        ], 201);
    }

    public function show(Request $request, Task $task): JsonResponse
    {
        $request->user()->can('view', $task) || abort(403);

        return response()->json(['task' => $task]);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $request->user()->can('update', $task) || abort(403);

        $task->update($request->validated());

        return response()->json([
            'message' => 'Task updated.',
            'task' => $task->fresh(),
        ]);
    }

    public function destroy(Request $request, Task $task): JsonResponse
    {
        $request->user()->can('delete', $task) || abort(403);

        $task->delete();

        return response()->json(['message' => 'Task deleted.']);
    }
}
