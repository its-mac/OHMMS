<?php

namespace App\Http\Controllers\Student;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class StudentLeaveRequestController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $leaveRequests = LeaveRequest::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.leave-requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        return view('student.leave-requests.create');
    }

    public function store(Request $request)
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $validated = $request->validate([
            'from_date' => ['required', 'date', 'after_or_equal:today'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'destination' => ['nullable', 'string', 'max:255'],
            'contact_during_leave' => ['nullable', 'string', 'max:255'],
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $validated['student_id'] = $student->id;
        $validated['status'] = 'pending';

        LeaveRequest::create($validated);
        NotificationHelper::sendToRole(
            'manager',
            'New Leave Request',
            auth()->user()->name . ' submitted a new leave request.',
            route('manager.leave-requests.index'),
            'leave_request'
        );
        return redirect()
            ->route('student.leave-requests.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function show(LeaveRequest $leaveRequest)
    {
        $student = auth()->user()->student;

        abort_if(!$student || $leaveRequest->student_id !== $student->id, 403);

        return view('student.leave-requests.show', compact('leaveRequest'));
    }
}
