<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Manager - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    <!-- Header -->
    <div class="border-b bg-white p-4 shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Event Manager</h1>

            <div class="flex items-center gap-4">
                <span class="text-gray-600">Welcome, {{ auth()->user()->name }}!</span>
                <a href="/" class="text-blue-600 hover:text-blue-800">← Back to Events</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl p-6">

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-6 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6">
            <a href="/eventmanager/create"
                class="rounded-lg bg-blue-600 px-6 py-2 text-white transition duration-200 hover:bg-blue-700">
                + Create New Event
            </a>
        </div>

        <!-- My Events List -->
        <div class="rounded-lg bg-white p-6 shadow-md">
            <h2 class="mb-4 text-xl font-bold">My Events</h2>

            @if ($events->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Title</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Date & Time</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Location</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Capacity</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Bookings</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($events as $event)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900">{{ $event->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($event->description, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $event->date }}<br>
                                        {{ $event->time }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ Str::limit($event->location, 30) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $event->capacity }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        0 {{-- {{ $event->attendees()->count() ?? 0 }} --}}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <!-- Edit Button -->
                                            <a href="/eventmanager/edit/{{ $event->uuid }}"
                                                class="rounded bg-blue-500 px-3 py-1 text-sm text-white transition duration-200 hover:bg-blue-600">
                                                Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <form method="POST" action="/eventmanager/delete/{{ $event->uuid }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this event?')"
                                                    class="cursor-pointer rounded bg-red-500 px-3 py-1 text-sm text-white transition duration-200 hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Hidden Edit Form for each event -->
                                {{-- <tr id="editForm-{{ $event->uuid }}" class="hidden">
                                    <td colspan="6" class="bg-gray-50 px-4 py-6">
                                        <h3 class="mb-4 text-lg font-medium">Edit Event: {{ $event->title }}</h3>

                                        <form method="POST" action="{{ route('events.update', $event->uuid) }}"
                                            class="space-y-4">
                                            @csrf
                                            @method('PUT')

                                            <!-- Title -->
                                            <div>
                                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                                    Event Title <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="title" value="{{ $event->title }}"
                                                    maxlength="100" required
                                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <!-- Description -->
                                            <div>
                                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                                    Description
                                                </label>
                                                <textarea name="description" rows="3"
                                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $event->description }}</textarea>
                                            </div>

                                            <!-- Date and Time -->
                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                <div>
                                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                                        Date <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="date" name="date" value="{{ $event->date }}"
                                                        min="{{ date('Y-m-d') }}" required
                                                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                </div>

                                                <div>
                                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                                        Time <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="time" name="time"
                                                        value="{{ date('H:i', strtotime($event->time)) }}" required
                                                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                </div>
                                            </div>

                                            <!-- Location -->
                                            <div>
                                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                                    Location <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="location" value="{{ $event->location }}"
                                                    maxlength="255" required
                                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <!-- Capacity -->
                                            <div>
                                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                                    Capacity <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" name="capacity" value="{{ $event->capacity }}"
                                                    min="1" max="1000" required
                                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <!-- Form Actions -->
                                            <div class="flex gap-4 pt-4">
                                                <button type="submit"
                                                    class="rounded-lg bg-green-600 px-6 py-2 text-white transition duration-200 hover:bg-green-700">
                                                    Update Event
                                                </button>
                                                <button type="button" onclick="hideEditForm('{{ $event->uuid }}')"
                                                    class="rounded-lg bg-gray-500 px-6 py-2 text-white transition duration-200 hover:bg-gray-600">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($events->hasPages())
                    <div class="mt-6">
                        {{ $events->links() }}
                    </div>
                @endif
            @else
                <div class="py-8 text-center">
                    <p class="text-lg text-gray-500">You haven't created any events yet.</p>
                    <p class="mt-2 text-sm text-gray-400">Click "Create New Event" to get started!</p>
                </div>
            @endif
        </div>

    </div>

    <script>
        function showEditForm(eventId) {
            const form = document.getElementById('editForm-' + eventId);
            form.classList.remove('hidden');
        }

        function hideEditForm(eventId) {
            const form = document.getElementById('editForm-' + eventId);
            form.classList.add('hidden');
        }
    </script>
</body>

</html>
