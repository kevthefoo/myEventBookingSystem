@extends('layouts.main')

@section('title')
    Griffith University Event Booking System
@endsection

@section('content')
    <div class="mb-4 flex w-full justify-start">
        <h1 class="text-3xl">Upcoming Events</h1>
    </div>

    <!-- Category Filter Section -->
    <div class="mb-6 w-full rounded-lg bg-white py-4 dark:bg-gray-800">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-white">Filter by Categories</label>

                <!-- Category Filter Dropdown -->
                <div class="relative z-0 max-w-xs">
                    <button type="button" id="categoryFilterBtn"
                        class="w-full cursor-pointer rounded-md border border-gray-300 bg-white px-3 py-2 text-left focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        onclick="toggleCategoryFilter()">
                        <span id="categoryFilterText">All Categories</span>
                        <svg class="absolute right-2 top-3 h-4 w-4 transition-transform" id="categoryArrow" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Category Dropdown -->
                    <div id="categoryDropdown"
                        class="absolute z-10 mt-1 hidden w-full rounded-md border border-gray-300 bg-white shadow-lg dark:border-gray-600 dark:bg-gray-700">
                        <div class="max-h-60 overflow-y-auto p-2">
                            <label class="flex cursor-pointer items-center p-2 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <input type="checkbox" class="category-filter mr-2" value="" checked
                                    onchange="updateCategoryFilter()">
                                <span class="text-sm text-gray-700 dark:text-gray-300">All Categories</span>
                            </label>
                            @foreach ($categories as $category)
                                <label class="flex cursor-pointer items-center p-2 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <input type="checkbox" class="category-filter mr-2" value="{{ $category->id }}"
                                        onchange="updateCategoryFilter()">
                                    <div class="flex items-center space-x-2">
                                        <span style="color: {{ $category->color }}">{{ $category->icon }}</span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clear Filter Button -->
            <div class="ml-4">
                <button onclick="clearFilters()"
                    class="cursor-pointer rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    Clear Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="hidden text-center">
        <div
            class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Loading events...</p>
    </div>

    <div class="flex-grow">
        <div id="eventsGrid" class="grid auto-rows-max grid-cols-3 gap-4 text-center">
            @if ($events->count() > 0)
                @foreach ($events as $event)
                    <div
                        class="flex flex-col justify-around rounded-lg border-2 border-black bg-white p-4 dark:bg-gray-900">
                        <h3 class="mb-2 text-lg font-semibold hover:text-blue-600">
                            <a href="/events/{{ $event->uuid }}">
                                {{ $event->title }}
                            </a>
                        </h3>

                        <p class="mb-4 line-clamp-2 text-start text-sm text-gray-600 dark:text-gray-300">
                            {{ $event->description }}</p>
                        <div class="mb-4 flex flex-col items-start justify-center text-sm">
                            <p><strong>Date:</strong> {{ $event->date->format('F j, Y') }}</p>
                            <p><strong>Time:</strong> {{ date('g:i A', strtotime($event->time)) }}</p>
                            <p class=""><strong>Location:</strong>
                                {{ $event->location }}
                            </p>
                            <p><strong>Capacity:</strong> {{ $event->capacity }}</p>
                            <p><strong>Organizer:</strong>
                                {{ $event->organizer->first_name }} {{ $event->organizer->last_name }}</p>
                        </div>

                        <!-- Categories Display -->
                        @if ($event->categories->count() > 0)
                            <div class="flex flex-wrap justify-start gap-1">
                                @foreach ($event->categories as $category)
                                    <div class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium"
                                        style="background-color: {{ $category->color }}20; color: {{ $category->color }}; border: 1px solid {{ $category->color }}30;">
                                        <span>{{ $category->icon }}</span>
                                        <span>{{ $category->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
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

        <!-- No Results Message -->
        <div id="noResults" class="col-span-3 hidden text-center">
            <div class="rounded-lg border-2 border-gray-200 bg-white p-8 dark:border-gray-600 dark:bg-gray-800">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No events found</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">No events match the selected categories.</p>
            </div>
        </div>
    </div>

    <!-- Pagination Container -->
    <div id="paginationContainer" class="mt-6">
        @if ($events->hasPages())
            <div class="pagination my-4 flex justify-center bg-white text-red-400 dark:bg-gray-800">
                {{ $events->links() }}
            </div>
        @endif
    </div>
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

        /* Loading animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        let currentPage = 1;
        let isLoading = false;

        // Toggle category filter dropdown
        function toggleCategoryFilter() {
            const dropdown = document.getElementById('categoryDropdown');
            const arrow = document.getElementById('categoryArrow');

            dropdown.classList.toggle('hidden');
            arrow.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        // Update category filter and apply filtering
        function updateCategoryFilter() {
            const checkboxes = document.querySelectorAll('.category-filter:checked');
            const text = document.getElementById('categoryFilterText');
            const allCategories = document.querySelector('.category-filter[value=""]');

            // Handle "All Categories" selection
            if (event.target.value === '' && event.target.checked) {
                // If "All Categories" is selected, uncheck all others
                document.querySelectorAll('.category-filter:not([value=""])').forEach(cb => {
                    cb.checked = false;
                });
                text.textContent = 'All Categories';
            } else if (event.target.value !== '') {
                // If a specific category is selected, uncheck "All Categories"
                allCategories.checked = false;
                const selectedCount = document.querySelectorAll('.category-filter:checked:not([value=""])').length;
                if (selectedCount === 0) {
                    allCategories.checked = true;
                    text.textContent = 'All Categories';
                } else {
                    text.textContent = `${selectedCount} categor${selectedCount === 1 ? 'y' : 'ies'} selected`;
                }
            }

            // Auto-apply filters when categories change
            applyFilters();
        }

        // Apply category filters
        function applyFilters(page = 1) {
            if (isLoading) return;

            isLoading = true;
            showLoading();

            // Get selected categories
            const selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked:not([value=""])'))
                .map(cb => cb.value);

            // Build query parameters
            const params = new URLSearchParams();
            if (selectedCategories.length > 0) {
                selectedCategories.forEach(catId => params.append('categories[]', catId));
            }
            params.append('page', page);

            // Make AJAX request
            fetch(`/api/events/filter?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    updateEventsGrid(data.events);
                    updatePagination(data.pagination);
                    hideLoading();
                    isLoading = false;
                    currentPage = page;
                })
                .catch(error => {
                    console.error('Filter error:', error);
                    hideLoading();
                    isLoading = false;
                });
        }

        // Clear all filters
        function clearFilters() {
            // Reset category checkboxes
            document.querySelectorAll('.category-filter').forEach(cb => {
                cb.checked = cb.value === '';
            });

            document.getElementById('categoryFilterText').textContent = 'All Categories';
            applyFilters();
        }

        // Update events grid
        function updateEventsGrid(events) {
            const grid = document.getElementById('eventsGrid');
            const noResults = document.getElementById('noResults');

            if (events.length === 0) {
                grid.innerHTML = '';
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');

                let html = '';
                events.forEach(event => {
                    html += createEventCard(event);
                });
                grid.innerHTML = html;
            }
        }

        // Create event card HTML
        function createEventCard(event) {
            const eventDate = new Date(event.date);
            const eventTime = new Date(`1970-01-01T${event.time}`);

            let categoriesHtml = '';
            if (event.categories && event.categories.length > 0) {
                categoriesHtml = '<div class="flex flex-wrap justify-start gap-1">';
                event.categories.forEach(category => {
                    categoriesHtml += `
                <div class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium"
                     style="background-color: ${category.color}20; color: ${category.color}; border: 1px solid ${category.color}30;">
                    <span>${category.icon}</span>
                    <span>${category.name}</span>
                </div>
            `;
                });
                categoriesHtml += '</div>';
            }

            return `
        <div class="flex flex-col justify-around rounded-lg border-2 border-black bg-white p-4 dark:bg-gray-900">
            <h3 class="mb-2 text-lg font-semibold">
                <a href="/events/${event.uuid}">
                    ${event.title}
                </a>
            </h3>

            <p class="mb-4 line-clamp-2 text-start text-sm text-gray-600 dark:text-gray-300">
                ${event.description}
            </p>
            <div class="mb-4 flex flex-col items-start justify-center text-sm">
                <p><strong>Date:</strong> ${eventDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                <p><strong>Time:</strong> ${eventTime.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })}</p>
                <p><strong>Location:</strong> ${event.location}</p>
                <p><strong>Capacity:</strong> ${event.capacity}</p>
                <p><strong>Organizer:</strong> ${event.organizer.first_name} ${event.organizer.last_name}</p>
            </div>
            
            ${categoriesHtml}
        </div>
    `;
        }

        // Update pagination
        function updatePagination(pagination) {
            const container = document.getElementById('paginationContainer');

            if (pagination.last_page <= 1) {
                container.innerHTML = '';
                return;
            }

            let html =
                '<div class="pagination flex justify-center bg-white text-red-400 dark:bg-gray-800"><nav class="flex space-x-1">';

            // Previous button
            if (pagination.current_page > 1) {
                html +=
                    `<button onclick="applyFilters(${pagination.current_page - 1})" class="rounded border px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Previous</button>`;
            }

            // Page numbers
            for (let i = 1; i <= pagination.last_page; i++) {
                const active = i === pagination.current_page;
                html +=
                    `<button onclick="applyFilters(${i})" class="${active ? 'bg-gray-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700'} rounded border px-3 py-2">${i}</button>`;
            }

            // Next button
            if (pagination.current_page < pagination.last_page) {
                html +=
                    `<button onclick="applyFilters(${pagination.current_page + 1})" class="rounded border px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">Next</button>`;
            }

            html += '</nav></div>';
            container.innerHTML = html;
        }

        // Show/hide loading
        function showLoading() {
            const loadingSpinner = document.getElementById('loadingSpinner');
            const eventsGrid = document.getElementById('eventsGrid');

            if (loadingSpinner) loadingSpinner.classList.remove('hidden');
            if (eventsGrid) eventsGrid.classList.add('opacity-50');
        }

        function hideLoading() {
            const loadingSpinner = document.getElementById('loadingSpinner');
            const eventsGrid = document.getElementById('eventsGrid');

            if (loadingSpinner) loadingSpinner.classList.add('hidden');
            if (eventsGrid) eventsGrid.classList.remove('opacity-50');
        }

        // Close category dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('categoryDropdown');
            const button = document.getElementById('categoryFilterBtn');

            if (dropdown && button && !dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.classList.add('hidden');
                const arrow = document.getElementById('categoryArrow');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        });
    </script>
@endsection
