<?php

use Illuminate\Support\Facades\Route;

Route::get("/profile", function () {
    // Ensure the user is authenticated
    if (!auth()->check()) {
        return redirect('/login');
    }

    $user = auth()->user();
 

    return view("profile.profile", ["user" => $user]);
});