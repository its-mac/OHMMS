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
        $attendanceTrendLabels = [];
        $attendanceTrendData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);

            $attendanceTrendLabels[] = $date->format('d M');

            $attendanceTrendData[] = AttendanceLog::whereDate('attendance_date', $date)->count();
        }

        $requestSummaryLabels = [
            'Guest Meals',
            'Mess Offs',
            'Leaves',
            'Gate Passes',
        ];

        $requestSummaryData = [
            $pendingGuestMeals,
            $pendingMessOffs,
            $pendingLeaveRequests,
            $pendingGatePasses,
        ];


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
            'todayCollection',
            'attendanceTrendLabels',
            'attendanceTrendData',
            'requestSummaryLabels',
            'requestSummaryData'
        ));
    }

    public function analytics()
    {
        $totalStudents = Student::count();

        $totalBeds = Room::sum('capacity');
        $occupiedBeds = Room::sum('occupied');

        $vacantBeds = max($totalBeds - $occupiedBeds, 0);

        $occupancyRate = $totalBeds > 0
            ? round(($occupiedBeds / $totalBeds) * 100, 2)
            : 0;

        $todayAttendance = AttendanceLog::whereDate('attendance_date', today())->count();

        $attendanceRate = $totalStudents > 0
            ? round(($todayAttendance / $totalStudents) * 100, 2)
            : 0;

        $pendingGuestMeals = GuestMeal::where('status', 'pending')->count();
        $pendingMessOffs = MessOff::where('status', 'pending')->count();
        $pendingLeaves = LeaveRequest::where('status', 'pending')->count();
        $pendingGatePasses = GatePass::where('status', 'pending')->count();

        $openComplaints = Complaint::whereIn('status', ['pending', 'in_progress'])->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $escalatedComplaints = Complaint::where('is_escalated', true)->count();

        $totalGenerated = Invoice::sum('total_amount');
        $totalRevenue = Invoice::sum('paid_amount');
        $outstandingAmount = $totalGenerated - $totalRevenue;

        $collectionRate = $totalGenerated > 0
            ? round(($totalRevenue / $totalGenerated) * 100, 2)
            : 0;

        $defaultersCount = Invoice::whereIn('status', ['unpaid', 'partial'])
            ->distinct('student_id')
            ->count('student_id');

        $attendanceTrendLabels = [];
        $attendanceTrendData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);

            $attendanceTrendLabels[] = $date->format('d M');
            $attendanceTrendData[] = AttendanceLog::whereDate('attendance_date', $date)->count();
        }

        $requestSummaryLabels = [
            'Guest Meals',
            'Mess Offs',
            'Leaves',
            'Gate Passes',
        ];

        $requestSummaryData = [
            $pendingGuestMeals,
            $pendingMessOffs,
            $pendingLeaves,
            $pendingGatePasses,
        ];

        $complaintSummaryLabels = [
            'Open',
            'Resolved',
            'Escalated',
        ];

        $complaintSummaryData = [
            $openComplaints,
            $resolvedComplaints,
            $escalatedComplaints,
        ];

        $financeSummaryLabels = [
            'Collected',
            'Outstanding',
        ];

        $financeSummaryData = [
            (float) $totalRevenue,
            (float) $outstandingAmount,
        ];

        return view(
            'manager.reports.analytics',
            compact(
                'totalStudents',
                'totalBeds',
                'occupiedBeds',
                'vacantBeds',
                'occupancyRate',
                'todayAttendance',
                'attendanceRate',
                'pendingGuestMeals',
                'pendingMessOffs',
                'pendingLeaves',
                'pendingGatePasses',
                'openComplaints',
                'resolvedComplaints',
                'escalatedComplaints',
                'totalGenerated',
                'totalRevenue',
                'outstandingAmount',
                'collectionRate',
                'defaultersCount',
                'attendanceTrendLabels',
                'attendanceTrendData',
                'requestSummaryLabels',
                'requestSummaryData',
                'complaintSummaryLabels',
                'complaintSummaryData',
                'financeSummaryLabels',
                'financeSummaryData',
            )
        );
    }
}
