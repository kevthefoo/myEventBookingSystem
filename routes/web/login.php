<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// login route
Route::get("/login", function () {
    return view("auth.login");
});

Route::post("/login", function (Request $request) {
    // Validate the form data
    $credentials = $request->validate([
        "email" => "required|email",
        "password" => "required|min:6",
    ]);

    // Attempt to authenticate the user
    if (Auth::attempt($credentials, $request->boolean("remember"))) {
        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        // Redirect to intended page or home
        return redirect()->intended("/");
    }

    // Authentication failed - redirect back with error
    return back()
        ->withErrors([
            "email" => "The provided credentials do not match our records.",
        ])
        ->onlyInput("email");
});
