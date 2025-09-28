@extends('layouts.main')

@section('title')
    Griffith Event Booking System
@endsection

@section('content')
    <div class="mb-12">Upcoming Events</div>
    <div class="grid grid-cols-3 gap-4 text-center">
        @if ($events->count() > 0)
            @foreach ($events as $event)
                <div class="rounded-lg border-2 border-black bg-white p-4">
                    <h3 class="mb-2 text-lg font-semibold">
                        <a href="/events/{{ $event->uuid }}">
                            {{ $event->title }}
                        </a>
                    </h3>
                    <p class="mb-2 text-sm text-gray-600">{{ $event->description }}</p>
                    <div class="text-sm">
                        <p><strong>Date:</strong> {{ $event->date }}</p>
                        <p><strong>Time:</strong> {{ $event->time }}</p>
                        <p><strong>Location:</strong> {{ $event->location }}</p>
                        <p><strong>Capacity:</strong> {{ $event->capacity }}</p>
                        <p><strong>Organizer:</strong> {{ $event->organizer->name }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-3 rounded-lg border-2 border-black bg-white p-4">
                <p>No events found. Run the EventSeeder!</p>
                <code class="mt-2 block rounded bg-gray-100 p-2 text-sm">
                    php artisan db:seed --class=EventSeeder
                </code>
            </div>
        @endif
        <h2 class="mb-4 text-xl font-semibold">Organizer Emails:</h2>
    </div>

    <!-- Pagination Links -->
    @if ($events->hasPages())
        <div class="">
            <div class="">
                {{ $events->links() }}
            </div>
        </div>
    @endif
@endsection
