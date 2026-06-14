<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\MessOff;
use Illuminate\Http\Request;

class MessOffController extends Controller
{
    public function index(Request $request)
    {
        $query = MessOff::with('student')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        $messOffs = $query->paginate(10)->withQueryString();

        return view('manager.mess-offs.index', compact('messOffs'));
    }

    public function show(MessOff $messOff)
    {
        $messOff->load('student');

        return view('manager.mess-offs.show', compact('messOff'));
    }

    public function approve(MessOff $messOff)
    {
        $messOff->update(['status' => 'approved']);

        return back()->with('success', 'Mess off request approved.');
    }

    public function reject(MessOff $messOff)
    {
        $messOff->update(['status' => 'rejected']);

        return back()->with('success', 'Mess off request rejected.');
    }
}
