<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class StudentRoomController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        $allocation = $student->activeRoomAllocation()
            ->with('room.floor.block.hostel')
            ->first();

        return view('student.room.index', compact('student', 'allocation'));
    }
}
