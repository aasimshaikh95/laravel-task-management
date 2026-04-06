@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Tasks</h1>
        <a href="{{ route('tasks.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + New Task
        </a>
    </div>

    <form method="GET" action="{{ route('tasks.index') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status"
                    class="mt-1 rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in-progress" {{ request('status') === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div>
            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
            <input id="due_date" type="date" name="due_date" value="{{ request('due_date') }}"
                   class="mt-1 rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Filter</button>
            <a href="{{ route('tasks.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Clear</a>
        </div>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                    @if(auth()->user()->isAdmin())
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                    @endif
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($tasks as $task)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                            @if($task->description)
                                <p class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($task->description, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $colors = match($task->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'in-progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                };
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $colors }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $task->due_date->format('d M Y') }}
                            @if($task->due_date->isPast() && $task->status !== 'completed')
                                <span class="text-red-600 text-xs font-medium ml-1">(Overdue)</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $task->user->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-right text-sm space-x-3">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline"
                                  onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 5 : 4 }}" class="px-6 py-8 text-center text-gray-500">
                            No tasks yet. <a href="{{ route('tasks.create') }}" class="text-indigo-600 hover:underline">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
@endsection
