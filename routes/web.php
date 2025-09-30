<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;

// home route
Route::get('/', function () {
    $organizers = User::where('role', 'organizer')->get();
    $events = Event::with(['organizer', 'categories'])->orderBy('date', 'asc')->paginate(6);
     $categories = Category::active()->get();
    return view('home', compact('organizers', 'events', 'categories')); 
});

Route::get('/api/events/filter', function (Request $request) {
    $query = Event::with(['organizer', 'categories']);
    
    // Filter by categories only
    if ($request->filled('categories')) {
        $categoryIds = $request->categories;
        $query->whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        });
    }
    
    // Always show upcoming events
    $query->where('date', '>=', now());
    
    $events = $query->orderBy('date', 'asc')->paginate(6);
    
    return response()->json([
        'events' => $events->items(),
        'pagination' => [
            'current_page' => $events->currentPage(),
            'last_page' => $events->lastPage(),
            'total' => $events->total(),
            'per_page' => $events->perPage(),
        ]
    ]);
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
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'privacy_policy_accepted' => 'required|accepted',
    ]);

    $user = User::create([
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
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
    $events = Event::with('organizer')->where('organizer_id', auth()->id())->orderBy('date', 'asc')->paginate(6);
    return view('eventmanager.eventmanager', compact('events')) ;
});

Route::get('/eventmanager/create', function(){
    if(!auth()->check()){
        return redirect('/login');
    }

    if(auth()->user()->role !== 'organizer'){
        return redirect('/');
    }

    return view('eventmanager.create.create');
});

Route::post('/eventmanager/create', function(Request $request){
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date|after:today',
        'time' => 'required|date_format:H:i', 
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'categories' => 'required|array|min:1',
        'categories.*' => 'exists:categories,id'
    ], [
        'title.required' => 'The title field is required.',
        'date.required' => 'The date field is required.',
        'date.date' => 'The date field must be a valid date.',
        'date.after' => 'The date field must be a date after today.',
        'time.required' => 'The time field is required.',
        'time.date_format' => 'The time field must be in HH:MM format.',
        'location.required' => 'The location field is required.',
        'capacity.required' => 'The capacity field is required.',
        'capacity.integer' => 'The capacity field must be a number.',
        'capacity.min' => 'The capacity field must be at least 1.',
        'categories.required' => 'Please select at least one category.',
        'categories.min' => 'Please select at least one category.',
    ]);

    try {
        // Extract categories from validated data
        $categories = $validated['categories'];
        unset($validated['categories']); // Remove categories from event data

        // Create the event
        $event = Event::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            ...$validated,
            'organizer_id' => auth()->id(),
        ]);

        // Attach categories to the event
        $event->categories()->attach($categories);

        return redirect('/eventmanager')->with('success', 'Event created successfully!');
        
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Failed to create event. Please try again.');
    }
});






Route::get('/eventmanager/edit/{event}', function(Event $event){
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
    if($event->organizer_id !== auth()->id()){
        abort(403, 'You can only edit your own events.');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:100',
        'description' => 'nullable|string',
        'date' => 'required|date|after:today',
        'time' => 'required',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1|max:1000',
        'categories' => 'required|array|min:1',
        'categories.*' => 'exists:categories,id'
    ], [
        'title.required' => 'The title field is required.',
        'date.required' => 'The date field is required.',
        'date.after' => 'The date field must be a date after today.',
        'time.required' => 'The time field is required.',
        'time.date_format' => 'The time field must be in HH:MM format.',
        'location.required' => 'The location field is required.',
        'capacity.required' => 'The capacity field is required.',
        'capacity.integer' => 'The capacity field must be a number.',
        'capacity.min' => 'The capacity field must be at least 1.',
        'capacity.max' => 'The capacity field may not be greater than 1000.',
        'categories.required' => 'Please select at least one category.',
        'categories.min' => 'Please select at least one category.',
        'categories.*.exists' => 'One or more selected categories are invalid.',
    ]);

    try {
        // Extract categories from validated data
        $categories = $validated['categories'];
        unset($validated['categories']); // Remove categories from event data

        // Update the event
        $event->update($validated);

        // Sync categories (removes old ones and adds new ones)
        $event->categories()->sync($categories);

        return redirect('/eventmanager')->with('success', 'Event updated successfully with categories!');
        
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Failed to update event. Please try again.');
    }

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
    if($event->organizer_id !== auth()->id()){
        abort(403, 'You can only delete your own events.');
    }

    // Check if event has bookings (when you implement booking system)
    if ($event->attendees()->count() > 0) {
        return redirect('/eventmanager')->with('error', 'Cannot delete event with existing bookings. Please contact attendees first.');
    }

    $event->delete();

    return redirect('/eventmanager')->with('success', 'Event deleted successfully!');
});



