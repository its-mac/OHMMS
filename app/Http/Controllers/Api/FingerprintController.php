<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FingerprintTemplate;
use App\Models\Student;
use Illuminate\Http\Request;

class FingerprintController extends Controller
{
    public function index()
    {
        return FingerprintTemplate::with('student:id,registration_no,name')
            ->select('id', 'student_id', 'finger_index', 'template_data', 'created_at')
            ->get()
            ->makeVisible('template_data');
    }

    public function enroll(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'finger_index' => 'required|integer|min:1|max:10',
            'template_data' => 'required|string',
        ]);

        FingerprintTemplate::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'finger_index' => $validated['finger_index'],
            ],
            [
                'template_data' => $validated['template_data'],
            ]
        );

        Student::where('id', $validated['student_id'])
            ->update(['fingerprint_enrolled' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Fingerprint template enrolled successfully.',
        ]);
    }

    public function show($studentId, $fingerIndex)
    {
        $template = FingerprintTemplate::where('student_id', $studentId)
            ->where('finger_index', $fingerIndex)
            ->first();

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Fingerprint template not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'student_id' => $template->student_id,
            'finger_index' => $template->finger_index,
            'template_data' => $template->template_data,
        ]);
    }

    public function destroy($studentId, $fingerIndex)
    {
        $template = FingerprintTemplate::where('student_id', $studentId)
            ->where('finger_index', $fingerIndex)
            ->first();

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Fingerprint template not found.',
            ], 404);
        }

        $template->delete();

        $hasAnyFingerprint = FingerprintTemplate::where('student_id', $studentId)->exists();

        Student::where('id', $studentId)
            ->update(['fingerprint_enrolled' => $hasAnyFingerprint]);

        return response()->json([
            'success' => true,
            'message' => 'Fingerprint template deleted successfully.',
        ]);
    }
}
