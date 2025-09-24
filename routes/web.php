<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Event;

// home page
Route::get('/', function () {
    $organizers = User::where('role', 'organizer')->get();
    $events = Event::with('organizer')->paginate(8);

    return view('welcome', compact('organizers', 'events'));
});

// login page
Route::get('/login', function(){
    return('login page') ;
});

// register page
Route::get('/register', function(){
    return('login page') ;
});

// event details page
Route::get('/events/{event}', function(Event $event){
    // Laravel will automatically find the event by UUID
    return view('event-details', compact('event'));
});