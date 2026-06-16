<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\GatePass;
use App\Models\GuestMeal;
use App\Models\LeaveRequest;
use App\Models\MessOff;

class StudentRequestCenterController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $leaveRequests = LeaveRequest::where('student_id', $student->id);
        $gatePasses = GatePass::where('student_id', $student->id);
        $guestMeals = GuestMeal::where('student_id', $student->id);
        $messOffs = MessOff::where('student_id', $student->id);
        $complaints = Complaint::where('student_id', $student->id);

        $totalRequests =
            (clone $leaveRequests)->count() +
            (clone $gatePasses)->count() +
            (clone $guestMeals)->count() +
            (clone $messOffs)->count() +
            (clone $complaints)->count();

        $pendingRequests =
            (clone $leaveRequests)->where('status', 'pending')->count() +
            (clone $gatePasses)->where('status', 'pending')->count() +
            (clone $guestMeals)->where('status', 'pending')->count() +
            (clone $messOffs)->where('status', 'pending')->count() +
            (clone $complaints)->whereIn('status', ['pending', 'in_progress'])->count();

        $approvedRequests =
            (clone $leaveRequests)->where('status', 'approved')->count() +
            (clone $gatePasses)->where('status', 'approved')->count() +
            (clone $guestMeals)->where('status', 'approved')->count() +
            (clone $messOffs)->where('status', 'approved')->count() +
            (clone $complaints)->where('status', 'resolved')->count();

        $rejectedRequests =
            (clone $leaveRequests)->where('status', 'rejected')->count() +
            (clone $gatePasses)->where('status', 'rejected')->count() +
            (clone $guestMeals)->where('status', 'rejected')->count() +
            (clone $messOffs)->where('status', 'rejected')->count() +
            (clone $complaints)->where('status', 'rejected')->count();

        $requestModules = [
            [
                'title' => 'Leave Requests',
                'description' => 'Apply and track hostel leave requests',
                'icon' => 'ph ph-calendar-check',
                'route' => route('student.leave-requests.index'),
                'create' => route('student.leave-requests.create'),
                'total' => (clone $leaveRequests)->count(),
                'pending' => (clone $leaveRequests)->where('status', 'pending')->count(),
                'color' => 'primary',
            ],
            [
                'title' => 'Gate Passes',
                'description' => 'Apply and track outing permissions',
                'icon' => 'ph ph-door-open',
                'route' => route('student.gate-passes.index'),
                'create' => route('student.gate-passes.create'),
                'total' => (clone $gatePasses)->count(),
                'pending' => (clone $gatePasses)->where('status', 'pending')->count(),
                'color' => 'success',
            ],
            [
                'title' => 'Guest Meals',
                'description' => 'Request meals for guests',
                'icon' => 'ph ph-users-three',
                'route' => route('student.guest-meals.index'),
                'create' => route('student.guest-meals.create'),
                'total' => (clone $guestMeals)->count(),
                'pending' => (clone $guestMeals)->where('status', 'pending')->count(),
                'color' => 'warning',
            ],
            [
                'title' => 'Mess Off',
                'description' => 'Apply to stop mess temporarily',
                'icon' => 'ph ph-calendar-x',
                'route' => route('student.mess-offs.index'),
                'create' => route('student.mess-offs.create'),
                'total' => (clone $messOffs)->count(),
                'pending' => (clone $messOffs)->where('status', 'pending')->count(),
                'color' => 'info',
            ],
            [
                'title' => 'Complaints',
                'description' => 'Submit and track complaints',
                'icon' => 'ph ph-chat-circle-text',
                'route' => route('student.complaints.index'),
                'create' => route('student.complaints.create'),
                'total' => (clone $complaints)->count(),
                'pending' => (clone $complaints)->whereIn('status', ['pending', 'in_progress'])->count(),
                'color' => 'danger',
            ],
        ];

        return view('student.requests.index', compact(
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'requestModules'
        ));
    }
}
