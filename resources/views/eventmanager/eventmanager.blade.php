@extends('layouts.main')

@section('title')
    Event Manager
@endsection

@section('content')

    <div class="mx-auto max-w-7xl p-6">

        <!-- Success/Error Messages with Auto-hide -->
        @if (session('success'))
            <div id="success-message"
                class="relative mb-6 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700">
                <span>{{ session('success') }}</span>
                <button onclick="dismissMessage('success-message')"
                    class="absolute right-0 top-0 mr-2 mt-2 text-green-500 hover:text-green-700">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="error-message" class="relative mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                <span>{{ session('error') }}</span>
                <button onclick="dismissMessage('error-message')"
                    class="absolute right-0 top-0 mr-2 mt-2 text-red-500 hover:text-red-700">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
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
                                        {{ $event->date->format('Y-m-d') }}<br>
                                        {{ date('H:i', strtotime($event->time)) }}
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination bar --}}
                @if ($events->hasPages())
                    <div class="pagination my-4 flex justify-center bg-white text-red-400">
                        {{ $events->links() }}
                    </div>
                @endif
            @else
                <div class="py-8 text-center">
                    <p class="text-lg text-gray-500">You haven't created any events yet.</p>
                </div>
            @endif
        </div>

    </div>
@endsection

@section('styles')
    <style>
        .pagination a,
        .pagination span {
            background-color: #f8f9fa;
            color: black;
        }

        span[aria-current="page"] span {
            background-color: #374151;
            color: white;
        }

        .pagination p {
            display: none;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Auto-hide messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            if (successMessage) {
                setTimeout(() => {
                    fadeOut(successMessage);
                }, 5000); // 5 seconds
            }

            if (errorMessage) {
                setTimeout(() => {
                    fadeOut(errorMessage);
                }, 5000); // 5 seconds
            }
        });

        // Function to dismiss message manually
        function dismissMessage(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                fadeOut(element);
            }
        }

        // Fade out animation
        function fadeOut(element) {
            element.style.transition = 'opacity 0.5s ease-out';
            element.style.opacity = '0';
            setTimeout(() => {
                element.remove();
            }, 500);
        }
    </script>
@endsection
