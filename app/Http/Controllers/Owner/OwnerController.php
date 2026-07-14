<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Boat;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $boats = $user->boats()->where('status', 'active')->get();

        $bookings = Booking::whereIn('boat_id', $boats->pluck('id'))
            ->with('boat')
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'total_boats' => $boats->count(),
            'total_bookings' => $bookings->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'rejected' => $bookings->where('status', 'rejected')->count(),
        ];

        return view('owner.dashboard', compact('boats', 'bookings', 'stats'));
    }

    public function manageBookings()
    {
        $user = auth()->user();
        $bookings = Booking::whereIn('boat_id', $user->boats()->pluck('id'))
            ->with('boat')
            ->orderByDesc('created_at')
            ->get();

        return view('owner.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $user = auth()->user();
        $boat = $booking->boat;

        if ($boat->owner_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,rejected,cancelled',
        ]);

        $booking->update($validated);

        return back()->with('success', "Booking {$validated['status']} successfully.");
    }
}
