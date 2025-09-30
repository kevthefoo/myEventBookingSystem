<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;

// Home Page: Display all upcoming events with 6 events maximum per page
Route::get("/", function () {
    $organizers = User::where("role", "organizer")->get();
    $events = Event::with(["organizer", "categories"])
        ->orderBy("date", "asc")
        ->paginate(6);
    $categories = Category::active()->get();
    return view("home", compact("organizers", "events", "categories"));
});

// Event Details Page: Display a single event with its information
Route::get("/events/{event}", function (Event $event) {
    // Laravel will automatically find the event by UUID
    return view("event-details", compact("event"));
});
