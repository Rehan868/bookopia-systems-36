<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Property;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('property')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('pages.staff.rooms.index', compact('rooms'));
    }

    public function availability()
    {
        $rooms = Room::with('property')->get();
        return view('pages.staff.availability.index', compact('rooms'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('pages.staff.rooms.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string|max:255',
            'room_type' => 'required|string|max:255',
            'bed_count' => 'required|integer|min:1',
            'max_occupancy' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        return view('pages.staff.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $properties = Property::all();
        return view('pages.staff.rooms.edit', compact('room', 'properties'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string|max:255',
            'room_type' => 'required|string|max:255',
            'bed_count' => 'required|integer|min:1',
            'max_occupancy' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}
