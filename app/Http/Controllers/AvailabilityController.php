<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function index()
    {
        $owner = Auth::user();
        $boats = $owner->boats;

        $availabilities = Availability::whereIn('boat_id', $boats->pluck('id'))
            ->with('boat')
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('owner.availability.index', compact('availabilities', 'boats'));
    }

    public function create()
    {
        $owner = Auth::user();
        $boats = $owner->boats;
        return view('owner.availability.create', compact('boats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'boat_id' => 'required|exists:boats,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'is_blocked' => 'nullable|boolean',
        ]);

        $owner = Auth::user();
        $boat = Boat::findOrFail($request->boat_id);

        if (!$boat->owner_id === $owner->id) {
            abort(403, 'Unauthorized action.');
        }

        Availability::create([
            'boat_id' => $request->boat_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_blocked' => $request->has('is_blocked'),
        ]);

        return redirect()->route('owner.availability.index')
            ->with('success', 'Availability slot created successfully.');
    }

    public function edit(Availability $availability)
    {
        $owner = Auth::user();
        $boat = $availability->boat;

        if ($boat->owner_id !== $owner->id) {
            abort(403, 'Unauthorized action.');
        }

        $boats = $owner->boats;
        return view('owner.availability.edit', compact('availability', 'boats'));
    }

    public function update(Request $request, Availability $availability)
    {
        $owner = Auth::user();
        $boat = $availability->boat;

        if ($boat->owner_id !== $owner->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'boat_id' => 'required|exists:boats,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'is_blocked' => 'nullable|boolean',
        ]);

        $availability->update([
            'boat_id' => $request->boat_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_blocked' => $request->has('is_blocked'),
        ]);

        return redirect()->route('owner.availability.index')
            ->with('success', 'Availability slot updated successfully.');
    }

    public function destroy(Availability $availability)
    {
        $owner = Auth::user();
        $boat = $availability->boat;

        if ($boat->owner_id !== $owner->id) {
            abort(403, 'Unauthorized action.');
        }

        $availability->delete();

        return redirect()->route('owner.availability.index')
            ->with('success', 'Availability slot deleted successfully.');
    }
}
