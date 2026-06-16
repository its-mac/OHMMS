<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class EscalatedComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('student')
            ->where('is_escalated', true)
            ->latest('escalated_at')
            ->paginate(10);

        return view('admin.complaints.escalated-index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        abort_if(!$complaint->is_escalated, 404);

        $complaint->load('student');

        return view('admin.complaints.escalated-show', compact('complaint'));
    }

    public function review(Request $request, Complaint $complaint)
    {
        abort_if(!$complaint->is_escalated, 404);

        $validated = $request->validate([
            'admin_response' => ['required', 'string', 'max:2000'],
            'status' => ['required', 'in:in_progress,resolved,rejected'],
        ]);

        $complaint->update([
            'admin_response' => $validated['admin_response'],
            'admin_reviewed_at' => now(),
            'status' => $validated['status'],
        ]);

        if ($complaint->student?->user_id) {
            NotificationHelper::sendToUser(
                $complaint->student->user_id,
                'Escalated Complaint Reviewed',
                'Admin has reviewed your escalated complaint.',
                route('student.complaints.index'),
                'complaint'
            );
        }

        return redirect()
            ->route('admin.complaints.escalated.show', $complaint)
            ->with('success', 'Escalated complaint reviewed successfully.');
    }
}
