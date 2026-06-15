<?php

namespace App\Http\Controllers\Manager;

use App\Helpers\NotificationHelper;
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
        NotificationHelper::sendToUser(
            $messOff->student->user_id,
            'Mess Off Approved',
            'Your mess off request has been approved.',
            route('student.mess-offs.index'),
            'mess_off'
        );

        return back()->with('success', 'Mess off request approved.');
    }

    public function reject(MessOff $messOff)
    {
        $messOff->update(['status' => 'rejected']);
        NotificationHelper::sendToUser(
            $messOff->student->user_id,
            'Mess Off Rejected',
            'Your mess off request has been rejected.',
            route('student.mess-offs.index'),
            'mess_off'
        );

        return back()->with('success', 'Mess off request rejected.');
    }
}
