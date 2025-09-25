<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen items-center justify-center bg-gray-50">

    <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-md">

        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900">Create Account</h1>
            <p class="mt-2 text-gray-600">Join our Event Booking System</p>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="/register" class="space-y-6">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                    Full Name
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your full name">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                    Email Address
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your email">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input type="password" id="password" name="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your password (min 6 characters)">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700">
                    Confirm Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Confirm your password">
            </div>

            <!-- Privacy Policy Checkbox -->
            <div class="flex items-start">
                <input type="checkbox" id="privacy_policy_accepted" name="privacy_policy_accepted" value="1"
                    required class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="privacy_policy_accepted" class="ml-2 block text-sm text-gray-700">
                    I agree to the
                    <a href="#" class="text-blue-600 hover:text-blue-500">Terms of Service</a>
                    and
                    <a href="#" class="text-blue-600 hover:text-blue-500">Privacy Policy</a>
                </label>
            </div>
            @error('privacy_policy_accepted')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror

            <!-- Submit Button -->
            <button type="submit"
                class="w-full rounded-md bg-blue-600 px-4 py-2 text-white transition duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Create Account
            </button>

        </form>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">
                    Sign in here
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="mt-4 text-center">
            <a href="/" class="text-sm text-gray-500 hover:text-gray-700">
                ← Back to Events
            </a>
        </div>

    </div>

</body>

</html>
