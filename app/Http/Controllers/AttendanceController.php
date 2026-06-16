<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use Illuminate\Support\Facades\DB;
use App\Models\MealSession;
use Illuminate\Http\Request;
use App\Models\Student;

class AttendanceController extends Controller
{
    public function scan()
    {
        $mealSessions = MealSession::where('is_active', true)->get();

        return view('attendance.scan', compact('mealSessions'));
    }

    public function index(Request $request)
    {
        $mealSessions = MealSession::where('is_active', true)
            ->orderBy('name')
            ->get();

        $query = AttendanceLog::with([
            'student',
            'mealSession'
        ]);

        if ($request->filled('from_date')) {
            $query->whereDate('attendance_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('attendance_date', '<=', $request->to_date);
        }

        if ($request->filled('meal_session_id')) {
            $query->where('meal_session_id', $request->meal_session_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('student', function ($studentQuery) use ($search) {
                $studentQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('registration_no', 'like', '%' . $search . '%');
            });
        }

        $filteredTotal = (clone $query)->count();

        $fingerprintTotal = (clone $query)
            ->where('verification_method', 'fingerprint')
            ->count();

        $manualTotal = (clone $query)
            ->where('verification_method', 'manual')
            ->count();

        $logs = $query
            ->latest('attendance_date')
            ->latest('attendance_time')
            ->paginate(20)
            ->withQueryString();

        return view('attendance.index', compact(
            'logs',
            'mealSessions',
            'filteredTotal',
            'fingerprintTotal',
            'manualTotal'
        ));
    }

    public function today()
    {
        $logs = AttendanceLog::with([
            'student',
            'mealSession'
        ])
            ->whereDate('attendance_date', today())
            ->latest()
            ->get();

        $totalToday = $logs->count();

        $mealWiseCounts = AttendanceLog::select(
            'meal_session_id',
            DB::raw('count(*) as total')
        )
            ->with('mealSession')
            ->whereDate('attendance_date', today())
            ->groupBy('meal_session_id')
            ->get();

        $breakfastCount = $mealWiseCounts
            ->firstWhere('mealSession.name', 'Breakfast')
            ?->total ?? 0;

        $lunchCount = $mealWiseCounts
            ->firstWhere('mealSession.name', 'Lunch')
            ?->total ?? 0;

        $dinnerCount = $mealWiseCounts
            ->firstWhere('mealSession.name', 'Dinner')
            ?->total ?? 0;

        return view('attendance.today', compact(
            'logs',
            'totalToday',
            'mealWiseCounts',
            'breakfastCount',
            'lunchCount',
            'dinnerCount'
        ));
    }

    public function reports(Request $request)
    {
        $date = $request->get('date', today()->toDateString());
        $mealSessionId = $request->get('meal_session_id');

        $mealSessions = MealSession::where('is_active', true)->get();

        $query = AttendanceLog::with(['student', 'mealSession'])
            ->whereDate('attendance_date', $date);

        if ($mealSessionId) {
            $query->where('meal_session_id', $mealSessionId);
        }

        $logs = $query->latest()->get();

        $totalStudents = Student::where('status', 'active')->count();
        $presentStudents = $logs->pluck('student_id')->unique()->count();
        $absentStudents = max(0, $totalStudents - $presentStudents);

        $mealWiseCounts = AttendanceLog::select('meal_session_id', DB::raw('count(*) as total'))
            ->with('mealSession')
            ->whereDate('attendance_date', $date)
            ->groupBy('meal_session_id')
            ->get();

        return view('attendance.reports', compact(
            'date',
            'mealSessionId',
            'mealSessions',
            'logs',
            'totalStudents',
            'presentStudents',
            'absentStudents',
            'mealWiseCounts'
        ));
    }

    public function exportReport(Request $request)
    {
        $date = $request->get('date', today()->toDateString());
        $mealSessionId = $request->get('meal_session_id');

        $query = AttendanceLog::with(['student', 'mealSession'])
            ->whereDate('attendance_date', $date);

        if ($mealSessionId) {
            $query->where('meal_session_id', $mealSessionId);
        }

        $logs = $query->latest()->get();

        $fileName = 'attendance-report-' . $date . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                '#',
                'Attendance Date',
                'Attendance Time',
                'Registration No',
                'Student Name',
                'Meal Session',
                'Verification Method',
            ]);

            foreach ($logs as $index => $log) {
                fputcsv($file, [
                    $index + 1,
                    $log->attendance_date,
                    \Carbon\Carbon::parse($log->attendance_time)->format('h:i A'),
                    $log->student?->registration_no ?? '-',
                    $log->student?->name ?? '-',
                    $log->mealSession?->name ?? '-',
                    ucfirst($log->verification_method ?? '-'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
