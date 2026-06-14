<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class StudentComplaintController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $complaints = Complaint::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('student.complaints.create');
    }

    public function store(Request $request)
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
        ]);

        $validated['student_id'] = $student->id;
        $validated['status'] = 'pending';

        Complaint::create($validated);

        return redirect()
            ->route('student.complaints.index')
            ->with('success', 'Complaint submitted successfully.');
    }

    public function show(Complaint $complaint)
    {
        $student = auth()->user()->student;

        abort_if(!$student || $complaint->student_id !== $student->id, 403);

        return view('student.complaints.show', compact('complaint'));
    }
}
