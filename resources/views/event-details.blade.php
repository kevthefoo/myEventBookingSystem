<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 p-8">

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        
        <!-- Back Button -->
        <a href="/" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            ← Back to Events
        </a>

        <!-- Event Title -->
        <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>

        <!-- Event Description -->
        <p class="text-gray-700 mb-6">{{ $event->description }}</p>

        <!-- Event Details -->
        <div class="space-y-3">
            <div><strong>Date:</strong> {{ $event->date }}</div>
            <div><strong>Time:</strong> {{ $event->time }}</div>
            <div><strong>Location:</strong> {{ $event->location }}</div>
            <div><strong>Capacity:</strong> {{ $event->capacity }} people</div>
            <div><strong>Organizer:</strong> {{ $event->organizer->name }}</div>
        </div>

        <!-- Action Button -->
        <div class="mt-8">
            <button class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Book This Event
            </button>
        </div>

    </div>

</body>
</html>