@extends('layouts.guest')

@section('content')
    <h2 class="text-xl font-semibold text-center mb-4">Login</h2>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 border border-red-400 text-red-700 px-4 py-3">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password"
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm px-3 py-2 border focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4 flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded border-gray-300 text-indigo-600 shadow-sm">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Login
        </button>

        <p class="mt-4 text-center text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a>
        </p>
    </form>

    @push('scripts')
    <script>
        $(function () {
            $('#loginForm').validate({
                rules: {
                    email: { required: true, email: true },
                    password: { required: true }
                },
                messages: {
                    email: {
                        required: 'The email field is required.',
                        email: 'Please enter a valid email address.'
                    },
                    password: {
                        required: 'The password field is required.'
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
