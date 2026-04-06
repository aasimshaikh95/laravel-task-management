@extends('layouts.guest')

@section('content')
    <h2 class="text-xl font-semibold text-center mb-4">Register</h2>

    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 border border-red-400 text-red-700 px-4 py-3">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" autofocus
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password"
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Register
        </button>

        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
        </p>
    </form>

    @push('scripts')
    <script>
        $(function () {
            $('#registerForm').validate({
                rules: {
                    name: { required: true, maxlength: 255 },
                    email: { required: true, email: true, maxlength: 255 },
                    password: { required: true, minlength: 8 },
                    password_confirmation: { required: true, equalTo: '#password' }
                },
                messages: {
                    name: {
                        required: 'The name field is required.',
                        maxlength: 'The name must not exceed 255 characters.'
                    },
                    email: {
                        required: 'The email field is required.',
                        email: 'Please enter a valid email address.',
                        maxlength: 'The email must not exceed 255 characters.'
                    },
                    password: {
                        required: 'The password field is required.',
                        minlength: 'The password must be at least 8 characters.'
                    },
                    password_confirmation: {
                        required: 'Please confirm your password.',
                        equalTo: 'The password confirmation does not match.'
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
