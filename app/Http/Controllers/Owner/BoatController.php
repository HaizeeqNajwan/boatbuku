<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use Illuminate\Http\Request;

class BoatController extends Controller
{
    public function index()
    {
        $boats = auth()->user()->boats;
        return view("owner.boats.index", compact("boats"));
    }

    public function create()
    {
        return view("owner.boats.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "type" => "required|string|max:255",
            "capacity" => "required|integer|min:1",
            "description" => "nullable|string",
            "price_per_hour" => "nullable|numeric|min:0",
            "price_per_trip" => "nullable|numeric|min:0",
            "location" => "required|string|max:255",
        ]);

        auth()->user()->boats()->create($validated);

        return redirect()
            ->route("owner.boats.index")
            ->with("success", "Boat added successfully!");
    }

    public function show(Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }
        return view("owner.boats.show", compact("boat"));
    }

    public function edit(Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }
        return view("owner.boats.edit", compact("boat"));
    }

    public function update(Request $request, Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            "name" => "required|string|max:255",
            "type" => "required|string|max:255",
            "capacity" => "required|integer|min:1",
            "description" => "nullable|string",
            "price_per_hour" => "nullable|numeric|min:0",
            "price_per_trip" => "nullable|numeric|min:0",
            "location" => "required|string|max:255",
        ]);

        $boat->update($validated);

        return redirect()
            ->route("owner.boats.index")
            ->with("success", "Boat updated successfully!");
    }

    public function destroy(Boat $boat)
    {
        if ($boat->owner_id !== auth()->id()) {
            abort(403);
        }
        $boat->delete();
        return redirect()
            ->route("owner.boats.index")
            ->with("success", "Boat deleted.");
    }
}
