<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;

// home route
Route::get("/", function () {
    $organizers = User::where("role", "organizer")->get();
    $events = Event::with(["organizer", "categories"])
        ->orderBy("date", "asc")
        ->paginate(6);
    $categories = Category::active()->get();
    return view("home", compact("organizers", "events", "categories"));
});



// event details route
Route::get("/events/{event}", function (Event $event) {
    // Laravel will automatically find the event by UUID
    return view("event-details", compact("event"));
});





