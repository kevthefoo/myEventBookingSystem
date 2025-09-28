@extends('layouts.main')

@section('title')
    Griffith Event Booking System
@endsection

@section('content')
    <div class="mx-auto max-w-7xl p-6">

        <!-- Dashboard Summary Cards -->
        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-4">

            <div class="rounded-lg bg-white p-6 shadow-md">
                <div class="flex items-center">
                    <div class="rounded-full bg-blue-100 p-3 text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Events</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $summaryStats['total_events'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md">
                <div class="flex items-center">
                    <div class="rounded-full bg-green-100 p-3 text-green-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $summaryStats['total_bookings'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md">
                <div class="flex items-center">
                    <div class="rounded-full bg-yellow-100 p-3 text-yellow-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Upcoming Events</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $summaryStats['upcoming_events'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md">
                <div class="flex items-center">
                    <div class="rounded-full bg-purple-100 p-3 text-purple-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Capacity</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $summaryStats['total_capacity'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Events Report -->
        <div class="rounded-lg bg-white p-6 shadow-md">

            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Events Report</h2>
                <div class="text-sm text-gray-500">
                    Generated using Raw SQL Query
                </div>
            </div>

            {{-- @if (count($eventsReport) > 0) --}}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Event Title
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Event Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Total Capacity
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Current Bookings
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Remaining Spots
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Occupancy Rate
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($eventsReport as $event)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $event->title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ Str::limit($event->description ?? 'No description', 50) }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                    {{ date('M j, Y', strtotime($event->date)) }}<br>
                                    <span class="text-xs text-gray-500">{{ date('H:i', strtotime($event->time)) }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                    {{ $event->capacity }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $event->current_bookings }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="{{ $event->remaining_spots > 0 ? 'text-green-600' : 'text-red-600' }} text-sm font-medium">
                                        {{ $event->remaining_spots }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $occupancyRate =
                                            $event->capacity > 0
                                                ? round(($event->current_bookings / $event->capacity) * 100, 1)
                                                : 0;
                                    @endphp
                                    <div class="flex items-center">
                                        <div class="mr-2 h-2 flex-1 rounded-full bg-gray-200">
                                            <div class="h-2 rounded-full bg-blue-600" style="width: {{ $occupancyRate }}%">
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $occupancyRate }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Report Summary -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-3">
                    <div class="rounded-lg bg-gray-50 p-4 text-center">
                        <p class="font-medium text-gray-900">Total Events</p>
                        <p class="text-2xl font-bold text-blue-600">{{ count($eventsReport) }}</p>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-4 text-center">
                        <p class="font-medium text-gray-900">Total Capacity</p>
                        <p class="text-2xl font-bold text-green-600">{{ collect($eventsReport)->sum('capacity') }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-4 text-center">
                        <p class="font-medium text-gray-900">Total Bookings</p>
                        <p class="text-2xl font-bold text-purple-600">
                            {{ collect($eventsReport)->sum('current_bookings') }}</p>
                    </div>
                </div>
            </div>
            {{-- @else
                <div class="py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No events found</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't created any events yet.</p>
                    <div class="mt-6">
                        <a href="/eventmanager/create"
                            class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Create your first event
                        </a>
                    </div>
                </div>
            @endif --}}

        </div>

    </div>
@endsection
