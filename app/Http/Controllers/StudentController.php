<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_no' => 'required|string|max:255|unique:students,registration_no',
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'cnic' => 'nullable|string|max:255|unique:students,cnic',
            'department' => 'nullable|string|max:255',
            'session' => 'nullable|string|max:255',
            'hostel' => 'nullable|string|max:255',
            'room_no' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:students,email|unique:users,email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'blood_group' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        DB::transaction(function () use (&$validated) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => 'student',
                'password' => Hash::make($validated['registration_no']),
            ]);

            $validated['user_id'] = $user->id;

            Student::create($validated);
        });

        return redirect()->route('admin.students.index')
            ->with(
                'success',
                'Student created successfully. Login password is Registration Number.'
            );
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'registration_no' => 'required|string|max:255|unique:students,registration_no,' . $student->id,
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'cnic' => 'nullable|string|max:255|unique:students,cnic,' . $student->id,
            'department' => 'nullable|string|max:255',
            'session' => 'nullable|string|max:255',
            'hostel' => 'nullable|string|max:255',
            'room_no' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'blood_group' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }

            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        if ($student->user) {

            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
        }

        $student->update($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        DB::transaction(function () use ($student) {

            $user = $student->user;

            $student->delete();

            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    public function show(Student $student)
    {
        $student->load('fingerprints', 'attendanceLogs.mealSession', 'activeRoomAllocation.room.floor.block.hostel');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

}
