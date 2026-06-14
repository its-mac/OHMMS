<?php

namespace App\Http\Controllers;

use App\Models\GuestMeal;
use App\Models\MealSession;
use Illuminate\Http\Request;

class GuestMealController extends Controller
{
    public function index(Request $request)
    {
        $query = GuestMeal::with(['student', 'mealSession'])->latest();

        if ($request->filled('meal_date')) {
            $query->whereDate('meal_date', $request->meal_date);
        }

        if ($request->filled('meal_session_id')) {
            $query->where('meal_session_id', $request->meal_session_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $guestMeals = $query->paginate(10)->withQueryString();

        $mealSessions = MealSession::where('is_active', 1)
            ->orderBy('start_time')
            ->get();

        return view('guest-meals.index', compact('guestMeals', 'mealSessions'));
    }

    public function show(GuestMeal $guestMeal)
    {
        $guestMeal->load(['student', 'mealSession']);

        return view('guest-meals.show', compact('guestMeal'));
    }

    public function approve(GuestMeal $guestMeal)
    {
        $guestMeal->update(['status' => 'approved']);

        return back()->with('success', 'Guest meal request approved.');
    }

    public function reject(GuestMeal $guestMeal)
    {
        $guestMeal->update(['status' => 'rejected']);

        return back()->with('success', 'Guest meal request rejected.');
    }

    public function reports(Request $request)
    {
        $query = GuestMeal::with(['student', 'mealSession'])
            ->where('status', 'approved');

        if ($request->filled('from_date')) {
            $query->whereDate('meal_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('meal_date', '<=', $request->to_date);
        }

        if ($request->filled('meal_session_id')) {
            $query->where('meal_session_id', $request->meal_session_id);
        }

        $guestMeals = $query->latest('meal_date')->paginate(10)->withQueryString();

        $totalRequests = (clone $query)->count();
        $totalGuests = (clone $query)->sum('guest_count');

        $mealSessions = MealSession::where('is_active', 1)
            ->orderBy('start_time')
            ->get();

        return view('guest-meals.reports', compact(
            'guestMeals',
            'mealSessions',
            'totalRequests',
            'totalGuests'
        ));
    }
}
