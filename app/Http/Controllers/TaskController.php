<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = Task::forUser($request->user())
            ->filter($request->only(['status', 'due_date']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $request->user()->tasks()->create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    public function edit(Request $request, Task $task): View
    {
        $request->user()->can('update', $task) || abort(403);

        return view('tasks.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $request->user()->can('update', $task) || abort(403);

        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $request->user()->can('delete', $task) || abort(403);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
