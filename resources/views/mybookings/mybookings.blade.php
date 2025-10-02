@extends('layouts.main')

@section('title')
    My Bookings
@endsection

@section('content')

    <div class="mx-auto max-w-6xl p-4 sm:p-6 dark:bg-gray-800">

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div id="success-message"
                class="relative mb-4 rounded border border-green-400 bg-green-100 px-3 py-2 text-green-700 sm:mb-6 sm:px-4 sm:py-3">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div id="error-message"
                class="relative mb-4 rounded border border-red-400 bg-red-100 px-3 py-2 text-red-700 sm:mb-6 sm:px-4 sm:py-3">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- My Bookings Content -->
        <div class="rounded-lg p-4 shadow-md sm:p-6 dark:bg-gray-900">

            @if (!empty($myBookings) && count($myBookings) > 0)
                {{-- Bookings Summary --}}
                <div class="mb-4 rounded-lg bg-blue-50 p-3 sm:mb-6 sm:p-4 dark:bg-gray-700">
                    <h2 class="mb-4 text-center text-base font-semibold text-blue-600 sm:text-start sm:text-lg">Booking
                        Summary</h2>
                    <div class="grid grid-cols-1 gap-3 text-xs sm:grid-cols-3 sm:gap-4 sm:text-sm">
                        {{-- Booking Count --}}
                        <div class="text-center">
                            <p class="font-medium text-gray-900 dark:text-white">Total Bookings</p>
                            <p class="text-xl font-bold text-blue-600 sm:text-2xl">
                                {{ is_countable($myBookings) ? count($myBookings) : 0 }}</p>
                        </div>

                        {{-- Upcoming Events Count --}}
                        <div class="text-center">
                            <p class="font-medium text-gray-900 dark:text-white">Upcoming Events</p>
                            @php
                                $upcomingCount = collect($myBookings)
                                    ->where('event.date', '>=', date('Y-m-d'))
                                    ->count();
                            @endphp
                            <p class="text-xl font-bold text-green-600 sm:text-2xl">{{ $upcomingCount }}</p>
                        </div>

                        {{-- Completed Events Count --}}
                        <div class="text-center">
                            <p class="font-medium text-gray-900 dark:text-white">Past Events</p>
                            <p class="text-xl font-bold text-red-600 sm:text-2xl dark:text-red-600">
                                {{ count($myBookings) - $upcomingCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bookings List -->
                <h2 class="mb-3 text-lg font-semibold text-gray-900 sm:mb-4 sm:text-xl dark:text-white">Your Booked Events
                </h2>

                <div class="space-y-3 sm:space-y-4">
                    @foreach ($myBookings as $booking)
                        @php
                            $isUpcoming = strtotime($booking->event->date) >= strtotime(date('Y-m-d'));
                            $isPast = !$isUpcoming;
                        @endphp

                        <div
                            class="{{ $isPast ? 'bg-gray-50 border-gray-200' : 'bg-white border-gray-300' }} rounded-lg border p-3 transition-shadow hover:shadow-md sm:p-4 dark:bg-gray-700">

                            {{-- Event Status Badge --}}
                            <div class="mb-2 flex items-start justify-between sm:mb-3">
                                <h3 class="text-base font-semibold text-gray-900 sm:text-lg dark:text-white">
                                    {{ $booking->event->title }}</h3>
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
                            @if ($booking->event->description)
                                <p class="mb-2 text-xs text-gray-600 sm:mb-3 sm:text-sm dark:text-white">
                                    {{ Str::limit($booking->event->description, 120) }}</p>
                            @endif

                            <!-- Event Details Grid -->
                            <div class="grid grid-cols-1 gap-1 text-xs sm:grid-cols-2 sm:gap-4 sm:text-sm">

                                {{-- Left Column --}}
                                <div class="space-y-1 sm:space-y-2">
                                    {{-- Date --}}
                                    <div class="flex items-center">
                                        <x-heroicon-s-calendar class="mr-1 h-4 w-4 sm:h-5 sm:w-5" />
                                        <span class="font-medium text-gray-700 dark:text-white">Date:</span>
                                        <span
                                            class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1 dark:text-white">
                                            {{ date('F j, Y', strtotime($booking->event->date)) }}
                                        </span>
                                    </div>

                                    {{-- Time --}}
                                    <div class="flex items-center">
                                        <x-heroicon-o-clock class="mr-1 h-4 w-4 sm:h-5 sm:w-5" />
                                        <span class="font-medium text-gray-700 dark:text-white">Time:</span>
                                        <span
                                            class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1 dark:text-white">
                                            {{ date('g:i A', strtotime($booking->event->time)) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Right Column --}}
                                <div class="space-y-1 sm:space-y-2">
                                    {{-- Location --}}
                                    <div class="flex items-center">
                                        <x-heroicon-o-map-pin class="mr-1 h-4 w-4 sm:h-5 sm:w-5" />
                                        <span class="font-medium text-gray-700 dark:text-white">Location:</span>
                                        <span
                                            class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1 max-lg:truncate dark:text-white">
                                            {{ $booking->event->location }}
                                        </span>
                                    </div>

                                    {{-- Organizer --}}
                                    <div class="flex items-center">
                                        <x-heroicon-o-hand-raised class="mr-1 h-4 w-4 sm:h-5 sm:w-5" />
                                        <span class="font-medium text-gray-700 dark:text-white">Organizer:</span>
                                        <span
                                            class="{{ $isPast ? 'text-gray-500' : 'text-gray-900' }} ml-1 dark:text-white">
                                            {{ $booking->event->organizer->first_name }}
                                            {{ $booking->event->organizer->last_name }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                            {{-- Booking Info & Actions --}}
                            <div
                                class="mt-3 flex flex-col items-start justify-between border-t border-gray-200 pt-2 sm:mt-4 sm:flex-row sm:items-center sm:pt-3">

                                {{-- Time You make the book --}}
                                <div class="text-xs text-gray-500 dark:text-white">
                                    Booked on
                                    {{ $booking->created_at->setTimezone('Australia/Brisbane')->format('M j, Y \a\t g:i A') }}
                                </div>

                                {{-- Details Button --}}
                                <div class="mt-2 flex items-center justify-center gap-2 sm:mt-0">
                                    <a href="/events/{{ $booking->event->uuid }}"
                                        class="text-xs font-medium text-blue-600 hover:text-blue-800 sm:text-sm">
                                        View Details
                                    </a>

                                    {{-- Cancel Button --}}
                                    @if ($isUpcoming)
                                        <form method="POST" action="/events/{{ $booking->event->uuid }}/cancel"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to cancel your booking for {{ $booking->event->title }}?')"
                                                class="cursor-pointer text-xs font-medium text-red-600 hover:text-red-800 sm:text-sm">
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
                {{-- No Any Booking State --}}
                <div class="flex flex-col items-center justify-center py-8 text-center sm:py-12">
                    <x-heroicon-s-calendar class="h-10 w-10 sm:h-12 sm:w-12" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 sm:text-base dark:text-white">No bookings yet</h3>
                    <p class="mt-1 text-xs text-gray-500 sm:text-sm dark:text-white">You haven't booked any events yet.
                        Start exploring
                        events to
                        make your first booking!</p>
                    <div class="mt-4 sm:mt-6">
                        <a href="/"
                            class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:px-4 sm:text-sm dark:text-white">
                            <x-heroicon-o-magnifying-glass class="mr-2 h-5 w-5 sm:mr-3 sm:h-7 sm:w-7" />
                            Browse Events
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Auto-hide system messages after 5 seconds
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

        // Hide system message manually
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
@endsection
