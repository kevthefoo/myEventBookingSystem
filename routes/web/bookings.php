<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\BookingController;

// My Bookings Page: Display user's bookings
Route::get("/mybookings", [BookingController::class, "all"]);

// Make a booking
Route::post("/events/{event}/book", [BookingController::class, "store"]);

// Cancel a booking
Route::delete("/events/{event}/cancel", [BookingController::class, "delete"]);


