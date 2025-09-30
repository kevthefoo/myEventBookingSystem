<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Event;

class EventController extends Controller
{
    public function show(string $uuid)
    {
        $event = Event::where('uuid', $uuid)->firstOrFail();

        $currentBookings = $event->bookings()->count();

        $remainingSpots = max(0, $event->capacity - $currentBookings);

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