<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the organizer's admin dashboard with event analytics such as total events and total bookings.
     * Also provide event details such as title, date, capacity and remaining spots
     * Only Organizers can access this dashboard.
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse 
     */
    public function dashboard()
    {
        // Check if the user is logged in, if not, redirect to login page
        if (!auth()->check()) {
            return redirect("/login");
        }

        // Check if the user is an organizer, if not, redirect to home page
        if (auth()->user()->role !== "organizer") {
            return redirect("/");
        }
        
        // Get the organizer ID
        $organizerId = auth()->id();

        // Get events details using Raw SQL
        $eventsDetails = DB::select(
            "
            SELECT 
                e.id,
                e.uuid,
                e.title,
                e.description,
                e.date,
                e.time,
                e.location,
                e.capacity,
                COALESCE(a.bookings_count, 0) AS current_bookings,
                (e.capacity - COALESCE(a.bookings_count, 0)) AS remaining_spots
            FROM events e
            LEFT JOIN (
                SELECT event_id, COUNT(*) AS bookings_count
                FROM event_attendees
                GROUP BY event_id
            ) a ON a.event_id = e.id
            WHERE e.organizer_id = ?
            ORDER BY e.date ASC
            ",
            [$organizerId]
        );

        // Get summary statistics using Raw SQL
        $summaryStats = DB::select(
            "
            SELECT 
                COUNT(e.id) as total_events,
                SUM(e.capacity) as total_capacity,
                0 as total_bookings,
                COUNT(CASE WHEN e.date >= DATE('now') THEN 1 END) as upcoming_events
            FROM events e
            WHERE e.organizer_id = ?
        ",
            [$organizerId]
        );

        // Convert the data to an array for easier access on the frontend
        $summaryStats = [
            "total_events" => $summaryStats[0]->total_events ?? 0,
            "total_capacity" => $summaryStats[0]->total_capacity ?? 0,
            "total_bookings" => $summaryStats[0]->total_bookings ?? 0,
            "upcoming_events" => $summaryStats[0]->upcoming_events ?? 0,
        ];

        return view(
            "admindashboard.dashboard",
            compact("eventsDetails", "summaryStats")
        );
    }
}