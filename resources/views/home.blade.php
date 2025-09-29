@extends('layouts.main')

@section('title')
    Griffith University Event Booking System
@endsection

@section('content')
    <div class="mb-4">
        <h1 class="text-3xl">Upcoming Events</h1>
    </div>

    <div class="flex-grow">
        <div class="grid auto-rows-max grid-cols-3 gap-4 text-center">
            @if ($events->count() > 0)
                @foreach ($events as $event)
                    <div class="flex flex-col justify-around rounded-lg border-2 border-black bg-white p-4 dark:bg-gray-900">
                        <h3 class="mb-2 text-lg font-semibold">
                            <a href="/events/{{ $event->uuid }}">
                                {{ $event->title }}
                            </a>
                        </h3>

                        <p class="mb-4 line-clamp-2 text-start text-sm text-gray-600 dark:text-gray-300">
                            {{ $event->description }}</p>
                        <div class="flex flex-col items-start justify-center text-sm">
                            <p><strong>Date:</strong> {{ $event->date->format('F j, Y') }}</p>
                            <p><strong>Time:</strong> {{ date('g:i A', strtotime($event->time)) }}</p>
                            <p><strong>Location:</strong> {{ $event->location }}</p>
                            <p><strong>Capacity:</strong> {{ $event->capacity }}</p>
                            <p><strong>Organizer:</strong>
                                {{ $event->organizer->first_name }}{{ $event->organizer->last_name }}</p>
                            @if ($event->categories->count() > 0)
                                <div class="mb-3 flex flex-wrap justify-center gap-1 mt-2">
                                    @foreach ($event->categories as $category)
                                        <div
                                            class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium"
                                            style="background-color: {{ $category->color }}20; color: {{ $category->color }}; border: 1px solid {{ $category->color }}30;">
                                            <span>{{ $category->icon }}</span>
                                            <span>{{ $category->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
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
        <div class="pagination my-4 flex justify-center bg-white text-red-400 dark:bg-gray-800">
            {{ $events->links() }}
        </div>
    @endif

@endsection

@section('styles')
    <style>
        .pagination a,
        .pagination span {
            background-color: #f8f9fa;
            color: black;
        }

        .dark .pagination a,
        .dark .pagination span {
            color: white;
            background-color: #1e2939;
        }

        span[aria-current="page"] span {
            background-color: #374151;
            color: white;
        }

        .dark span[aria-current="page"] span {
            background-color: white;
            color: black;
        }

        .pagination p {
            display: none;
        }
    </style>
@endsection
