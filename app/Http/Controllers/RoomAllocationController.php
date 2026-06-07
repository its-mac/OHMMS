<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Student;
use App\Models\RoomAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomAllocationController extends Controller
{
    public function index()
    {
        $allocations = RoomAllocation::with('student', 'room.floor.block.hostel')
            ->latest()
            ->paginate(10);

        return view('room-allocations.index', compact('allocations'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')
            ->whereDoesntHave('roomAllocations', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('name')
            ->get();

        $rooms = Room::with('floor.block.hostel')
            ->whereIn('status', ['available'])
            ->whereColumn('occupied', '<', 'capacity')
            ->orderBy('room_no')
            ->get();

        return view('room-allocations.create', compact('students', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'room_id' => 'required|exists:rooms,id',
            'allocated_at' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {
            $studentHasRoom = RoomAllocation::where('student_id', $validated['student_id'])
                ->where('status', 'active')
                ->exists();

            if ($studentHasRoom) {
                abort(422, 'This student already has an active room allocation.');
            }

            $room = Room::lockForUpdate()->findOrFail($validated['room_id']);

            if ($room->status !== 'available' || $room->occupied >= $room->capacity) {
                abort(422, 'Selected room is not available.');
            }

            RoomAllocation::create([
                'student_id' => $validated['student_id'],
                'room_id' => $validated['room_id'],
                'allocated_at' => $validated['allocated_at'],
                'status' => 'active',
            ]);

            $room->occupied += 1;
            $room->status = $room->occupied >= $room->capacity ? 'full' : 'available';
            $room->save();
        });

        return redirect()
            ->route('admin.room-allocations.index')
            ->with('success', 'Room allocated successfully.');
    }

    public function show(RoomAllocation $roomAllocation)
    {
        $roomAllocation->load('student', 'room.floor.block.hostel');

        return view('room-allocations.show', compact('roomAllocation'));
    }

    public function edit(RoomAllocation $roomAllocation)
    {
        $roomAllocation->load('student', 'room.floor.block.hostel');

        return view('room-allocations.edit', compact('roomAllocation'));
    }

    public function update(Request $request, RoomAllocation $roomAllocation)
    {
        $validated = $request->validate([
            'released_at' => 'nullable|date|after_or_equal:' . $roomAllocation->allocated_at->format('Y-m-d'),
            'status' => 'required|in:active,released',
        ]);

        DB::transaction(function () use ($validated, $roomAllocation) {
            $roomAllocation->load('room');

            if ($roomAllocation->status === 'active' && $validated['status'] === 'released') {
                $room = Room::lockForUpdate()->findOrFail($roomAllocation->room_id);

                $room->occupied = max(0, $room->occupied - 1);

                if ($room->status !== 'maintenance' && $room->status !== 'inactive') {
                    $room->status = 'available';
                }

                $room->save();

                $validated['released_at'] = $validated['released_at'] ?? now()->toDateString();
            }

            $roomAllocation->update($validated);
        });

        return redirect()
            ->route('admin.room-allocations.index')
            ->with('success', 'Room allocation updated successfully.');
    }

    public function destroy(RoomAllocation $roomAllocation)
    {
        DB::transaction(function () use ($roomAllocation) {
            if ($roomAllocation->status === 'active') {
                $room = Room::lockForUpdate()->findOrFail($roomAllocation->room_id);

                $room->occupied = max(0, $room->occupied - 1);

                if ($room->status !== 'maintenance' && $room->status !== 'inactive') {
                    $room->status = 'available';
                }

                $room->save();
            }

            $roomAllocation->delete();
        });

        return redirect()
            ->route('admin.room-allocations.index')
            ->with('success', 'Room allocation deleted successfully.');
    }
}
