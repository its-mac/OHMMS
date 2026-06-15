<?php

namespace App\Http\Controllers\Manager;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with('student')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->paginate(10)->withQueryString();

        return view('manager.leave-requests.index', compact('leaveRequests'));
    }

    public function show(LeaveRequest $leaveRequest)
    {
        $leaveRequest->load('student');

        return view('manager.leave-requests.show', compact('leaveRequest'));
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update(['status' => 'approved']);
        NotificationHelper::sendToUser(
            $leaveRequest->student->user_id,
            'Leave Request Approved',
            'Your leave request has been approved.',
            route('student.leave-requests.index'),
            'leave_request'
        );
        return back()->with('success', 'Leave request approved.');
    }

    public function reject(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update(['status' => 'rejected']);
        NotificationHelper::sendToUser(
            $leaveRequest->student->user_id,
            'Leave Request Rejected',
            'Your leave request has been rejected.',
            route('student.leave-requests.index'),
            'leave_request'
        );
        return back()->with('success', 'Leave request rejected.');
    }
}
