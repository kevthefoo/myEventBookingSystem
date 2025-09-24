<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    // Get all organizers from the database
    $organizers = User::where('role', 'organizer')->get();
    
    // Pass organizers to the welcome view
    return view('welcome', compact('organizers'));
});