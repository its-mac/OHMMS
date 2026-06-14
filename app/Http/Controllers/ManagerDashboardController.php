<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Complaint;
use App\Models\GatePass;
use App\Models\GuestMeal;
use App\Models\Invoice;
use App\Models\LeaveRequest;
use App\Models\MessOff;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\Student;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $today = today();

        $todayAttendance = AttendanceLog::whereDate('attendance_date', $today)->count();

        $pendingGuestMeals = GuestMeal::where('status', 'pending')->count();
        $pendingMessOffs = MessOff::where('status', 'pending')->count();
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();
        $pendingGatePasses = GatePass::where('status', 'pending')->count();

        $openComplaints = Complaint::whereIn('status', ['pending', 'in_progress'])->count();

        $totalStudents = Student::count();

        $totalRooms = Room::count();

        $occupiedRooms = RoomAllocation::where('status', 'active')
            ->distinct('room_id')
            ->count('room_id');

        $vacantRooms = max($totalRooms - $occupiedRooms, 0);

        $pendingInvoices = Invoice::whereIn('status', ['unpaid', 'partial'])->count();

        $outstandingAmount = Invoice::whereIn('status', ['unpaid', 'partial'])
            ->selectRaw('SUM(total_amount - paid_amount) as outstanding')
            ->value('outstanding') ?? 0;

        $todayCollection = Invoice::whereDate('updated_at', $today)
            ->where('status', 'paid')
            ->sum('paid_amount');

        return view('dashboards.manager', compact(
            'todayAttendance',
            'pendingGuestMeals',
            'pendingMessOffs',
            'pendingLeaveRequests',
            'pendingGatePasses',
            'openComplaints',
            'totalStudents',
            'totalRooms',
            'occupiedRooms',
            'vacantRooms',
            'pendingInvoices',
            'outstandingAmount',
            'todayCollection'
        ));
    }
}
