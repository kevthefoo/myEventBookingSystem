<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Event;

// home route
Route::get('/', function () {
    $organizers = User::where('role', 'organizer')->get();
    $events = Event::with('organizer')->orderBy('date', 'asc')->paginate(8);

    return view('welcome', compact('organizers', 'events'));
});

// login route
Route::get('/login', function(){
    return view('auth.login');
});

Route::post('/login', function(Request $request){
    // Validate the form data
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Attempt to authenticate the user
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        // Redirect to intended page or home
        return redirect()->intended('/');
    }

    // Authentication failed - redirect back with error
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});

// logout route
Route::post('/logout', function(Request $request){
    Auth::logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect('/');
});


// register route
Route::get('/register', function(){
    return view('auth.register');
});

Route::post('/register', function(Request $request){
    // Registration logic will go here
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        // 'role' => 'required|in:user,organizer',
        'privacy_policy_accepted' => 'required|accepted',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'Attendee',
        'privacy_policy_accepted' => true,
        'privacy_policy_accepted_at' => now(),
    ]);

    // Log the user in automatically
    Auth::login($user);

    return redirect('/')->with('success', 'Account created successfully!');
});

// event details route
Route::get('/events/{event}', function(Event $event){
    // Laravel will automatically find the event by UUID
    return view('event-details', compact('event'));
});




// Route for CRUD

// event managemet route for only organizers
Route::get('/eventmanager', function(){
    if(!auth()->check()){
        return redirect('/login');
    }

    if(auth()->user()->role !== 'organizer'){
        return redirect('/');
    }
    $events = Event::with('organizer')->orderBy('date', 'asc')->paginate(8);
    return view('eventmanager.eventmanager', compact('events')) ;
});

// Store new event
Route::post('/eventmanager/create', function(Request $request){
    $validated = $request->validate([
        'title' => 'required|string|max:100',
        'description' => 'nullable|string',
        'date' => 'required|date|after:today',
        'time' => 'required',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1|max:1000',
    ]);

        Event::create([
            ...$validated,
            'organizer_id' => auth()->id(),
        ]);

        return redirect('/eventmanager')->with('success', 'Event created successfully!');
    })->name('events.store');

Route::get('/eventmanager/create', function(){
    return view('eventmanager.create.create');
});




Route::get('/eventmanager/edit/{event}', function(Event $event){
    // Check if user is authenticated and is an organizer
    if(!auth()->check()){
        return redirect('/login');
    }

    if(auth()->user()->role !== 'organizer'){
        return redirect('/');
    }

    // Check if the organizer owns this event
    // if($event->organizer_id !== auth()->id()){
    //     abort(403, 'You can only edit your own events.');
    // }

    return view('eventmanager.edit.edit', compact('event'));
});

// Update event
Route::put('/eventmanager/edit/{event}', function(Request $request, Event $event){
    // Check if user is authenticated and is an organizer
    if(!auth()->check()){
        return redirect('/login');
    }

    if(auth()->user()->role !== 'organizer'){
        return redirect('/');
    }

    // Check if the organizer owns this event
    // if($event->organizer_id !== auth()->id()){
    //     abort(403, 'You can only edit your own events.');
    // }

    $validated = $request->validate([
        'title' => 'required|string|max:100',
        'description' => 'nullable|string',
        'date' => 'required|date|after:today',
        'time' => 'required',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1|max:1000',
    ]);

    $event->update($validated);

    return redirect('/eventmanager')->with('success', 'Event updated successfully!');
});

// Delete event
Route::delete('/eventmanager/delete/{event}', function(Event $event){
    // Check if user is authenticated and is an organizer
    if(!auth()->check()){
        return redirect('/login');
    }

    if(auth()->user()->role !== 'organizer'){
        return redirect('/');
    }

    // Check if the organizer owns this event
    // if($event->organizer_id !== auth()->id()){
    //     abort(403, 'You can only delete your own events.');
    // }

    // Check if event has bookings (when you implement booking system)
    // if ($event->attendees()->count() > 0) {
    //     return redirect('/eventmanager')->with('error', 'Cannot delete event with existing bookings. Please contact attendees first.');
    // }

    $event->delete();

    return redirect('/eventmanager')->with('success', 'Event deleted successfully!');
});