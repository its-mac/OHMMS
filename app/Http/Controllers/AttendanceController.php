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

    public function index()
    {
        $logs = AttendanceLog::with([
            'student',
            'mealSession'
        ])
            ->latest()
            ->paginate(20);

        return view('attendance.index', compact('logs'));
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

        return view('attendance.today', compact('logs'));
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
}
