<!-- filepath: c:\Users\kevth\Desktop\myEventBookingSystem\resources\views\eventmanager\edit\edit.blade.php -->

@extends('layouts.main')

@section('title')
    Edit Event
@endsection

@section('content')
    <div class="mx-auto max-w-4xl p-6">
        <div class="rounded-lg bg-white p-8 shadow-lg dark:bg-gray-800">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Edit Event</h2>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form action="/eventmanager/edit/{{ $event->uuid }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Event Title -->
                <div>
                    <label for="title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Event Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Description -->
                <div>
                    <label for="description" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categories Selection - Dropdown with Multi-Select -->
                <div>
                    <label for="categories" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Event Categories <span class="text-red-500">*</span>
                    </label>

                    <!-- Custom Dropdown -->
                    <div class="relative">
                        <div id="categoryDropdown"
                            class="w-full cursor-pointer rounded-md border border-gray-300 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                            onclick="toggleDropdownMenu()">
                            <div class="flex items-center justify-between">
                                <span id="selectedText" class="text-gray-700 dark:text-white">Select categories...</span>
                                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" id="dropdownArrow"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Dropdown Menu -->
                        <div id="categoryMenu"
                            class="absolute z-10 mt-1 hidden max-h-60 w-full overflow-y-auto rounded-md border border-gray-300 bg-white shadow-lg dark:border-gray-600 dark:bg-gray-700">
                            @php
                                $categories = \App\Models\Category::active()->get();
                                $eventCategoryIds = old('categories', $event->categories->pluck('id')->toArray());
                            @endphp
                            @foreach ($categories as $category)
                                <label
                                    class="flex cursor-pointer items-center px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        class="category-checkbox mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        {{ in_array($category->id, $eventCategoryIds) ? 'checked' : '' }}
                                        onchange="updateSelectedCategories()">
                                    <div class="flex items-center space-x-2">
                                        <span style="color: {{ $category->color }}">{{ $category->icon }}</span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Selected Categories Display -->
                    <div id="selectedCategories" class="mt-2 flex min-h-[2rem] flex-wrap gap-2"></div>

                    @error('categories')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="date" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date" name="date"
                            value="{{ old('date', $event->date->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:[color-scheme:dark]">
                        @error('date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="time" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                            Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="time" name="time"
                            value="{{ old('time', date('H:i', strtotime($event->time))) }}" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:[color-scheme:dark]">
                        @error('time')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}"
                        required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('location')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacity -->
                <div>
                    <label for="capacity" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Capacity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $event->capacity) }}"
                        min="1" max="1000" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6">
                    <a href="/eventmanager"
                        class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                        class="cursor-pointer rounded-md bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Dark mode calendar icon styling */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }

        /* Category tag styling */
        .category-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 9999px;
            font-size: 0.875rem;
            color: rgb(59, 130, 246);
        }

        .dark .category-tag {
            background: rgba(59, 130, 246, 0.2);
            color: rgb(147, 197, 253);
        }

        .category-remove {
            cursor: pointer;
            margin-left: 0.25rem;
            font-weight: bold;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .category-remove:hover {
            opacity: 1;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function toggleDropdownMenu() {
            const menu = document.getElementById('categoryMenu');
            const arrow = document.getElementById('dropdownArrow');

            menu.classList.toggle('hidden');

            if (menu.classList.contains('hidden')) {
                arrow.style.transform = 'rotate(0deg)';
            } else {
                arrow.style.transform = 'rotate(180deg)';
            }
        }

        function updateSelectedCategories() {
            const checkboxes = document.querySelectorAll('.category-checkbox:checked');
            const selectedText = document.getElementById('selectedText');

            if (checkboxes.length === 0) {
                selectedText.textContent = 'Select categories...';
                selectedText.className = 'text-gray-500 dark:text-gray-400';
            } else {
                selectedText.textContent = `${checkboxes.length} categor${checkboxes.length === 1 ? 'y' : 'ies'} selected`;
                selectedText.className = 'text-gray-700 dark:text-white';

                // Create tags for selected categories
                checkboxes.forEach(checkbox => {
                    const label = checkbox.closest('label');
                    const icon = label.querySelector('span[style]').textContent;
                    const name = label.querySelector('span.text-sm').textContent;
                    const color = label.querySelector('span[style]').style.color;

                    const tag = document.createElement('span');
                    tag.className = 'category-tag';
                    tag.innerHTML = `
    <span style="color: ${color}">${icon}</span>
    <span>${name}</span>
    <span class="category-remove" onclick="removeCategory('${checkbox.value}')">×</span>
    `;
                });
            }
        }

        function removeCategory(categoryId) {
            const checkbox = document.querySelector(`input[value="${categoryId}"]`);
            if (checkbox) {
                checkbox.checked = false;
                updateSelectedCategories();
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('categoryDropdown');
            const menu = document.getElementById('categoryMenu');
            const arrow = document.getElementById('dropdownArrow');

            if (!dropdown.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSelectedCategories();
        });
    </script>
@endsection