Route::get('/admin/dashboard', function(){
    // Check if user is authenticated and is an organizer
    if(!auth()->check()){
        return redirect('/login');
    }

    if(auth()->user()->role !== 'organizer'){
        return redirect('/');
    }

    $organizerId = auth()->id();

    // Raw SQL Query for Events Report (without bookings for now)
    $eventsReport = DB::select("
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
    ", [$organizerId]);

    // Summary Statistics using Raw SQL (SQLite compatible)
    $summaryStats = DB::select("
        SELECT 
            COUNT(e.id) as total_events,
            SUM(e.capacity) as total_capacity,
            0 as total_bookings,
            COUNT(CASE WHEN e.date >= DATE('now') THEN 1 END) as upcoming_events
        FROM events e
        WHERE e.organizer_id = ?
    ", [$organizerId]);

    // Convert to array for easier access
    $summaryStats = [
        'total_events' => $summaryStats[0]->total_events ?? 0,
        'total_capacity' => $summaryStats[0]->total_capacity ?? 0,
        'total_bookings' => $summaryStats[0]->total_bookings ?? 0,
        'upcoming_events' => $summaryStats[0]->upcoming_events ?? 0,
    ];

    return view('admindashboard.dashboard', compact('eventsReport', 'summaryStats'));
});

// Book an event
Route::post('/events/{event}/book', function(Request $request, Event $event) {
    // Manual authentication check
    if (!auth()->check()) {
        return redirect('/login')->with('error', 'Please log in to book events.');
    }

    // Check if user is the event organizer (they can't book their own event)
    if (auth()->id() === $event->organizer_id) {
        return redirect("/events/{$event->uuid}")->with('error', 'You cannot book your own event.');
    }


    // Manual validation - Check if event is full (REQUIRED MANUAL VALIDATION)
    $currentBookings = DB::table('event_attendees')
                        ->where('event_id', $event->id)
                        ->count();

    if ($currentBookings >= $event->capacity) {
        return redirect("/events/{$event->uuid}")->with('error', 'Sorry, this event is fully booked. No more spots available.');
    }

    // Check if user already booked this event
    $existingBooking = DB::table('event_attendees')
                        ->where('event_id', $event->id)
                        ->where('user_id', auth()->id())
                        ->first();

    if ($existingBooking) {
        return redirect("/events/{$event->uuid}")->with('error', 'You have already booked this event.');
    }

    // Check if event is in the past
    if ($event->date < now()->toDateString()) {
        return redirect("/events/{$event->uuid}")->with('error', 'Cannot book past events.');
    }

    // All validations passed - Create the booking
    DB::table('event_attendees')->insert([
        'event_id' => $event->id,
        'user_id' => auth()->id(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

return redirect("/events/{$event->uuid}")->with('success', 'You have successfully booked this event!');});

// Cancel booking
Route::delete('/events/{event}/cancel', function(Event $event) {
    if (!auth()->check()) {
        return redirect('/login')->with('error', 'Please log in to cancel bookings.');
    }

    $deleted = DB::table('event_attendees')
                ->where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->delete();

    if ($deleted) {
        return redirect("/events/{$event->uuid}")->with('success', 'Booking cancelled successfully.');
    } else {
        return redirect("/events/{$event->uuid}")->with('error', 'No booking found to cancel.');
    }
});


Route::get('/mybookings', function() {
    if (!auth()->check()) {
        return redirect('/login');
    }


        try {
        // Get user's bookings with event details using raw SQL
            $myBookings = DB::select("
                SELECT 
                    e.uuid,
                    e.title,
                    e.description,
                    e.date,
                    e.time,
                    e.location,
                    e.capacity,
                    ea.created_at as booked_at,
                    (u.first_name || ' ' || u.last_name) as organizer_name
                FROM event_attendees ea
                INNER JOIN events e ON ea.event_id = e.id
                INNER JOIN users u ON e.organizer_id = u.id
                WHERE ea.user_id = ?
                ORDER BY e.date ASC
            ", [auth()->id()]);


    } catch (\Exception $e) {
        // Handle case where event_attendees table doesn't exist yet
        $myBookings = [];
    }
    return view('mybookings', compact('myBookings'));
});

Route::post('/addcategory', function(Request $request) {
    // Check if user is logged in and is organizer
    if (!auth()->check()) {
        return redirect('/login');
    }

    if(auth()->user()->role !== 'organizer'){
        return redirect('/');
    }

    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:categories',
        'slug' => 'required|string|max:10',
        'color' => 'required|string|max:7',
        'icon' => 'required|string|size:1',
        'description' => 'nullable|string'
    ]);
    
    // // Create category
    $category = Category::create([
        'name' => $validated['name'],
        'slug' => $validated['slug'],
        'color' => $validated['color'],
        'icon' => $validated['icon'],
        'description' =>$validated['description'],
        'is_active' => true
    ]);

    // Category::create([
    //     'name' => 'Test',
    //     'slug' => 'test',
    //     'color' => '#3B82F6',
    //     'icon' => '🏀',
    //     'description' =>'This is a test category',
    //     'is_active' => true
    // ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Category created successfully!',
        'category' => [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'color' => $category->color,
            'icon' => $category->icon,
            'description' => $category->description
        ]
    ]);});


Route::get('/test', function() {return view('test');});