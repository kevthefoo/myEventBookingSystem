<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventDetailsController extends Controller
{
    /**
     * Display detailed information for a specific event.
     * Provides book or cancellation functionalities if it is available
     * Provides booking analytics such as current bookings and remaining spots.
     * @param string $uuid Unique identifier for the event to ensure URL security and predictability
     * @return \Illuminate\View\View
     */
    public function show(string $uuid)
    {
        // Fetch the event details by UUID, if not found, throw a 404 error
        $event = Event::where('uuid', $uuid)->firstOrFail();

        // Calculate current bookings
        $currentBookings = $event->bookings()->count();

        // Calculate remaining spots
        $remainingSpots = max(0, $event->capacity - $currentBookings);

        // Check if the attendee has already booked this event
        $isUserBooked = auth()->check()
            ? $event->bookings()->where('user_id', auth()->id())->exists()
            : false;

        return view('event-details', compact(
            'event',
            'currentBookings',
            'remainingSpots',
            'isUserBooked'
        ));
    }
}