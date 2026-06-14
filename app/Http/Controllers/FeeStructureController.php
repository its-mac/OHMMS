<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        $feeStructures = FeeStructure::latest()->paginate(10);

        return view('fee-structures.index', compact('feeStructures'));
    }

    public function create()
    {
        return view('fee-structures.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:fee_structures,name'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        FeeStructure::create($validated);

        return redirect()
            ->route('admin.fee-structures.index')
            ->with('success', 'Fee structure created successfully.');
    }

    public function show(FeeStructure $feeStructure)
    {
        return view('fee-structures.show', compact('feeStructure'));
    }

    public function edit(FeeStructure $feeStructure)
    {
        return view('fee-structures.edit', compact('feeStructure'));
    }

    public function update(Request $request, FeeStructure $feeStructure)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:fee_structures,name,' . $feeStructure->id],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $feeStructure->update($validated);

        return redirect()
            ->route('admin.fee-structures.index')
            ->with('success', 'Fee structure updated successfully.');
    }

    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();

        return redirect()
            ->route('admin.fee-structures.index')
            ->with('success', 'Fee structure deleted successfully.');
    }
}
