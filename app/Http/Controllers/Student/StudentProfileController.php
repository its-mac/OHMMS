<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function show()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        return view('student.profile.show', compact('student'));
    }

    public function edit()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        return view('student.profile.edit', compact('student'));
    }

    public function update(Request $request)
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        $validated = $request->validate([
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }

            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($validated);

        return redirect()
            ->route('student.profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}
