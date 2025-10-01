@extends('layouts.main')

@section('title')
    Event Details
@endsection

@section('content')
    <div class="mx-auto max-w-2xl rounded-lg bg-white p-6 shadow dark:bg-gray-800 dark:shadow-sm dark:shadow-white">
        {{-- Back to Home Page Button --}}
        <a href="/" class="mb-4 inline-block text-blue-600 hover:text-blue-800 dark:text-white">
            ← Back to Home
        </a>

        {{-- Event Title --}}
        <h1 class="mb-4 text-3xl font-bold">{{ $event->title }}</h1>

        {{-- Event Description --}}
        <p class="mb-6 text-gray-700 dark:text-white">{{ $event->description }}</p>

        {{-- Event Details --}}
        <div class="mb-6 rounded-lg bg-gray-50 p-4 dark:bg-gray-800">
            <div class="mb-4 grid grid-cols-2 gap-4 md:grid-cols-2">
                {{-- Date and Time --}}
                <div class="flex items-start justify-start">
                    <x-heroicon-s-calendar class="mr-2 mt-0.5 h-5 w-5 flex-shrink-0" />
                    <div>
                        <strong>Date:</strong>
                        {{ $event->date->format('F j, Y') }}
                        <br>
                        <strong>Time:</strong> {{ date('g:i A', strtotime($event->time)) }}
                    </div>
                </div>

                {{-- Capacity and Remaining Spots --}}
                <div class="flex items-start justify-start">
                    <x-heroicon-o-archive-box class="mr-2 mt-0.5 h-5 w-5 flex-shrink-0" />
                    <div>
                        <strong>Capacity:</strong> {{ $event->capacity }} people<br>
                        <strong>Available:</strong>
                        <span class="{{ $remainingSpots > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $remainingSpots }} spots remaining
                        </span>
                    </div>
                </div>

                {{-- Location --}}
                <div class="flex items-start justify-start">
                    <x-heroicon-o-map-pin class="mr-2 mt-0.5 h-5 w-5 flex-shrink-0" />
                    <div>
                        <strong>Location:</strong> {{ $event->location }}
                    </div>
                </div>

                {{-- Organizer --}}
                <div class="flex items-start justify-start">
                    <x-heroicon-o-hand-raised class="mr-2 mt-0.5 h-5 w-5 flex-shrink-0" />
                    <div><strong>Organizer:</strong> {{ $event->organizer->first_name }} {{ $event->organizer->last_name }}
                    </div>
                </div>
            </div>

            {{-- Category Tags --}}
            @foreach ($event->categories as $category)
                <div class="mb-4 inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium"
                    style="background-color: {{ $category->color }}20; color: {{ $category->color }}; border: 1px solid {{ $category->color }}30;">
                    <span>{{ $category->icon }}</span>
                    <span>{{ $category->name }}</span>
                </div>
            @endforeach

            {{-- Booking Progress Bar --}}
            @php
                $occupancyRate = $event->capacity > 0 ? ($currentBookings / $event->capacity) * 100 : 0;
            @endphp
            <div class="mb-6">
                <div class="mb-1 flex justify-between text-sm text-gray-600 dark:text-white">
                    <span>Bookings: {{ $currentBookings }}/{{ $event->capacity }}</span>
                    <span>{{ number_format($occupancyRate, 1) }}% Full</span>
                </div>
                <div class="h-2 w-full rounded-full bg-gray-200">
                    <div class="h-2 rounded-full bg-blue-600 transition-all duration-300"
                        style="width: {{ $occupancyRate }}%">
                    </div>
                </div>
            </div>

            {{-- Action Buttons (Book | Cancel | Edit | Delete ) --}}
            <div class="space-y-4">
                @auth
                    @if (auth()->id() === $event->organizer_id)
                        <div class="rounded border border-yellow-400 bg-yellow-100 px-4 py-3 text-yellow-700">
                            <p class="text-sm">
                                <strong>Note:</strong> You cannot book this event as you are the event creator.
                            </p>
                        </div>

                        {{-- Organizer Action Buttons --}}
                        <div class="mt-4 flex gap-3">
                            {{-- Edit Button --}}
                            <a href="/eventmanager/edit/{{ $event->uuid }}"
                                class="inline-flex items-center rounded-lg bg-blue-500 px-6 py-3 font-medium text-white transition duration-200 hover:bg-blue-600">
                                <x-heroicon-s-pencil class="mr-2 h-4 w-4" />
                                Edit Event
                            </a>

                            {{-- Delete Button --}}
                            <form method="POST" action="/eventmanager/delete/{{ $event->uuid }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this event?')"
                                    class="inline-flex cursor-pointer items-center rounded-lg bg-red-500 px-6 py-3 font-medium text-white transition duration-200 hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
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
                        </p>
                    </div>
                @endauth
            </div>
        </div>
    @endsection
