<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 p-8">

    <div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow">

        <!-- Back Button -->
        <a href="/" class="mb-4 inline-block text-blue-600 hover:text-blue-800">
            ← Back to Home
        </a>

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

        <!-- Event Title -->
        <h1 class="mb-4 text-3xl font-bold">{{ $event->title }}</h1>

        <!-- Event Description -->
        @if ($event->description)
            <p class="mb-6 text-gray-700">{{ $event->description }}</p>
        @endif

        <!-- Event Details -->
        <div class="mb-6 rounded-lg bg-gray-50 p-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <div>
                            <strong>Date:</strong> {{ $event->date->format('F j, Y') }}<br>
                            <strong>Time:</strong> {{ date('g:i A', strtotime($event->time)) }}
                        </div>
                    </div>

                    <div class="flex items-center">
                        <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div><strong>Location:</strong> {{ $event->location }}</div>
                    </div>
                </div>

                <div class="space-y-3">
                    @php
                        $currentBookings = DB::table('event_attendees')->where('event_id', $event->id)->count();
                        $remainingSpots = $event->capacity - $currentBookings;
                        $isUserBooked = auth()->check()
                            ? DB::table('event_attendees')
                                ->where('event_id', $event->id)
                                ->where('user_id', auth()->id())
                                ->exists()
                            : false;
                    @endphp

                    <div class="flex items-center">
                        <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <div>
                            <strong>Capacity:</strong> {{ $event->capacity }} people<br>
                            <strong>Available:</strong>
                            <span class="{{ $remainingSpots > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $remainingSpots }} spots remaining
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div><strong>Organizer:</strong> {{ $event->organizer->name }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Progress Bar -->
        @php
            $occupancyRate = $event->capacity > 0 ? ($currentBookings / $event->capacity) * 100 : 0;
        @endphp
        <div class="mb-6">
            <div class="mb-1 flex justify-between text-sm text-gray-600">
                <span>Bookings: {{ $currentBookings }}/{{ $event->capacity }}</span>
                <span>{{ number_format($occupancyRate, 1) }}% Full</span>
            </div>
            <div class="h-2 w-full rounded-full bg-gray-200">
                <div class="h-2 rounded-full bg-blue-600 transition-all duration-300"
                    style="width: {{ $occupancyRate }}%"></div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            @auth
                @if (auth()->user()->role === 'organizer')
                    <div class="rounded border border-yellow-400 bg-yellow-100 px-4 py-3 text-yellow-700">
                        <p class="text-sm">
                            <strong>Note:</strong> You are logged in as an organizer. Only regular users can book events.
                        </p>
                    </div>
                @elseif($event->date < now()->toDateString())
                    <div class="rounded border border-gray-400 bg-gray-100 px-4 py-3 text-gray-700">
                        <p class="text-sm">This event has already passed and is no longer available for booking.</p>
                    </div>
                @elseif($isUserBooked)
                    <div class="mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700">
                        <p class="text-sm font-medium">✓ You have successfully booked this event!</p>
                    </div>
                    <form method="POST" action="/events/{{ $event->uuid }}/cancel" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to cancel your booking?')"
                            class="cursor-pointer rounded-lg bg-red-500 px-6 py-3 text-white transition duration-200 hover:bg-red-600">
                            Cancel Booking
                        </button>
                    </form>
                @elseif($remainingSpots <= 0)
                    <button disabled class="cursor-not-allowed rounded-lg bg-gray-400 px-6 py-3 text-white">
                        Event Full - No Spots Available
                    </button>
                @else
                    <form method="POST" action="/events/{{ $event->uuid }}/book">
                        @csrf
                        <button type="submit"
                            class="cursor-pointer rounded-lg bg-blue-500 px-6 py-3 font-medium text-white transition duration-200 hover:bg-blue-600">
                            Book This Event ({{ $remainingSpots }} spots left)
                        </button>
                    </form>
                @endif
            @else
                <div class="rounded border border-blue-400 bg-blue-100 px-4 py-3 text-blue-700">
                    <p class="text-sm">
                        <strong>Please log in to book this event.</strong>
                        <a href="/login" class="underline hover:text-blue-800">Login here</a> or
                        <a href="/register" class="underline hover:text-blue-800">create an account</a>.
                    </p>
                </div>
            @endauth
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
