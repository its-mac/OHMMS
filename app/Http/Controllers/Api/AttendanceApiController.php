<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\MealSession;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::findOrFail(
            $request->student_id
        );

        $currentTime = now()->format('H:i:s');

        $mealSession = MealSession::where('is_active', true)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->first();

        if (!$mealSession) {
            return response()->json([
                'success' => false,
                'message' => 'No active meal session.'
            ]);
        }

        $alreadyMarked = AttendanceLog::where(
            'student_id',
            $student->id
        )
            ->where(
                'meal_session_id',
                $mealSession->id
            )
            ->whereDate(
                'attendance_date',
                today()
            )
            ->exists();

        if ($alreadyMarked) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already marked.'
            ]);
        }

        AttendanceLog::create([
            'student_id' => $student->id,
            'meal_session_id' => $mealSession->id,
            'attendance_date' => today(),
            'attendance_time' => now()->format('H:i:s'),
            'verification_method' => 'fingerprint',
        ]);

        return response()->json([
            'success' => true,
            'student' => [
                'id' => $student->id,
                'registration_no' => $student->registration_no,
                'name' => $student->name,
            ],
            'meal_session' => $mealSession->name,
            'message' => 'Attendance marked successfully.'
        ]);
    }
}
