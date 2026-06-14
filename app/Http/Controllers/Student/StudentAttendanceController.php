<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\MealSession;
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

        return view('student.attendance.index', compact(
            'student',
            'attendanceLogs',
            'mealSessions',
            'totalMeals',
            'monthlyMeals'
        ));
    }
}
