<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('floor.block.hostel')
            ->latest()
            ->paginate(10);

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $floors = Floor::with('block.hostel')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('rooms.create', compact('floors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'floor_id' => 'required|exists:floors,id',

            'room_no' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms', 'room_no')
                    ->where('floor_id', $request->floor_id),
            ],

            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,full,maintenance,inactive',
        ]);

        $validated['occupied'] = 0;

        Room::create($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        $room->load('floor.block.hostel');

        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $floors = Floor::with('block.hostel')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('rooms.edit', compact('room', 'floors'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'floor_id' => 'required|exists:floors,id',

            'room_no' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms', 'room_no')
                    ->where('floor_id', $request->floor_id)
                    ->ignore($room->id),
            ],

            'capacity' => 'required|integer|min:1',

            'occupied' => 'required|integer|min:0',

            'status' => 'required|in:available,full,maintenance,inactive',
        ]);

        if ($validated['occupied'] >= $validated['capacity']) {
            $validated['status'] = 'full';
        } elseif ($validated['status'] !== 'maintenance' && $validated['status'] !== 'inactive') {
            $validated['status'] = 'available';
        }

        $room->update($validated);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}
