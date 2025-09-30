@extends('layouts.main')

@section('title')
    Profile
@endsection

@section('content')
    <div class="flex h-[calc(100vh-80px)] w-1/3 items-center justify-center">
        <div
            class="flex w-full flex-col items-start rounded-lg bg-white p-6 shadow dark:bg-gray-800 dark:text-white dark:shadow-white">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">My Profile</h3>

            <div class="w-full space-y-4 text-sm text-gray-700 dark:text-gray-300">
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-white">Account Type</label>
                    <div class="mt-1 rounded-md border border-gray-200 bg-gray-50 p-2 dark:text-black">
                        {{ ucfirst(auth()->user()->role) ?? '-' }} Account
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-white">First name</label>
                    <div class="mt-1 rounded-md border border-gray-200 bg-gray-50 p-2 dark:text-black">
                        {{ auth()->user()->first_name ?? '-' }}</div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-white">Last name</label>
                    <div class="mt-1 rounded-md border border-gray-200 bg-gray-50 p-2 dark:text-black">
                        {{ auth()->user()->last_name ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-white">Email</label>
                    <div class="mt-1 rounded-md border border-gray-200 bg-gray-50 p-2 dark:text-black">
                        {{ auth()->user()->email ?? '-' }}
                    </div>
                </div>

                <!-- add other read-only fields here if needed -->
            </div>

            @if (session('success'))
                <div class="mt-4 rounded border border-green-200 bg-green-50 p-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 space-y-2 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
