<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Booking;

class BookingController extends Controller
{
    public function all(Request $request, Event $event){
       
            if (!auth()->check()) {
                return redirect("/login");
            }

            try {
                // Get user's bookings with event details using raw SQL
                $myBookings = DB::select(
                    "
                        SELECT 
                            e.uuid,
                            e.title,
                            e.description,
                            e.date,
                            e.time,
                            e.location,
                            e.capacity,
                            ea.created_at as booked_at,
                            (u.first_name || ' ' || u.last_name) as organizer_name
                        FROM event_attendees ea
                        INNER JOIN events e ON ea.event_id = e.id
                        INNER JOIN users u ON e.organizer_id = u.id
                        WHERE ea.user_id = ?
                        ORDER BY e.date ASC
                    ",
                    [auth()->id()]
                );
            } catch (\Exception $e) {
                // Handle case where event_attendees table doesn't exist yet
                $myBookings = [];
            }
            return view("mybookings", compact("myBookings"));
    }
    


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

    public function delete(Request $request, Event $event)
    {
        if (!auth()->check()) {
            return redirect("/login")->with(
                "error",
                "Please log in to cancel bookings."
            );
        }

        // Find the booking using Eloquent
        $booking = Booking::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->first();

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