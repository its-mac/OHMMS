<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\GuestMeal;
use App\Models\MealSession;
use Illuminate\Http\Request;

class StudentGuestMealController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        $guestMeals = GuestMeal::with('mealSession')
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.guest-meals.index', compact('guestMeals'));
    }

    public function create()
    {
        $mealSessions = MealSession::where('is_active', 1)
            ->orderBy('start_time')
            ->get();

        return view('student.guest-meals.create', compact('mealSessions'));
    }

    public function store(Request $request)
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404, 'Student profile not found.');

        $validated = $request->validate([
            'meal_session_id' => ['required', 'exists:meal_sessions,id'],
            'meal_date' => ['required', 'date', 'after_or_equal:today'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:10'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['student_id'] = $student->id;
        $validated['status'] = 'pending';

        GuestMeal::create($validated);

        return redirect()
            ->route('student.guest-meals.index')
            ->with('success', 'Guest meal request submitted successfully.');
    }

    public function show(GuestMeal $guestMeal)
    {
        $student = auth()->user()->student;

        abort_if(!$student || $guestMeal->student_id !== $student->id, 403);

        $guestMeal->load('mealSession');

        return view('student.guest-meals.show', compact('guestMeal'));
    }
}
