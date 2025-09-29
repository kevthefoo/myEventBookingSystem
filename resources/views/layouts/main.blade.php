<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Your existing Tailwind CSS styles */
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @layer theme {

                :root,
                :host {
                    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                    --font-serif: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
                    --font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
                    /* ... all your existing CSS variables ... */
                }
            }

            @layer base {

                *,
                :after,
                :before,
                ::backdrop {
                    box-sizing: border-box;
                    border: 0 solid;
                    margin: 0;
                    padding: 0
                }

                /* ... all your existing base styles ... */
            }

            @layer utilities {
                .absolute {
                    position: absolute
                }

                .relative {
                    position: relative
                }

                /* ... all your existing utility classes ... */
            }
        </style>
    @endif

    @yield('styles')
</head>

<body class="min-h-screen dark:bg-gray-800 dark:text-white">

    <!-- Header Section -->
    <!-- filepath: c:\Users\kevth\Desktop\myEventBookingSystem\resources\views\layouts\main.blade.php -->

    <header
        class="fixed flex h-16 w-full select-none items-center justify-around border-b-2 border-b-black bg-white dark:border-b-white dark:bg-gray-800">
        <div class="flex items-center">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="Griffith University Logo" class="h-8 w-auto">
                <span class="hidden text-lg font-bold text-gray-900 sm:block dark:text-white">GUEBS</span>
            </a>
        </div>
        <nav>
            <ul class="flex gap-4">
                <li><a href="/">Events</a></li>
                <li><a href="/mybookings">Bookings</a></li>
                @auth
                    @if (auth()->user()->role === 'organizer')
                        <li><a href="/eventmanager">Management</a></li>
                        <li><a href="/admin/dashboard">Dashboard</a></li>
                    @endif
                @endauth
            </ul>
        </nav>
        <div class="flex items-center justify-center gap-2">
            @auth
                <div class="relative flex flex-col">
                    <div class="flex items-center justify-center gap-2">
                        <div>{{ auth()->user()->first_name }}</div>
                        <div class="transform cursor-pointer transition-transform duration-200" id="dropdownArrow"
                            onclick="toggleDropdown()">▼
                        </div>
                    </div>

                    <div id="dropdownMenu"
                        class="absolute right-0 top-4 z-50 mt-2 hidden w-40 border border-gray-200 bg-white shadow-lg">
                        <div class="py-2">
                            <!-- User Info -->
                            <div class="border-b border-gray-100 px-4 py-2">
                                <div class="text-sm text-gray-500">{{ ucfirst(auth()->user()->role) }} Account</div>
                            </div>

                            <!-- Navigation Links -->
                            <div class="py-1">
                                @if (auth()->user()->role === 'organizer')
                                    <a href="/eventmanager" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        📊 Manage Events
                                    </a>
                                    <a href="/admin/dashboard"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        📈 Dashboard
                                    </a>
                                @else
                                    <a href="/mybookings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        🎫 My Bookings
                                    </a>
                                @endif

                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    👤 Profile Settings
                                </a>
                                <a href="/help" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    ❓ Help & Support
                                </a>
                            </div>

                            <form method="POST" action="/logout" class="text-center">
                                @csrf
                                <button type="submit" class="w-full cursor-pointer text-red-600 hover:text-red-800">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="/login"
                    class="rounded-2xl border-2 border-blue-500 px-4 py-2 font-semibold text-blue-600 transition-colors duration-200 hover:bg-blue-500 hover:text-white dark:border-blue-400 dark:text-blue-400 dark:hover:bg-blue-400 dark:hover:text-gray-900">Login
                </a>
                <a href="/register"
                    class="rounded-2xl border-2 border-green-500 bg-green-500 px-4 py-2 font-semibold text-white transition-colors duration-200 hover:border-green-600 hover:bg-green-600 dark:border-green-600 dark:bg-green-600 dark:hover:border-green-700 dark:hover:bg-green-700">
                    Register
                </a>
            @endauth

            <label class="ml-2 inline-flex cursor-pointer items-center">
                <input type="checkbox" value="" class="peer sr-only" onclick="toggleDarkMode()">
                <div
                    class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-blue-600 dark:peer-focus:ring-blue-800">
                </div>
            </label>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex min-h-screen w-full flex-col px-12 pt-20 dark:bg-gray-800">
        @yield('content')
    </main>

    <!-- Scripts Section -->
    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            const arrow = document.getElementById('dropdownArrow');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        function toggleDarkMode() {
            const htmlTag = document.documentElement; // Gets the <html> tag

            // Toggle the dark class
            if (htmlTag.classList.contains('dark')) {
                htmlTag.classList.remove('dark');
                localStorage.setItem('darkMode', 'false');
            } else {
                htmlTag.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
            }
        }

        // Initialize dark mode on page load
        document.addEventListener('DOMContentLoaded', function() {
            const htmlTag = document.documentElement;
            const savedDarkMode = localStorage.getItem('darkMode');

            // Check if user has a saved preference, otherwise check system preference
            if (savedDarkMode === 'true' ||
                (savedDarkMode === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                htmlTag.classList.add('dark');
            } else {
                htmlTag.classList.remove('dark');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
