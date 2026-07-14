<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\BoatController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\AvailabilityController;
use App\Models\Boat;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
})->name("welcome");

// Customer dashboard — browse all boats
Route::get("/dashboard", function () {
    $query = Boat::withCount("reviews")
        ->withAvg("reviews", "rating")
        ->where("status", "active");

    if (request()->has("search") && request()->search) {
        $q = request()->search;
        $query->where(function ($q2) use ($q) {
            $q2->where("name", "like", "%{$q}%")
                ->orWhere("type", "like", "%{$q}%")
                ->orWhere("location", "like", "%{$q}%");
        });
    }

    if (request()->has("location") && request()->location) {
        $query->where("location", request()->location);
    }

    $boats = $query->orderBy("reviews_avg_rating", "desc")->get();

    $locations = Boat::where("status", "active")
        ->whereNotNull("location")
        ->distinct()
        ->pluck("location")
        ->filter()
        ->values();

    return view("dashboard", compact("boats", "locations"));
})
    ->middleware("auth")
    ->name("dashboard");

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::delete("/profile", [ProfileController::class, "destroy"])->name("profile.destroy");
});

// Owner routes
Route::middleware(["auth", "owner"])
    ->prefix("owner")
    ->name("owner.")
    ->group(function () {
        Route::get("/dashboard", [OwnerController::class, "dashboard"])->name("dashboard");
        Route::get("/bookings", [OwnerController::class, "manageBookings"])->name("bookings");
        Route::patch("/bookings/{booking}", [OwnerController::class, "updateBookingStatus"])->name("bookings.update");
        Route::resource("boats", BoatController::class);
        Route::resource("availability", AvailabilityController::class);
    });

// Public boat pages + booking
Route::middleware(["auth", "verified"])->group(function () {
    Route::get("/boats/{boat}", [BoatController::class, "detail"])->name("boats.show");
    Route::post("/boats/{boat}/book", [BoatController::class, "book"])->name("bookings.store");
    Route::post("/boats/{boat}/reviews", [BoatController::class, "review"])->name("reviews.store");
    Route::get("/boats/{boat}/bookings", [BoatController::class, "manageBookings"])->name("boats.bookings");
    Route::patch("/boats/{boat}/bookings/{booking}", [BoatController::class, "updateBookingStatus"])->name("boats.bookings.update");
});

require __DIR__ . "/auth.php";
