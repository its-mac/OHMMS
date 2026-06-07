<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\FingerprintTemplate;

class StudentFingerprintController extends Controller
{
    public function destroy(Student $student, int $fingerIndex)
    {
        FingerprintTemplate::where('student_id', $student->id)
            ->where('finger_index', $fingerIndex)
            ->delete();

        $hasAnyFingerprint = FingerprintTemplate::where('student_id', $student->id)->exists();

        $student->update([
            'fingerprint_enrolled' => $hasAnyFingerprint,
        ]);

        return redirect()
            ->route('admin.students.show', $student)
            ->with('success', 'Fingerprint deleted successfully.');
    }
}
