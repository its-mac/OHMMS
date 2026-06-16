<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Complaint;
use App\Models\Hostel;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalHostels = Hostel::count();
        $totalManagers = User::where('role', 'manager')->count();
        $totalStudents = Student::count();

        $todayAttendance = AttendanceLog::whereDate('attendance_date', today())->count();

        $totalBeds = Room::sum('capacity');
        $occupiedBeds = Room::sum('occupied');
        $vacantBeds = max($totalBeds - $occupiedBeds, 0);

        $occupancyPercentage = $totalBeds > 0
            ? round(($occupiedBeds / $totalBeds) * 100, 1)
            : 0;

        $totalGenerated = Invoice::sum('total_amount');
        $totalRevenue = Invoice::sum('paid_amount');
        $outstandingAmount = $totalGenerated - $totalRevenue;

        $collectionRate = $totalGenerated > 0
            ? round(($totalRevenue / $totalGenerated) * 100, 1)
            : 0;

        $paidInvoices = Invoice::where('status', 'paid')->count();

        $unpaidInvoices = Invoice::whereIn('status', ['unpaid', 'partial'])->count();

        $defaultersCount = Invoice::whereIn('status', ['unpaid', 'partial'])
            ->distinct('student_id')
            ->count('student_id');

        $complaintsThisMonth = Complaint::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $escalatedComplaints = Complaint::where('is_escalated', true)->count();
        $monthlyRevenueLabels = [];
        $monthlyRevenueData = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyRevenueLabels[] = Carbon::createFromDate(now()->year, $month, 1)->format('M');

            $monthlyRevenueData[] = Invoice::whereMonth('invoice_date', $month)
                ->whereYear('invoice_date', now()->year)
                ->sum('paid_amount');
        }

        $complaintStatusLabels = ['Pending', 'In Progress', 'Resolved', 'Rejected'];

        $complaintStatusData = [
            Complaint::where('status', 'pending')->count(),
            Complaint::where('status', 'in_progress')->count(),
            Complaint::where('status', 'resolved')->count(),
            Complaint::where('status', 'rejected')->count(),
        ];
        return view('dashboards.admin', compact(
            'totalHostels',
            'totalManagers',
            'totalStudents',
            'todayAttendance',
            'totalBeds',
            'occupiedBeds',
            'vacantBeds',
            'occupancyPercentage',
            'totalGenerated',
            'totalRevenue',
            'outstandingAmount',
            'collectionRate',
            'paidInvoices',
            'unpaidInvoices',
            'defaultersCount',
            'complaintsThisMonth',
            'escalatedComplaints',
            'monthlyRevenueLabels',
            'monthlyRevenueData',
            'complaintStatusLabels',
            'complaintStatusData'
        ));
    }

    public function analytics()
    {
        $totalHostels = Hostel::count();
        $totalManagers = User::where('role', 'manager')->count();
        $totalStudents = Student::count();

        $totalBeds = Room::sum('capacity');
        $occupiedBeds = Room::sum('occupied');
        $vacantBeds = max($totalBeds - $occupiedBeds, 0);

        $occupancyRate = $totalBeds > 0
            ? round(($occupiedBeds / $totalBeds) * 100, 2)
            : 0;

        $totalGenerated = Invoice::sum('total_amount');
        $totalRevenue = Invoice::sum('paid_amount');
        $outstandingAmount = $totalGenerated - $totalRevenue;

        $collectionRate = $totalGenerated > 0
            ? round(($totalRevenue / $totalGenerated) * 100, 2)
            : 0;

        $defaultersCount = Invoice::whereIn('status', ['unpaid', 'partial'])
            ->distinct('student_id')
            ->count('student_id');

        $openComplaints = Complaint::whereIn('status', ['pending', 'in_progress'])->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $escalatedComplaints = Complaint::where('is_escalated', true)->count();

        $monthlyRevenue = Invoice::query()
            ->selectRaw('MONTH(created_at) as invoice_month, SUM(paid_amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'invoice_month');

        $revenueTrendLabels = [];
        $revenueTrendData = [];

        for ($i = 1; $i <= 12; $i++) {
            $revenueTrendLabels[] = Carbon::create()->month($i)->format('M');
            $revenueTrendData[] = (float) ($monthlyRevenue[$i] ?? 0);
        }

        $attendanceTrend = AttendanceLog::selectRaw('DATE(attendance_time) as date, COUNT(*) as total')
            ->whereDate('attendance_time', '>=', now()->subDays(29))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $attendanceTrendLabels = [];
        $attendanceTrendData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');

            $attendanceTrendLabels[] = now()->subDays($i)->format('d M');
            $attendanceTrendData[] = (int) ($attendanceTrend[$date] ?? 0);
        }

        $complaintChartLabels = ['Open', 'Resolved', 'Escalated'];
        $complaintChartData = [
            $openComplaints,
            $resolvedComplaints,
            $escalatedComplaints,
        ];

        $hostelOccupancy = Hostel::with(['blocks.floors.rooms'])->get()->map(function ($hostel) {
            $rooms = $hostel->blocks
                ->flatMap->floors
                ->flatMap->rooms;

            return [
                'name' => $hostel->name,
                'capacity' => $rooms->sum('capacity'),
                'occupied' => $rooms->sum('occupied'),
            ];
        });

        $hostelOccupancyLabels = $hostelOccupancy->pluck('name')->values();
        $hostelOccupancyCapacity = $hostelOccupancy->pluck('capacity')->values();
        $hostelOccupancyOccupied = $hostelOccupancy->pluck('occupied')->values();
        return view('admin.reports.analytics', compact(
            'totalHostels',
            'totalManagers',
            'totalStudents',
            'totalBeds',
            'occupiedBeds',
            'vacantBeds',
            'occupancyRate',
            'totalGenerated',
            'totalRevenue',
            'outstandingAmount',
            'collectionRate',
            'defaultersCount',
            'openComplaints',
            'resolvedComplaints',
            'escalatedComplaints',
            'revenueTrendLabels',
            'revenueTrendData',
            'attendanceTrendLabels',
            'attendanceTrendData',
            'complaintChartLabels',
            'complaintChartData',
            'hostelOccupancyLabels',
            'hostelOccupancyCapacity',
            'hostelOccupancyOccupied',
        ));
    }
}
