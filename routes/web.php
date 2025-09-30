<?php

require __DIR__ . "/web/bookings.php";
require __DIR__ . "/web/login.php";
require __DIR__ . "/web/logout.php";
require __DIR__ . "/web/register.php";
require __DIR__ . "/web/eventManager.php";
require __DIR__ . "/web/organizerDashboard.php";


 


use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
 



use App\Models\User;
use App\Models\Event;
use App\Models\Category;

// home route
Route::get("/", function () {
    $organizers = User::where("role", "organizer")->get();
    $events = Event::with(["organizer", "categories"])
        ->orderBy("date", "asc")
        ->paginate(6);
    $categories = Category::active()->get();
    return view("home", compact("organizers", "events", "categories"));
});

Route::get("/api/events/filter", function (Request $request) {
    $query = Event::with(["organizer", "categories"]);

    // Filter by categories only
    if ($request->filled("categories")) {
        $categoryIds = $request->categories;
        $query->whereHas("categories", function ($q) use ($categoryIds) {
            $q->whereIn("categories.id", $categoryIds);
        });
    }

    // Always show upcoming events
    $query->where("date", ">=", now());

    $events = $query->orderBy("date", "asc")->paginate(6);

    return response()->json([
        "events" => $events->items(),
        "pagination" => [
            "current_page" => $events->currentPage(),
            "last_page" => $events->lastPage(),
            "total" => $events->total(),
            "per_page" => $events->perPage(),
        ],
    ]);
});

// event details route
Route::get("/events/{event}", function (Event $event) {
    // Laravel will automatically find the event by UUID
    return view("event-details", compact("event"));
});




Route::post("/addcategory", function (Request $request) {
    // Check if user is logged in and is organizer
    if (!auth()->check()) {
        return redirect("/login");
    }

    if (auth()->user()->role !== "organizer") {
        return redirect("/");
    }

    // Validate input
    $validated = $request->validate([
        "name" => "required|string|max:255|unique:categories",
        "slug" => "required|string|max:10",
        "color" => "required|string|max:7",
        "icon" => "required|string|size:1",
        "description" => "nullable|string",
    ]);

    // // Create category
    $category = Category::create([
        "name" => $validated["name"],
        "slug" => $validated["slug"],
        "color" => $validated["color"],
        "icon" => $validated["icon"],
        "description" => $validated["description"],
        "is_active" => true,
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
        "success" => true,
        "message" => "Category created successfully!",
        "category" => [
            "id" => $category->id,
            "name" => $category->name,
            "slug" => $category->slug,
            "color" => $category->color,
            "icon" => $category->icon,
            "description" => $category->description,
        ],
    ]);
});

