@extends('layouts.main')

@section('title')
    My Bookings
@endsection

@section('content')

    <div class="mx-auto max-w-6xl p-6 dark:bg-gray-800">

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div id="success-message"
                class="relative mb-6 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700">
                <span>{{ session('success') }}</span>

            </div>
        @endif

        @if (session('error'))
            <div id="error-message" class="relative mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- My Bookings Content -->
        <div class="rounded-lg p-6 shadow-md dark:bg-gray-900">

            @if (!empty($myBookings) && count($myBookings) > 0)
                <!-- Bookings Summary -->
                <div class="mb-6 rounded-lg bg-blue-50 p-4 dark:bg-gray-700">
                    <h2 class="mb-2 text-lg font-semibold text-blue-600">Booking Summary</h2>
                    <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-3">
                        <div class="text-center">
                            <p class="font-medium text-gray-900 dark:text-white">Total Bookings</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ is_countable($myBookings) ? count($myBookings) : 0 }}</p>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-900 dark:text-white">Upcoming Events</p>
                            @php
                                $upcomingCount = collect($myBookings)->where('date', '>=', date('Y-m-d'))->count();
                            @endphp
                            <p class="text-2xl font-bold text-green-600">{{ $upcomingCount }}</p>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-900 dark:text-white">Past Events</p>
                            <p class="text-2xl font-bold text-gray-600 dark:text-gray-300">
                                {{ count($myBookings) - $upcomingCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bookings List -->
                <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Your Booked Events</h2>

                <div class="space-y-4">
                    @foreach ($myBookings as $booking)
                        @php
                            $isUpcoming = strtotime($booking->date) >= strtotime(date('Y-m-d'));
                            $isPast = !$isUpcoming;
                        @endphp

                        <div
                            class="{{ $isPast ? 'bg-gray-50 border-gray-200' : 'bg-white border-gray-300' }} rounded-lg border p-4 transition-shadow hover:shadow-md dark:bg-gray-700">

                            <!-- Event Status Badge -->
                            <div class="mb-3 flex items-start justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $booking->title }}</h3>
                                <div class="flex items-center gap-2">
                                    @if ($isPast)
                                        <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">
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
                                <p class="mb-3 text-sm text-gray-600 dark:text-white">
                                    {{ Str::limit($booking->description, 120) }}</p>
                            @endif

                            <!-- Event Details Grid -->
                            <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">

                                <!-- Left Column -->
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <x-mdi-calendar class="mr-1 h-5 w-5" />
                                        <span class="font-medium text-gray-700 dark:text-white">Date:</span>
                                        <span
                                            class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1 dark:text-white">
                                            {{ date('F j, Y', strtotime($booking->date)) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center">
                                        <x-mdi-clock-time-five-outline class="mr-1 h-5 w-5" />
                                        <span class="font-medium text-gray-700 dark:text-white">Time:</span>
                                        <span
                                            class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1 dark:text-white">
                                            {{ date('g:i A', strtotime($booking->time)) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <x-mdi-map-marker-outline class="mr-1 h-5 w-5" />
                                        <span class="font-medium text-gray-700 dark:text-white">Location:</span>
                                        <span
                                            class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1 dark:text-white">
                                            {{ $booking->location }}
                                        </span>
                                    </div>

                                    <div class="flex items-center">
                                        <x-mdi-human-greeting-variant class="mr-1 h-5 w-5" />
                                        <span class="font-medium text-gray-700 dark:text-white">Organizer:</span>
                                        <span
                                            class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1 dark:text-white">
                                            {{ $booking->organizer_name }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <!-- Booking Info & Actions -->
                            <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-3">
                                <div class="text-xs text-gray-500 dark:text-white">
                                    Booked on {{ date('M j, Y \a\t g:i A', strtotime($booking->booked_at)) }}
                                </div>

                                <div class="flex gap-2">
                                    <a href="/events/{{ $booking->uuid }}"
                                        class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        View Details
                                    </a>

                                    @if ($isUpcoming)
                                        <span class="text-gray-300">•</span>
                                        <form method="POST" action="/events/{{ $booking->uuid }}/cancel" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to cancel your booking for {{ $booking->title }}?')"
                                                class="cursor-pointer text-sm font-medium text-red-600 hover:text-red-800">
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
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <x-mdi-calendar-blank-outline class="h-12 w-12" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No bookings yet</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-white">You haven't booked any events yet. Start exploring
                        events to
                        make your first booking!</p>
                    <div class="mt-6">
                        <a href="/"
                            class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:text-white">
                            <x-mdi-magnify class="mr-3 h-7 w-7" />
                            Browse Events
                        </a>
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection

<!-- JavaScript for Auto-hide Messages -->

@section('script')
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
@endsection
