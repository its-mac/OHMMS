<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\AttendanceLog;
use App\Models\Complaint;
use App\Models\GatePass;
use App\Models\GuestMeal;
use App\Models\Invoice;
use App\Models\LeaveRequest;
use App\Models\MessOff;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $latestInvoice = Invoice::where('student_id', $student->id)
            ->latest()
            ->first();

        $totalOutstanding = Invoice::where('student_id', $student->id)
            ->selectRaw('SUM(total_amount - paid_amount) as outstanding')
            ->value('outstanding') ?? 0;

        $attendanceToday = AttendanceLog::where('student_id', $student->id)
            ->whereDate('attendance_date', today())
            ->exists();

        $pendingLeaveRequests = LeaveRequest::where('student_id', $student->id)
            ->where('status', 'pending')
            ->count();

        $pendingGatePasses = GatePass::where('student_id', $student->id)
            ->where('status', 'pending')
            ->count();

        $pendingGuestMeals = GuestMeal::where('student_id', $student->id)
            ->where('status', 'pending')
            ->count();

        $pendingMessOffs = MessOff::where('student_id', $student->id)
            ->where('status', 'pending')
            ->count();

        $openComplaints = Complaint::where('student_id', $student->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();

        $pendingRequests =
            $pendingLeaveRequests +
            $pendingGatePasses +
            $pendingGuestMeals +
            $pendingMessOffs +
            $openComplaints;

        $unreadNotifications = AppNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return view('dashboards.student', compact(
            'student',
            'latestInvoice',
            'totalOutstanding',
            'attendanceToday',
            'pendingLeaveRequests',
            'pendingGatePasses',
            'pendingGuestMeals',
            'pendingMessOffs',
            'openComplaints',
            'pendingRequests',
            'unreadNotifications'
        ));
    }
}
