<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MessMenu;
use Carbon\Carbon;

class StudentMessMenuController extends Controller
{
    public function index()
    {
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        $menus = MessMenu::with('mealSession')
            ->whereBetween('menu_date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ])
            ->orderBy('menu_date')
            ->get()
            ->groupBy(function ($menu) {
                return Carbon::parse($menu->menu_date)->format('Y-m-d');
            });

        return view('student.mess-menu.index', compact('menus', 'startDate', 'endDate'));
    }
}
