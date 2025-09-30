<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;

// register route
Route::get("/register", function () {
    return view("auth.register");
});

Route::post("/register", function (Request $request) {
    // Registration logic will go here
    $validated = $request->validate([
        "first_name" => "required|string|max:255",
        "last_name" => "required|string|max:255",
        "email" => "required|string|email|max:255|unique:users",
        "password" => "required|string|min:6|confirmed",
        "privacy_policy_accepted" => "required|accepted",
    ]);

    $user = User::create([
        "first_name" => $validated["first_name"],
        "last_name" => $validated["last_name"],
        "email" => $validated["email"],
        "password" => Hash::make($validated["password"]),
        "role" => "Attendee",
        "privacy_policy_accepted" => true,
        "privacy_policy_accepted_at" => now(),
    ]);

    // Log the user in automatically
    Auth::login($user);

    return redirect("/")->with("success", "Account created successfully!");
});