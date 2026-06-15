<?php

namespace App\Http\Controllers\Manager;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\GatePass;
use Illuminate\Http\Request;

class GatePassController extends Controller
{
    public function index(Request $request)
    {
        $query = GatePass::with('student')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $gatePasses = $query->paginate(10)->withQueryString();

        return view('manager.gate-passes.index', compact('gatePasses'));
    }

    public function show(GatePass $gatePass)
    {
        $gatePass->load('student');

        return view('manager.gate-passes.show', compact('gatePass'));
    }

    public function approve(GatePass $gatePass)
    {
        $gatePass->update(['status' => 'approved']);
        NotificationHelper::sendToUser(
            $gatePass->student->user_id,
            'Gate Pass Approved',
            'Your gate pass request has been approved.',
            route('student.gate-passes.index'),
            'gate_pass'
        );
        return back()->with('success', 'Gate pass approved.');
    }

    public function reject(GatePass $gatePass)
    {
        $gatePass->update(['status' => 'rejected']);
        NotificationHelper::sendToUser(
            $gatePass->student->user_id,
            'Gate Pass Rejected',
            'Your gate pass request has been rejected.',
            route('student.gate-passes.index'),
            'gate_pass'
        );
        return back()->with('success', 'Gate pass rejected.');
    }
}
