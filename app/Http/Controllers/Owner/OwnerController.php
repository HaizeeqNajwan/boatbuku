<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $boats = $user->boats;
        // Get all bookings for the owner's boats
        $bookings = $user
            ->boats()
            ->with("bookings")
            ->get()
            ->pluck("bookings")
            ->flatten()
            ->sortByDesc("created_at");

        return view("owner.dashboard", compact("boats", "bookings"));
    }
}
