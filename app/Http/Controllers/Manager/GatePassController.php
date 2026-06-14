<?php

namespace App\Http\Controllers\Manager;

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

        return back()->with('success', 'Gate pass approved.');
    }

    public function reject(GatePass $gatePass)
    {
        $gatePass->update(['status' => 'rejected']);

        return back()->with('success', 'Gate pass rejected.');
    }
}
