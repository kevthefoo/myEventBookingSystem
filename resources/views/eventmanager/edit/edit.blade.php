<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    <div class="mx-auto max-w-2xl p-6">
        <div class="rounded-lg bg-white p-6 shadow-md">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit Event</h1>
                <a href="/eventmanager" class="text-sm text-blue-600 hover:text-blue-800">
                    ← Back to Event Manager
                </a>
            </div>

            <!-- Edit Form -->
            <form method="POST" action="/eventmanager/edit/{{ $event->uuid }}" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="mb-1 block text-sm font-medium text-gray-700">
                        Event Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}"
                        maxlength="100" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="mb-1 block text-sm font-medium text-gray-700">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="3" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <div>
                        <label for="date" class="mb-1 block text-sm font-medium text-gray-700">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date" name="date"
                            value="{{ old('date', $event->date->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="time" class="mb-1 block text-sm font-medium text-gray-700">
                            Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="time" name="time"
                            value="{{ old('time', date('H:i', strtotime($event->time))) }}" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('time')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="mb-1 block text-sm font-medium text-gray-700">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="location" name="location"
                        value="{{ old('location', $event->location) }}" maxlength="255" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('location')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacity -->
                <div>
                    <label for="capacity" class="mb-1 block text-sm font-medium text-gray-700">
                        Capacity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="capacity" name="capacity"
                        value="{{ old('capacity', $event->capacity) }}" min="1" max="1000" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex gap-4 pt-4">
                    <button type="submit"
                        class="cursor-pointer rounded-lg bg-green-600 px-6 py-2 text-white transition duration-200 hover:bg-green-700">
                        Update Event
                    </button>
                    <a href="/eventmanager"
                        class="inline-block rounded-lg bg-gray-500 px-6 py-2 text-center text-white transition duration-200 hover:bg-gray-600">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>

</body>

</html>
