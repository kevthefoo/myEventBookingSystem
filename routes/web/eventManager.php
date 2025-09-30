<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Event;


// event managemet route for only organizers
Route::get("/eventmanager", function () {
    if (!auth()->check()) {
        return redirect("/login");
    }

    if (auth()->user()->role !== "organizer") {
        return redirect("/");
    }
    $events = Event::with("organizer")
        ->where("organizer_id", auth()->id())
        ->orderBy("date", "asc")
        ->paginate(6);
    return view("eventmanager.eventmanager", compact("events"));
});

Route::get("/eventmanager/create", function () {
    if (!auth()->check()) {
        return redirect("/login");
    }

    if (auth()->user()->role !== "organizer") {
        return redirect("/");
    }

    return view("eventmanager.create.create");
});

Route::post("/eventmanager/create", function (Request $request) {
    $validated = $request->validate(
        [
            "title" => "required|string|max:255",
            "description" => "nullable|string",
            "date" => "required|date|after:today",
            "time" => "required|date_format:H:i",
            "location" => "required|string|max:255",
            "capacity" => "required|integer|min:1",
            "categories" => "required|array|min:1",
            "categories.*" => "exists:categories,id",
        ],
        [
            "title.required" => "The title field is required.",
            "date.required" => "The date field is required.",
            "date.date" => "The date field must be a valid date.",
            "date.after" => "The date field must be a date after today.",
            "time.required" => "The time field is required.",
            "time.date_format" => "The time field must be in HH:MM format.",
            "location.required" => "The location field is required.",
            "capacity.required" => "The capacity field is required.",
            "capacity.integer" => "The capacity field must be a number.",
            "capacity.min" => "The capacity field must be at least 1.",
            "categories.required" => "Please select at least one category.",
            "categories.min" => "Please select at least one category.",
        ]
    );

    try {
        // Extract categories from validated data
        $categories = $validated["categories"];
        unset($validated["categories"]); // Remove categories from event data

        // Create the event
        $event = Event::create([
            "uuid" => \Illuminate\Support\Str::uuid(),
            ...$validated,
            "organizer_id" => auth()->id(),
        ]);

        // Attach categories to the event
        $event->categories()->attach($categories);

        return redirect("/eventmanager")->with(
            "success",
            "Event created successfully!"
        );
    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with("error", "Failed to create event. Please try again.");
    }
});

Route::get("/eventmanager/edit/{event}", function (Event $event) {
    if (!auth()->check()) {
        return redirect("/login");
    }

    if (auth()->user()->role !== "organizer") {
        return redirect("/");
    }

    // Check if the organizer owns this event
    // if($event->organizer_id !== auth()->id()){
    //     abort(403, 'You can only edit your own events.');
    // }

    return view("eventmanager.edit.edit", compact("event"));
});

// Update event
Route::put("/eventmanager/edit/{event}", function (
    Request $request,
    Event $event
) {
    // Check if user is authenticated and is an organizer
    if (!auth()->check()) {
        return redirect("/login");
    }

    if (auth()->user()->role !== "organizer") {
        return redirect("/");
    }

    // Check if the organizer owns this event
    if ($event->organizer_id !== auth()->id()) {
        abort(403, "You can only edit your own events.");
    }

    $validated = $request->validate(
        [
            "title" => "required|string|max:100",
            "description" => "nullable|string",
            "date" => "required|date|after:today",
            "time" => "required",
            "location" => "required|string|max:255",
            "capacity" => "required|integer|min:1|max:1000",
            "categories" => "required|array|min:1",
            "categories.*" => "exists:categories,id",
        ],
        [
            "title.required" => "The title field is required.",
            "date.required" => "The date field is required.",
            "date.after" => "The date field must be a date after today.",
            "time.required" => "The time field is required.",
            "time.date_format" => "The time field must be in HH:MM format.",
            "location.required" => "The location field is required.",
            "capacity.required" => "The capacity field is required.",
            "capacity.integer" => "The capacity field must be a number.",
            "capacity.min" => "The capacity field must be at least 1.",
            "capacity.max" =>
                "The capacity field may not be greater than 1000.",
            "categories.required" => "Please select at least one category.",
            "categories.min" => "Please select at least one category.",
            "categories.*.exists" =>
                "One or more selected categories are invalid.",
        ]
    );

    try {
        // Extract categories from validated data
        $categories = $validated["categories"];
        unset($validated["categories"]); // Remove categories from event data

        // Update the event
        $event->update($validated);

        // Sync categories (removes old ones and adds new ones)
        $event->categories()->sync($categories);

        return redirect("/eventmanager")->with(
            "success",
            "Event updated successfully with categories!"
        );
    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with("error", "Failed to update event. Please try again.");
    }
});

// Delete event
Route::delete("/eventmanager/delete/{event}", function (Event $event) {
    // Check if user is authenticated and is an organizer
    if (!auth()->check()) {
        return redirect("/login");
    }

    if (auth()->user()->role !== "organizer") {
        return redirect("/");
    }

    // Check if the organizer owns this event
    if ($event->organizer_id !== auth()->id()) {
        abort(403, "You can only delete your own events.");
    }

    // Check if event has bookings (when you implement booking system)
    if ($event->attendees()->count() > 0) {
        return redirect("/eventmanager")->with(
            "error",
            "Cannot delete event with existing bookings. Please contact attendees first."
        );
    }

    $event->delete();

    return redirect("/eventmanager")->with(
        "success",
        "Event deleted successfully!"
    );
});