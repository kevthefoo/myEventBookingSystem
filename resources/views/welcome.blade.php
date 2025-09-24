<body class="min-h-screen bg-gray-50 p-8">

    <header
        class="fixed left-0 right-0 top-0 z-10 flex h-12 w-full items-center justify-around border-b bg-white shadow-md">
        <div>logo</div>
        <nav>
            <ul class="flex gap-4">
                <li><a href="">Home</a></li>
                <li><a href="">Events</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </nav>
        <div>Login</div>
    </header>

    <main class="px-8 pt-16">
        <!-- Events Section -->
        <div class="mb-12">
            <h1 class="mb-8 text-3xl font-bold">Upcoming Events</h1>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @if ($events->count() > 0)
                    @foreach ($events as $event)
                        <div class="rounded-lg border bg-white p-6 shadow-md">
                            <h3 class="mb-2 text-xl font-semibold">{{ $event->title }}</h3>
                            <p class="mb-4 text-gray-600">{{ $event->description }}</p>
                            <div class="space-y-1 text-sm">
                                <p><strong>Date:</strong> {{ $event->date }}</p>
                                <p><strong>Time:</strong> {{ $event->time }}</p>
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                                <p><strong>Capacity:</strong> {{ $event->capacity }}</p>
                                <p><strong>Organizer:</strong> {{ $event->organizer->name }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full rounded-lg border bg-white p-6">
                        <p>No events found. Run the EventSeeder!</p>
                        <code class="mt-2 block rounded bg-gray-100 p-2 text-sm">
                            php artisan db:seed --class=EventSeeder
                        </code>
                    </div>
                @endif
            </div>
        </div>

        <!-- Organizers Section -->
        <div class="mb-12">
            <h2 class="mb-6 text-2xl font-bold">Our Organizers</h2>
            <div class="rounded-lg border bg-white p-6 shadow-md">
                @if ($organizers->count() > 0)
                    <ul class="space-y-2">
                        @foreach ($organizers as $organizer)
                            <li class="text-lg">{{ $organizer->name }} - {{ $organizer->email }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">No organizers found. Run the seeder first!</p>
                    <code class="mt-2 block rounded bg-gray-100 p-2 text-sm">
                        php artisan db:seed --class=OrganizerSeeder
                    </code>
                @endif
            </div>
        </div>
    </main>

</body>
