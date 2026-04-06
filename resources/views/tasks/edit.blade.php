@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Task</h1>

        <form method="POST" action="{{ route('tasks.update', $task) }}" id="editTaskForm" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title', $task->title) }}" maxlength="255"
                       class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach (['pending', 'in-progress', 'completed'] as $status)
                        <option value="{{ $status }}" {{ old('status', $task->status) === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date <span class="text-red-500">*</span></label>
                <input id="due_date" type="date" name="due_date" value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
                       class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
                @error('due_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('tasks.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update Task</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(function () {
            $('#editTaskForm').validate({
                rules: {
                    title: { required: true, maxlength: 255 },
                    status: { required: true },
                    due_date: { required: true, date: true }
                },
                messages: {
                    title: {
                        required: 'The title field is required.',
                        maxlength: 'The title must not exceed 255 characters.'
                    },
                    status: {
                        required: 'Please select a status.'
                    },
                    due_date: {
                        required: 'The due date field is required.',
                        date: 'Please enter a valid date.'
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
    @endpush
@endsection
