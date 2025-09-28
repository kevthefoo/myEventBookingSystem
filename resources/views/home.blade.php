@extends('layouts.main')

@section('title')
    Griffith Event Booking System
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl">Upcoming Events</h1>
    </div>

    <div class="flex-grow">
        <div class="grid auto-rows-max grid-cols-3 gap-4 text-center">
            @if ($events->count() > 0)
                @foreach ($events as $event)
                    <div class="flex flex-col justify-around rounded-lg border-2 border-black bg-white p-4">
                        <h3 class="mb-2 text-lg font-semibold">
                            <a href="/events/{{ $event->uuid }}">
                                {{ $event->title }}
                            </a>
                        </h3>
                        <p class="mb-4 line-clamp-2 text-start text-sm text-gray-600">{{ $event->description }}</p>
                        <div class="flex flex-col items-start justify-center text-sm">
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

        </div>
    </div>

    {{-- Pagination bar --}}
    @if ($events->hasPages())
        <div class="pagination my-4 flex justify-center bg-white text-red-400">
            {{ $events->links() }}
        </div>
    @endif
    <style>
        .pagination a,
        .pagination span {
            background-color: #f8f9fa;
            color: black;
        }

        span[aria-current="page"] span {
            background-color: grey;
            color: white;
        }

        .pagination p {
            display: none;
        }
    </style>
@endsection
