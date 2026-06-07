<?php

namespace App\Http\Controllers;

use App\Models\MealSession;
use Illuminate\Http\Request;

class MealSessionController extends Controller
{
    public function index()
    {
        $mealSessions = MealSession::latest()->paginate(10);

        return view('meal-sessions.index', compact('mealSessions'));
    }

    public function create()
    {
        return view('meal-sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'is_active' => 'required|boolean',
        ]);

        MealSession::create($validated);

        return redirect()
            ->route('admin.meal-sessions.index')
            ->with('success', 'Meal session created successfully.');
    }

    public function show(MealSession $mealSession)
    {
        return view('meal-sessions.show', compact('mealSession'));
    }

    public function edit(MealSession $mealSession)
    {
        return view('meal-sessions.edit', compact('mealSession'));
    }

    public function update(Request $request, MealSession $mealSession)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'is_active' => 'required|boolean',
        ]);

        $mealSession->update($validated);

        return redirect()
            ->route('admin.meal-sessions.index')
            ->with('success', 'Meal session updated successfully.');
    }

    public function destroy(MealSession $mealSession)
    {
        $mealSession->delete();

        return redirect()
            ->route('admin.meal-sessions.index')
            ->with('success', 'Meal session deleted successfully.');
    }
}
