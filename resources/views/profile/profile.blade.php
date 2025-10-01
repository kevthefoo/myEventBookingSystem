@extends('layouts.main')

@section('title')
    Profile
@endsection

@section('content')
    <div class="flex h-[calc(100vh-80px)] w-full items-center justify-center px-4 sm:w-2/3 md:w-1/2 lg:w-1/3">
        <div
            class="flex w-full flex-col items-start rounded-lg bg-white p-4 shadow dark:bg-gray-800 dark:text-white dark:shadow-white sm:p-6">
            <h3 class="mb-4 text-base font-semibold text-gray-900 dark:text-white sm:text-lg">My Profile</h3>

            <div class="w-full space-y-3 text-xs text-gray-700 dark:text-gray-300 sm:space-y-4 sm:text-sm">
                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-white">Account Type</label>
                    <div class="mt-1 rounded-md border border-gray-300 cursor-not-allowed bg-gray-100 p-2 text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400">
                        {{ ucfirst(auth()->user()->role) ?? '-' }} Account
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-white">First name</label>
                    <div class="mt-1 rounded-md border border-gray-300 cursor-not-allowed bg-gray-100 p-2 text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400">
                        {{ auth()->user()->first_name ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-white">Last name</label>
                    <div class="mt-1 rounded-md border border-gray-300 cursor-not-allowed bg-gray-100 p-2 text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400">
                        {{ auth()->user()->last_name ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 dark:text-white">Email</label>
                    <div class="mt-1 rounded-md border border-gray-300 cursor-not-allowed bg-gray-100 p-2 text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400">
                        {{ auth()->user()->email ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection