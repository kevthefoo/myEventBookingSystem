@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="mx-auto max-w-7xl p-6">

        <!-- Dashboard Summary Cards -->
        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-4">

            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
                <div class="flex items-center">
                    <div class="rounded-full bg-blue-100 p-3 text-blue-600">
                        <x-heroicon-s-calendar class="h-5 w-5" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-white">Total Events</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $summaryStats['total_events'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
                <div class="flex items-center">
                    <div class="rounded-full bg-green-100 p-3 text-green-600">
                        <x-heroicon-s-ticket class="h-5 w-5" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-white">Total Bookings</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $summaryStats['total_bookings'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
                <div class="flex items-center">
                    <div class="rounded-full bg-yellow-100 p-3 text-yellow-600">
                        <x-heroicon-o-clock class="h-5 w-5" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-white">Upcoming Events</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $summaryStats['upcoming_events'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">
                <div class="flex items-center">
                    <div class="rounded-full bg-purple-100 p-3 text-purple-600">
                        <x-heroicon-o-archive-box class="h-5 w-5" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-white">Total Capacity</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $summaryStats['total_capacity'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Events Report -->
        <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-900">

            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Events Report</h2>

            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto dark:bg-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-white">
                                Event Title
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-white">
                                Event Date
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-white">
                                Total Capacity
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-white">
                                Current Bookings
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-white">
                                Remaining Spots
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-white">
                                Occupancy Rate
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($eventsDetails as $event)
                            <tr class="hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <a href="/events/{{ $event->uuid }}" class="cursor-pointer no-underline">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $event->title }}
                                        </div>
                                    </a>

                                    <div class="text-sm text-gray-500 dark:text-white">
                                        {{ Str::limit($event->description ?? 'No description', 50) }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ date('M j, Y', strtotime($event->date)) }}<br>
                                    <span
                                        class="text-xs text-gray-500 dark:text-white">{{ date('H:i', strtotime($event->time)) }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $event->capacity }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
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
                                        <span
                                            class="text-sm font-medium text-gray-900 dark:text-white">{{ $occupancyRate }}%</span>
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
                    <div class="rounded-lg bg-gray-50 p-4 text-center dark:bg-gray-800">
                        <p class="font-medium text-gray-900 dark:text-white">Total Events</p>
                        <p class="text-2xl font-bold text-blue-600">{{ count($eventsDetails) }}</p>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-4 text-center dark:bg-gray-800">
                        <p class="font-medium text-gray-900 dark:text-white">Total Capacity</p>
                        <p class="text-2xl font-bold text-green-600">{{ collect($eventsDetails)->sum('capacity') }}
                        </p>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-4 text-center dark:bg-gray-800">
                        <p class="font-medium text-gray-900 dark:text-white">Total Bookings</p>
                        <p class="text-2xl font-bold text-purple-600">
                            {{ collect($eventsDetails)->sum('current_bookings') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
