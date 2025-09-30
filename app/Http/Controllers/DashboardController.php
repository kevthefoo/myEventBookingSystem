<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Check if the user is logged in
        if (!auth()->check()) {
            return redirect("/login");
        }

        // Check if the user is an organizer
        if (auth()->user()->role !== "organizer") {
            return redirect("/");
        }
        
        // Get the organizer ID
        $organizerId = auth()->id();

        // Raw SQL Query for Events Report (without bookings for now)
        $eventsReport = DB::select(
            "
            SELECT 
                e.uuid,
                e.title,
                e.description,
                e.date,
                e.time,
                e.location,
                e.capacity,
                0 as current_bookings,
                e.capacity as remaining_spots
            FROM events e
            WHERE e.organizer_id = ?
            ORDER BY e.date ASC
        ",
            [$organizerId]
        );

        // Summary Statistics using Raw SQL (SQLite compatible)
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
            compact("eventsReport", "summaryStats")
        );
    }
}