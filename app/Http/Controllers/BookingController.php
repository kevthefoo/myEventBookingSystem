<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request, Event $event)
    {   
        // Check if the user is logged in
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Please log in to book events.');
        }

        // Check if user is the event organizer (they can't book their own event)
        if (auth()->id() === $event->organizer_id) {
            return redirect("/events/{$event->uuid}")->with('error', 'You cannot book your own event.');
        }

        // Count bookings
        $currentBookings = $event->bookings()->count();

        if ($currentBookings >= $event->capacity) {
            return redirect("/events/{$event->uuid}")->with('error', 'Sorry, this event is fully booked. No more spots available.');
        }

        // Check if user already booked this event
        $existingBooking = $event->bookings()->where('user_id', auth()->id())->first();


        if ($existingBooking) {
            return redirect("/events/{$event->uuid}")->with('error', 'You have already booked this event.');
        }

        // Check if event is in the past
        if ($event->date < now()->toDateString()) {
            return redirect("/events/{$event->uuid}")->with('error', 'Cannot book past events.');
        }

        // Create booking
        $event->bookings()->create([
            'user_id' => auth()->id(),
        ]);

        return redirect("/events/{$event->uuid}")->with('success', 'You have successfully booked this event!');
    }
}