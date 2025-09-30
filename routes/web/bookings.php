<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\Event;
use App\Http\Controllers\BookingController;

// My Bookings Page: Display user's bookings
Route::get("/mybookings", function () {
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
});

// Make a booking
Route::post("/events/{event}/book", [BookingController::class, "store"]);

// Cancel a booking
Route::delete("/events/{event}/cancel", function (Event $event) {
    if (!auth()->check()) {
        return redirect("/login")->with(
            "error",
            "Please log in to cancel bookings."
        );
    }

    $deleted = DB::table("event_attendees")
        ->where("event_id", $event->id)
        ->where("user_id", auth()->id())
        ->delete();

    if ($deleted) {
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
});

