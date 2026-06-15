<?php

namespace App\Http\Controllers\Student;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\GatePass;
use Illuminate\Http\Request;

class StudentGatePassController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $gatePasses = GatePass::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.gate-passes.index', compact('gatePasses'));
    }

    public function create()
    {
        return view('student.gate-passes.create');
    }

    public function store(Request $request)
    {
        $student = auth()->user()->student;

        abort_if(!$student, 404);

        $validated = $request->validate([
            'out_time' => ['required', 'date', 'after_or_equal:now'],
            'expected_return_time' => ['required', 'date', 'after:out_time'],
            'destination' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string', 'max:255'],
            'contact_during_outing' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['student_id'] = $student->id;
        $validated['status'] = 'pending';

        GatePass::create($validated);
        NotificationHelper::sendToRole(
            'manager',
            'New Gate Pass Request',
            auth()->user()->name . ' submitted a new gate pass request.',
            route('manager.gate-passes.index'),
            'gate_pass'
        );

        return redirect()
            ->route('student.gate-passes.index')
            ->with('success', 'Gate pass request submitted successfully.');
    }

    public function show(GatePass $gatePass)
    {
        $student = auth()->user()->student;

        abort_if(!$student || $gatePass->student_id !== $student->id, 403);

        return view('student.gate-passes.show', compact('gatePass'));
    }
}
