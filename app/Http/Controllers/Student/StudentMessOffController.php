<?php

namespace App\Http\Controllers\Student;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\MessOff;
use Illuminate\Http\Request;

class StudentMessOffController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        $messOffs = MessOff::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.mess-offs.index', compact('messOffs'));
    }

    public function create()
    {
        return view('student.mess-offs.create');
    }

    public function store(Request $request)
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        $validated = $request->validate([
            'from_date' => ['required', 'date', 'after_or_equal:today'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['student_id'] = $student->id;
        $validated['status'] = 'pending';

        MessOff::create($validated);
        NotificationHelper::sendToRole(
            'manager',
            'New Mess Off Request',
            auth()->user()->name . ' submitted a new mess off request.',
            route('manager.mess-offs.index'),
            'mess_off'
        );

        return redirect()
            ->route('student.mess-offs.index')
            ->with('success', 'Mess off request submitted successfully.');
    }

    public function show(MessOff $messOff)
    {
        $student = auth()->user()->student;

        abort_if(!$student || $messOff->student_id !== $student->id, 403);

        return view('student.mess-offs.show', compact('messOff'));
    }
}
