<?php

namespace App\Http\Controllers\Manager;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('student')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $complaints = $query->paginate(10)->withQueryString();

        return view('manager.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load('student');

        return view('manager.complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,in_progress,resolved,rejected'],
            'manager_response' => ['nullable', 'string', 'max:2000'],
        ]);

        $complaint->update($validated);
        NotificationHelper::sendToUser(
            $complaint->student->user_id,
            'Complaint Status Updated',
            'The status of your complaint has been updated to: ' . ucfirst($complaint->status) . '.',
            route('student.complaints.index'),
            'complaint'
        );

        return redirect()
            ->route('manager.complaints.show', $complaint)
            ->with('success', 'Complaint status updated successfully.');
    }
}
