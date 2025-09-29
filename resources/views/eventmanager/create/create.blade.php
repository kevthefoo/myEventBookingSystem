@extends('layouts.main')

@section('title')
    Create New Events
@endsection

@section('content')
    <div id="createEventForm" class="mx-auto mb-8 max-w-2xl rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
        <h2 class="mb-4 text-xl font-bold dark:text-white">Create New Event</h2>

        <form method="POST" action="/eventmanager/create" class="space-y-4">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                    Event Title <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="100" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter event title (max 100 characters)">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="3" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Event description (optional)">{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date and Time -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="date" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date" name="date" value="{{ old('date') }}"
                        min="{{ date('Y-m-d') }}" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:[color-scheme:dark]">
                    @error('date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="time" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Time <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="time" name="time" value="{{ old('time') }}" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:[color-scheme:dark]">
                    @error('time')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                    Location <span class="text-red-500">*</span>
                </label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" maxlength="255" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Event location (max 255 characters)">
                @error('location')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity -->
            <div>
                <label for="capacity" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                    Capacity <span class="text-red-500">*</span>
                </label>
                <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1"
                    max="1000" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Maximum attendees (1-1000)">
                @error('capacity')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-4">
                <button type="submit"
                    class="cursor-pointer rounded-lg bg-green-600 px-6 py-2 text-white transition duration-200 hover:bg-green-700">
                    Create Event
                </button>
                <a href="/eventmanager"
                    class="rounded-lg bg-gray-500 px-6 py-2 text-white transition duration-200 hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
