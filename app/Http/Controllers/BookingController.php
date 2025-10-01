<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Retrieve all bookings made by the attendee
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Event $event
     * @return \Illuminate\Contracts\View\View | \Illuminate\Http\RedirectResponse
     */
    public function all(Request $request, Event $event)
    {   
        // Check the user is logged in or not, if not, redirect to the login page
        if (!auth()->check()) {
            return redirect("/login");
        }

        // Fetch all bookings for the attendee with event details
        $myBookings = Booking::with(["event.organizer"])
            ->where("user_id", auth()->id())
            ->orderByDesc("created_at")
            ->get();

        return view("mybookings.mybookings", compact("myBookings"));
    }


    /**
     * Create a new booking for an event with comprehensive validation.
     * Business rules including:
     * 1. Capacity limits (Can't book a full event)
     * 2. Organizer restrictions (The creator can't book their own event)
     * 3. Duplicate booking prevention (Can't book the same event multiple times)
     * 4. Past event booking prevention (Can't book past events)
     * @param Event $event Target event for booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Event $event)
    {
        // Check if the user is logged in, if not, redirect to login page
        if (!auth()->check()) {
            return redirect("/login")->with(
                "error",
                "Please log in to book events."
            );
        }

        // Check if user is the event organizer (they can't book their own event), if so, redirect with error
        if (auth()->id() === $event->organizer_id) {
            return redirect("/events/{$event->uuid}")->with(
                "error",
                "You cannot book your own event."
            );
        }

        // Count current bookings of the event
        $currentBookings = $event->bookings()->count();

        // Check if the capacity of the event is full or not, if full, redirect with error 
        if ($currentBookings >= $event->capacity) {
            return redirect("/events/{$event->uuid}")->with(
                "error",
                "Sorry, this event is fully booked. No more spots available."
            );
        }

        $existingBooking = $event
            ->bookings()
            ->where("user_id", auth()->id())
            ->first();

        // Check if user already booked this event, if so, redirect with error
        if ($existingBooking) {
            return redirect("/events/{$event->uuid}")->with(
                "error",
                "You have already booked this event."
            );
        }

        // Check if event is in the past, if so, redirect with error
        if ($event->date < now()->toDateString()) {
            return redirect("/events/{$event->uuid}")->with(
                "error",
                "Cannot book past events."
            );
        }

        // Create booking
        $event->bookings()->create([
            "user_id" => auth()->id(),
        ]);

        return redirect("/events/{$event->uuid}")->with(
            "success",
            "You have successfully booked this event!"
        );
    }

    /**
     * Cancel an existing booking for the attendee.
     * @param Event $event Target event for cancellation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Event $event)
    {
        if (!auth()->check()) {
            return redirect("/login")->with(
                "error",
                "Please log in to cancel bookings."
            );
        }

        // Find the target booking
        $booking = Booking::where("event_id", $event->id)
            ->where("user_id", auth()->id())
            ->first();

        // If booking exists, delete it and redirect with success message
        if ($booking) {
            $booking->delete();
            return redirect("/events/{$event->uuid}")->with(
                "success",
                "Booking cancelled successfully."
            );
        } else {
            return redirect("/events/{$event->uuid}")->with(
                "error",
                "No booking found to cancel."
            );
        }
    }
}
