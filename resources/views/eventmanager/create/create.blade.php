@extends('layouts.main')

@section('title')
    Create New Event
@endsection

@section('content')
    <div class="mx-auto max-w-4xl p-6">
        <div class="rounded-lg bg-white p-8 shadow-lg dark:bg-gray-800">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Create New Event</h2>

            {{-- System Success Messages --}}
            @if (session('success'))
                <div class="mb-6 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- System Error Messages --}}
            @if (session('error'))
                <div class="mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Create New Event Form --}}
            <form action="/eventmanager/create" method="POST" class="space-y-6">
                @csrf
                {{-- Event Title --}}
                <div>
                    <label for="title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Event Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        placeholder="Enter event title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Event Description --}}
                <div>
                    <label for="description" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        placeholder="Describe your event...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categories Selection --}}
                <div>
                    <label for="categories" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Event Categories <span class="text-red-500">*</span>
                    </label>

                    {{-- Dropdown Field --}}
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

                        {{-- Category Dropdown Menu --}}
                        <div id="categoryMenu"
                            class="absolute z-10 mt-1 hidden max-h-60 w-full overflow-y-auto rounded-md border border-gray-300 bg-white shadow-lg dark:border-gray-600 dark:bg-gray-700">
                            @foreach ($categories as $category)
                                <label
                                    class="flex cursor-pointer items-center px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        class="category-checkbox mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                        onchange="updateSelectedCategories()">
                                    <div class="flex items-center space-x-2">
                                        <span style="color: {{ $category->color }}">{{ $category->icon }}</span>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    @error('categories')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm">Can't find your category? <span onclick="openCategoryModal()"
                            class="cursor-pointer text-blue-500 hover:text-blue-700"> Create
                            One!</span></p>
                </div>

                {{-- Date and Time --}}
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="date" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date" name="date" value="{{ old('date') }}"
                            min="{{ date('Y-m-d') }}" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:[color-scheme:dark]">
                        @error('date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="time" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                            Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="time" name="time" value="{{ old('time') }}" required
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:[color-scheme:dark]">
                        @error('time')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Location --}}
                <div>
                    <label for="location" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        placeholder="Enter event location">
                    @error('location')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Capacity --}}
                <div>
                    <label for="capacity" class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                        Capacity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1"
                        max="1000" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        placeholder="Maximum number of attendees">
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-between pt-6">
                    <a href="/eventmanager"
                        class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                        class="cursor-pointer rounded-md bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create Event
                    </button>
                </div>
            </form>

            {{-- Category Creation Modal --}}
            <div id="categoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-300/50">
                <div class="mx-4 w-full max-w-md rounded-lg bg-white p-6 shadow-xl dark:bg-gray-800">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Category</h3>
                        <button onclick="closeCategoryModal()"
                            class="cursor-pointer text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <x-heroicon-o-x-mark class="h-5 w-5" />
                        </button>
                    </div>

                    {{-- Create New Category Form --}}
                    <form id="categoryForm" class="space-y-4">
                        @csrf
                        {{-- Category Name Field --}}
                        <div>
                            <label for="category_name"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="category_name" name="name" required
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="e.g., Workshop, Sports">
                        </div>

                        {{-- Category Slug Field  --}}
                        <div>
                            <label for="category_slug"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="category_slug" name="slug" required maxlength="10"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="e.g., workshop">
                            <p class="mt-1 text-xs text-gray-500">Max 10 characters, no spaces</p>
                        </div>

                        {{-- Category Icon Field --}}
                        <div>
                            <label for="category_icon"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                                Icon (Emoji) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="category_icon" name="icon" required maxlength="1"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="🎨">
                            <p class="mt-1 text-xs text-gray-500">Single emoji only</p>
                        </div>

                        {{-- Category Color Field --}}
                        <div>
                            <label for="category_color"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                                Color <span class="text-red-500">*</span>
                            </label>
                            <input type="color" id="category_color" name="color" required value="#3B82F6"
                                class="h-10 w-10 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600">
                        </div>

                        {{-- Category Description Field --}}
                        <div>
                            <label for="category_description"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-white">
                                Description<span class="text-red-500">*</span>
                            </label>
                            <textarea id="category_description" name="description" rows="3"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Brief description of the category..." required></textarea>
                        </div>

                        {{-- New Category Modal Buttons --}}
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="closeCategoryModal()"
                                class="cursor-pointer rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                                Cancel
                            </button>
                            <button type="submit"
                                class="cursor-pointer rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
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
        // Toggle category selection drop down menu
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

        // Update the new selected category
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

        // Close dropdown when clicking anywhere on the page
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

        // Open Category Modal
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('categoryModal').classList.add('flex');
        }

        // Close Category Modal
        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.getElementById('categoryModal').classList.remove('flex');
            document.getElementById('categoryForm').reset();
        }

        // Handle category form submission with AJAX
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent normal form submission

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');

            // Disable submit button
            submitButton.disabled = true;
            submitButton.textContent = 'Creating...';

            fetch('/addcategory', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Category created successfully!');
                        closeCategoryModal();

                        // Add the new category to the dropdown without page refresh
                        addNewCategoryToDropdown(data.category);
                    } else {
                        alert('Error creating category: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while creating the category.');
                })
                .finally(() => {
                    // Re-enable submit button
                    submitButton.disabled = false;
                    submitButton.textContent = 'Create Category';
                });
        });

        // Add new category to dropdown
        function addNewCategoryToDropdown(category) {
            const categoryMenu = document.getElementById('categoryMenu');

            const newCategoryHTML = `
            <label class="flex cursor-pointer items-center px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-600">
                <input type="checkbox" name="categories[]" value="${category.id}"
                    class="category-checkbox mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    onchange="updateSelectedCategories()">
                <div class="flex items-center space-x-2">
                    <span style="color: ${category.color}">${category.icon}</span>
                    <span class="text-sm text-gray-700 dark:text-gray-300">${category.name}</span>
                </div>
            </label>
        `;

            categoryMenu.insertAdjacentHTML('beforeend', newCategoryHTML);
        }
    </script>
@endsection
