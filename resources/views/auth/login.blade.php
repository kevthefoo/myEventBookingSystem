@extends('layouts.main')

@section('title')
    Login
@endsection

@section('scripts')
    <script>
        const header = document.querySelector('header');
        if (header) {
            header.remove();
        }
    </script>
@endsection

@section('content')
    <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-md dark:bg-gray-800 dark:shadow-sm dark:shadow-white max-md:max-w-sm max-md:p-6 max-sm:max-w-xs max-sm:p-4">
        <div class="mb-8 text-center max-md:mb-6 max-sm:mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white max-md:text-xl max-sm:text-lg">Sign In</h1>
            <p class="mt-2 text-gray-600 dark:text-white max-md:text-sm max-sm:text-xs max-sm:mt-1">Welcome back to GUEBS</p>
        </div>

        {{-- Login In Form --}}
        <form method="POST" action="/login" class="space-y-6 max-md:space-y-4 max-sm:space-y-3">
            @csrf
            {{-- Email Field --}}
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-white max-md:mb-1.5 max-md:text-xs max-sm:mb-1">
                    Email Address
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-md border border-gray-300 py-1 pl-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white max-md:py-1.5 max-md:pl-3 max-md:text-sm max-sm:py-1 max-sm:pl-2 max-sm:text-xs"
                    placeholder="Enter your email">
                @error('email')
                    <p class="mt-1 text-sm text-red-500 max-md:text-xs max-sm:mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Field --}}
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-gray-700 dark:text-white max-md:mb-1.5 max-md:text-xs max-sm:mb-1">
                    Password
                </label>
                <input type="password" id="password" name="password" required
                    class="w-full rounded-md border border-gray-300 py-1 pl-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white max-md:py-1.5 max-md:pl-3 max-md:text-sm max-sm:py-1 max-sm:pl-2 max-sm:text-xs"
                    placeholder="Enter your password">
                @error('password')
                    <p class="mt-1 text-sm text-red-500 max-md:text-xs max-sm:mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                class="w-full cursor-pointer rounded-md bg-blue-600 px-4 py-2 text-white transition duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 max-md:px-3 max-md:py-1.5 max-md:text-sm max-sm:py-1 max-sm:text-xs">
                Sign In
            </button>
        </form>

        {{-- Register Link --}}
        <div class="mt-6 text-center max-md:mt-4 max-sm:mt-3">
            <p class="text-sm text-gray-600 dark:text-white max-md:text-xs max-sm:text-[10px]">
                Don't have an account?
                <a href="/register" class="font-medium text-blue-600 hover:text-blue-500 dark:text-white">
                    Sign up here
                </a>
            </p>
        </div>

        {{-- Back to Home Page Link --}}
        <div class="mt-4 text-center max-md:mt-3 max-sm:mt-2">
            <a href="/" class="text-sm text-gray-500 hover:text-gray-700 dark:text-white max-md:text-xs max-sm:text-[10px]">
                ← Back to Home
            </a>
        </div>
    </div>
@endsection