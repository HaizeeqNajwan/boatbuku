<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class BoatController extends Controller
{
    // Owner boat management
    public function index()
    {
        $boats = auth()->user()->boats()->orderBy('created_at', 'desc')->get();
        return view('owner.boats.index', compact('boats'));
    }

    public function create()
    {
        return view('owner.boats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'price_per_hour' => 'nullable|numeric|min:0',
            'price_per_trip' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
        ]);

        auth()->user()->boats()->create($validated);

        return redirect()->route('owner.boats.index')->with('success', 'Boat added successfully!');
    }

    public function show(Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }
        $boat->load(['owner.profile', 'bookings' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }]);
        return view('owner.boats.show', compact('boat'));
    }

    public function edit(Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }
        return view('owner.boats.edit', compact('boat'));
    }

    public function update(Request $request, Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'price_per_hour' => 'nullable|numeric|min:0',
            'price_per_trip' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $boat->update($validated);

        return redirect()->route('owner.boats.index')->with('success', 'Boat updated successfully!');
    }

    public function destroy(Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }
        $boat->delete();
        return redirect()->route('owner.boats.index')->with('success', 'Boat deleted.');
    }

    // Public-facing boat detail
    public function detail(Boat $boat)
    {
        $boat->load(['owner.profile', 'reviews' => function ($q) {
            $q->with('user')->orderByDesc('created_at');
        }]);
        return view('boats.show', compact('boat'));
    }

    // Booking
    public function book(Request $request, Boat $boat)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'pax' => "required|integer|min:1|max:{$boat->capacity}",
            'notes' => 'nullable|string|max:500',
        ]);

        $existing = Booking::where('boat_id', $boat->id)
            ->where('date', $validated['date'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                  ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('start_time', '<=', $validated['start_time'])
                         ->where('end_time', '>=', $validated['end_time']);
                  });
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($existing) {
            return back()->withErrors(['date' => 'This time slot is already booked. Please choose another time.']);
        }

        Booking::create(array_merge($validated, [
            'boat_id' => $boat->id,
            'customer_name' => auth()->user()->name,
            'customer_phone' => auth()->user()->phone ?? '',
        ]));

        return redirect()->route('dashboard')->with('success', 'Booking request submitted! The owner will confirm shortly.');
    }

    // Reviews
    public function review(Request $request, Boat $boat)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $existing = Review::where('boat_id', $boat->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($existing) {
            return back()->withErrors(['rating' => 'You have already reviewed this boat.']);
        }

        Review::create([
            'boat_id' => $boat->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Review submitted! Thank you.');
    }

    // Owner: manage bookings
    public function manageBookings(Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }
        $bookings = $boat->bookings()->with('customer')->orderByDesc('created_at')->get();
        return view('owner.boats.bookings', compact('boat', 'bookings'));
    }

    public function updateBookingStatus(Request $request, Boat $boat, Booking $booking)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,rejected,cancelled',
        ]);

        $booking->update($validated);

        return back()->with('success', "Booking {$validated['status']} successfully.");
    }
}
