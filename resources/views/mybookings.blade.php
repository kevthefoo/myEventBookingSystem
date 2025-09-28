<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    <!-- Header -->
    <div class="border-b bg-white p-4 shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">My Bookings</h1>

            <div class="flex items-center gap-4">
                <span class="text-gray-600">Welcome, {{ auth()->user()->name }}!</span>
                <a href="/" class="text-blue-600 hover:text-blue-800">Browse Events</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-6xl p-6">

        <!-- Success/Error Messages -->
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
            <div id="error-message"
                class="relative mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
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

        <!-- My Bookings Content -->
        <div class="rounded-lg bg-white p-6 shadow-md">

            @if (!empty($myBookings) && count($myBookings) > 0)

                <!-- Bookings Summary -->
                <div class="mb-6 rounded-lg bg-blue-50 p-4">
                    <h2 class="mb-2 text-lg font-semibold text-blue-800">Booking Summary</h2>
                    <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-3">
                        <div class="text-center">
                            <p class="font-medium text-gray-900">Total Bookings</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ is_countable($myBookings) ? count($myBookings) : 0 }}</p>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-900">Upcoming Events</p>
                            @php
                                $upcomingCount = collect($myBookings)->where('date', '>=', date('Y-m-d'))->count();
                            @endphp
                            <p class="text-2xl font-bold text-green-600">{{ $upcomingCount }}</p>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-900">Past Events</p>
                            <p class="text-2xl font-bold text-gray-600">{{ count($myBookings) - $upcomingCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bookings List -->
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Your Booked Events</h2>

                <div class="space-y-4">
                    @foreach ($myBookings as $booking)
                        @php
                            $isUpcoming = strtotime($booking->date) >= strtotime(date('Y-m-d'));
                            $isPast = !$isUpcoming;
                        @endphp

                        <div
                            class="{{ $isPast ? 'bg-gray-50 border-gray-200' : 'bg-white border-gray-300' }} rounded-lg border p-4 transition-shadow hover:shadow-md">

                            <!-- Event Status Badge -->
                            <div class="mb-3 flex items-start justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $booking->title }}</h3>
                                <div class="flex items-center gap-2">
                                    @if ($isPast)
                                        <span
                                            class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">
                                            Completed
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                            Upcoming
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Event Description -->
                            @if ($booking->description)
                                <p class="mb-3 text-sm text-gray-600">{{ Str::limit($booking->description, 120) }}</p>
                            @endif

                            <!-- Event Details Grid -->
                            <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">

                                <!-- Left Column -->
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-gray-700">Date:</span>
                                        <span class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1">
                                            {{ date('F j, Y', strtotime($booking->date)) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center">
                                        <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium text-gray-700">Time:</span>
                                        <span class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1">
                                            {{ date('g:i A', strtotime($booking->time)) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="font-medium text-gray-700">Location:</span>
                                        <span class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1">
                                            {{ $booking->location }}
                                        </span>
                                    </div>

                                    <div class="flex items-center">
                                        <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="font-medium text-gray-700">Organizer:</span>
                                        <span class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1">
                                            {{ $booking->organizer_name }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <!-- Booking Info & Actions -->
                            <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-3">
                                <div class="text-xs text-gray-500">
                                    Booked on {{ date('M j, Y \a\t g:i A', strtotime($booking->booked_at)) }}
                                </div>

                                <div class="flex gap-2">
                                    <a href="/events/{{ $booking->uuid }}"
                                        class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        View Details
                                    </a>

                                    @if ($isUpcoming)
                                        <span class="text-gray-300">•</span>
                                        <form method="POST" action="/events/{{ $booking->uuid }}/cancel"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to cancel your booking for {{ $booking->title }}?')"
                                                class="text-sm font-medium text-red-600 hover:text-red-800">
                                                Cancel Booking
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Bookings State -->
                <div class="py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings yet</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't booked any events yet. Start exploring events to
                        make your first booking!</p>
                    <div class="mt-6">
                        <a href="/"
                            class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Browse Events
                        </a>
                    </div>
                </div>
            @endif

        </div>

    </div>

    <!-- JavaScript for Auto-hide Messages -->
    <script>
        // Auto-hide messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            if (successMessage) {
                setTimeout(() => fadeOut(successMessage), 5000);
            }

            if (errorMessage) {
                setTimeout(() => fadeOut(errorMessage), 5000);
            }
        });

        function dismissMessage(elementId) {
            const element = document.getElementById(elementId);
            if (element) fadeOut(element);
        }

        function fadeOut(element) {
            element.style.transition = 'opacity 0.5s ease-out';
            element.style.opacity = '0';
            setTimeout(() => element.remove(), 500);
        }
    </script>

</body>

</html>
