<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Event;

Route::get('/', function () {
    
    $organizers = User::where('role', 'organizer')->get();
    $events = Event::with('organizer')->paginate(8);;

    // Pass organizers to the welcome view
    return view('welcome', compact('organizers', 'events'));
});