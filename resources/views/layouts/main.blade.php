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

<body class="min-h-screen border-4 border-red-500">

    <!-- Header Section -->
    <header class="fixed flex h-16 w-full items-center justify-around border-2 border-black">
        <div class="flex items-center">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="Griffith University Logo" class="h-8 w-auto">
                <span class="hidden text-lg font-bold text-gray-900 sm:block">GUEBS</span>
            </a>
        </div>
        <nav>
            <ul class="flex gap-4">
                <li><a href="/">Home</a></li>
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
                <span class="text-gray-600">Welcome, {{ auth()->user()->name }}!</span>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="cursor-pointer text-red-600 hover:text-red-800">
                        Logout
                    </button>
                </form>
            @else
                <a href="/login" class="text-blue-600 hover:text-blue-800">Login</a>
                <a href="/register" class="text-blue-600 hover:text-blue-800">Register</a>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-18 flex min-h-screen w-full flex-col border-4 border-blue-400 px-12">
        @yield('content')
    </main>

    <!-- Scripts Section -->
    @yield('scripts')
</body>

</html>
