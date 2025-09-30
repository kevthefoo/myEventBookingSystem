<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Event;

class EventController extends Controller
{
    public function show(string $uuid)
    {
        $event = Event::where('uuid', $uuid)->firstOrFail();

        // Manual counts using the event_attendees table
        $currentBookings = DB::table('event_attendees')
            ->where('event_id', $event->id)
            ->count();

        $remainingSpots = max(0, $event->capacity - $currentBookings);

        $isUserBooked = auth()->check()
            ? DB::table('event_attendees')
                ->where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->exists()
            : false;

        return view('event-details', compact(
            'event',
            'currentBookings',
            'remainingSpots',
            'isUserBooked'
        ));
    }
}