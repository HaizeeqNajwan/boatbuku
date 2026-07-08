<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\BoatController; // 👈 new
use App\Http\Controllers\Owner\OwnerController; // 👈 new
use Illuminate\Support\Facades\Route;
use App\Models\Boat;

Route::get("/", function () {
    return view("welcome");
});

Route::get("/dashboard", function () {
    $boats = Boat::withCount("reviews")->withAvg("reviews", "rating")->get();

    return view("dashboard", compact("boats"));
})
    ->middleware(["auth", "verified"])
    ->name("dashboard");

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );
});

// 👇 New owner routes
Route::middleware(["auth", "owner"])
    ->prefix("owner")
    ->name("owner.")
    ->group(function () {
        Route::get("/dashboard", [OwnerController::class, "dashboard"])->name(
            "dashboard",
        );
        Route::resource("boats", BoatController::class);
    });

Route::middleware(["auth", "verified"])->group(function () {
    Route::get("/boats/{boat}", [BoatController::class, "show"])->name(
        "boats.show",
    );
    Route::post("/boats/{boat}/book", [BoatController::class, "book"])->name(
        "bookings.store",
    );
    Route::post("/boats/{boat}/reviews", [
        BoatController::class,
        "review",
    ])->name("reviews.store");
});

require __DIR__ . "/auth.php";
