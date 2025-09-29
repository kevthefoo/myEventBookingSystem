@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="mx-auto max-w-7xl p-6">

        <!-- Dashboard Summary Cards -->
        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-4">

            <div class="rounded-lg bg-white p-6 shadow-md">
                <div class="flex items-center">
                    <div class="rounded-full bg-blue-100 p-3 text-blue-600">
                        <x-mdi-calendar-blank-outline class="h-5 w-5" />
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
                        <x-mdi-ticket-confirmation-outline class="h-5 w-5" />
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
                        <x-mdi-clock-time-eleven-outline class="h-5 w-5" />
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
                        <x-mdi-bucket class="h-5 w-5" />
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
        </div>

    </div>
@endsection
