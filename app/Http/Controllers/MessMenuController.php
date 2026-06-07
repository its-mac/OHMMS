<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MealSession;
use App\Models\MessMenu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MessMenuController extends Controller
{
    public function index(Request $request)
    {
        $query = MessMenu::with('mealSession')->latest('menu_date');

        if ($request->filled('menu_date')) {
            $query->whereDate('menu_date', $request->menu_date);
        }

        if ($request->filled('meal_session_id')) {
            $query->where('meal_session_id', $request->meal_session_id);
        }

        $messMenus = $query->paginate(10);
        $mealSessions = MealSession::where('is_active', 1)->orderBy('start_time')->get();

        return view('mess-menus.index', compact('messMenus', 'mealSessions'));
    }

    public function create()
    {
        $mealSessions = MealSession::where('is_active', 1)->orderBy('start_time')->get();

        return view('mess-menus.create', compact('mealSessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_session_id' => [
                'required',
                'exists:meal_sessions,id',
                Rule::unique('mess_menus')->where(function ($query) use ($request) {
                    return $query
                        ->where('meal_session_id', $request->meal_session_id)
                        ->where('menu_date', $request->menu_date);
                }),
            ],
            'menu_date' => ['required', 'date'],
            'menu_items' => ['required', 'string', 'max:2000'],
        ], [
            'meal_session_id.unique' => 'Menu already exists for this meal session on selected date.',
        ]);

        MessMenu::create($validated);

        return redirect()
            ->route('admin.mess-menus.index')
            ->with('success', 'Mess menu created successfully.');
    }

    public function show(MessMenu $messMenu)
    {
        $messMenu->load('mealSession');

        return view('mess-menus.show', compact('messMenu'));
    }

    public function edit(MessMenu $messMenu)
    {
        $mealSessions = MealSession::where('is_active', 1)->orderBy('start_time')->get();

        return view('mess-menus.edit', compact('messMenu', 'mealSessions'));
    }

    public function update(Request $request, MessMenu $messMenu)
    {
        $validated = $request->validate([
            'meal_session_id' => [
                'required',
                'exists:meal_sessions,id',
                Rule::unique('mess_menus')->where(function ($query) use ($request) {
                    return $query
                        ->where('meal_session_id', $request->meal_session_id)
                        ->where('menu_date', $request->menu_date);
                })->ignore($messMenu->id),
            ],
            'menu_date' => ['required', 'date'],
            'menu_items' => ['required', 'string', 'max:2000'],
        ], [
            'meal_session_id.unique' => 'Menu already exists for this meal session on selected date.',
        ]);

        $messMenu->update($validated);

        return redirect()
            ->route('admin.mess-menus.index')
            ->with('success', 'Mess menu updated successfully.');
    }

    public function destroy(MessMenu $messMenu)
    {
        $messMenu->delete();

        return redirect()
            ->route('admin.mess-menus.index')
            ->with('success', 'Mess menu deleted successfully.');
    }
}
