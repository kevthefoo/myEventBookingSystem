<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User;
use App\Models\Event;

// home route
Route::get('/', function () {
    $organizers = User::where('role', 'organizer')->get();
    $events = Event::with('organizer')->paginate(8);

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

// event managemet route for only organizers
Route::get('/eventmanager', function(){
    if(!auth()->check()){
        return redirect('/login');
    }

    if(auth()->user()->role !== 'organizer'){
        return redirect('/');
    }

    return view('eventmanager.eventmanager') ;
});