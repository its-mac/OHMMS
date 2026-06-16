<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\MealSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        $query = AttendanceLog::with('mealSession')
            ->where('student_id', $student->id)
            ->latest('attendance_date')
            ->latest('attendance_time');

        if ($request->filled('from_date')) {
            $query->whereDate('attendance_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('attendance_date', '<=', $request->to_date);
        }

        if ($request->filled('meal_session_id')) {
            $query->where('meal_session_id', $request->meal_session_id);
        }

        $attendanceLogs = $query->paginate(10)->withQueryString();

        $mealSessions = MealSession::where('is_active', 1)
            ->orderBy('start_time')
            ->get();

        $totalMeals = AttendanceLog::where('student_id', $student->id)->count();

        $monthlyMeals = AttendanceLog::where('student_id', $student->id)
            ->whereMonth('attendance_date', now()->month)
            ->whereYear('attendance_date', now()->year)
            ->count();

        $todayMeals = AttendanceLog::where('student_id', $student->id)
            ->whereDate('attendance_date', today())
            ->count();

        $activeMealSessions = $mealSessions->count();
        $daysInMonthTillToday = now()->day;
        $expectedMealsThisMonth = max(1, $activeMealSessions * $daysInMonthTillToday);

        $monthlyAttendancePercentage = round(($monthlyMeals / $expectedMealsThisMonth) * 100, 1);

        $mealWiseSummary = AttendanceLog::selectRaw('meal_session_id, COUNT(*) as total')
            ->with('mealSession')
            ->where('student_id', $student->id)
            ->groupBy('meal_session_id')
            ->get();

        $attendanceTrendLabels = [];
        $attendanceTrendData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = today()->subDays($i);

            $attendanceTrendLabels[] = $date->format('d M');

            $attendanceTrendData[] = AttendanceLog::where('student_id', $student->id)
                ->whereDate('attendance_date', $date)
                ->count();
        }

        $mealChartLabels = $mealWiseSummary
            ->map(fn($item) => $item->mealSession?->name ?? 'Unknown')
            ->values();

        $mealChartData = $mealWiseSummary
            ->pluck('total')
            ->values();

        return view('student.attendance.index', compact(
            'student',
            'attendanceLogs',
            'mealSessions',
            'totalMeals',
            'monthlyMeals',
            'todayMeals',
            'monthlyAttendancePercentage',
            'mealWiseSummary',
            'attendanceTrendLabels',
            'attendanceTrendData',
            'mealChartLabels',
            'mealChartData'
        ));
    }
}
