<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Complaint;
use App\Models\GatePass;
use App\Models\GuestMeal;
use App\Models\Hostel;
use App\Models\Invoice;
use App\Models\LeaveRequest;
use App\Models\Room;
use App\Models\RoomAllocation;
use App\Models\Student;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalHostels = Hostel::count();

        $totalManagers = User::where('role', 'manager')->count();

        $totalStudents = Student::count();

        $todayAttendance = AttendanceLog::whereDate(
            'attendance_date',
            today()
        )->count();

        $totalRooms = Room::count();

        $occupiedRooms = RoomAllocation::where('status', 'active')
            ->distinct('room_id')
            ->count('room_id');

        $occupancyPercentage = $totalRooms > 0
            ? round(($occupiedRooms / $totalRooms) * 100, 1)
            : 0;

        $totalRevenue = Invoice::sum('paid_amount');

        $outstandingAmount = Invoice::selectRaw(
            'SUM(total_amount - paid_amount) as outstanding'
        )->value('outstanding') ?? 0;

        $openComplaints = Complaint::whereIn(
            'status',
            ['pending', 'in_progress']
        )->count();

        $pendingLeaves = LeaveRequest::where(
            'status',
            'pending'
        )->count();

        $pendingGatePasses = GatePass::where(
            'status',
            'pending'
        )->count();

        $pendingGuestMeals = GuestMeal::where(
            'status',
            'pending'
        )->count();

        return view(
            'dashboards.admin',
            compact(
                'totalHostels',
                'totalManagers',
                'totalStudents',
                'todayAttendance',
                'occupancyPercentage',
                'totalRevenue',
                'outstandingAmount',
                'openComplaints',
                'pendingLeaves',
                'pendingGatePasses',
                'pendingGuestMeals'
            )
        );
    }
}
