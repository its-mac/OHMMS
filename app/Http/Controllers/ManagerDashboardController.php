<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\GuestMeal;
use App\Models\MessOff;
use App\Models\Student;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $todayAttendance = AttendanceLog::whereDate(
            'attendance_date',
            today()
        )->count();

        $pendingGuestMeals = GuestMeal::where(
            'status',
            'pending'
        )->count();

        $pendingMessOffs = MessOff::where(
            'status',
            'pending'
        )->count();

        $totalStudents = Student::count();

        return view(
            'dashboards.manager',
            compact(
                'todayAttendance',
                'pendingGuestMeals',
                'pendingMessOffs',
                'totalStudents'
            )
        );
    }
}
