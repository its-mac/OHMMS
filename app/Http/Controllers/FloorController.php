<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::with('block.hostel')
            ->latest()
            ->paginate(10);

        return view('floors.index', compact('floors'));
    }

    public function create()
    {
        $blocks = Block::with('hostel')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('floors.create', compact('blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('floors', 'name')
                    ->where('block_id', $request->block_id),
            ],

            'status' => 'required|in:active,inactive',
        ]);

        Floor::create($validated);

        return redirect()
            ->route('admin.floors.index')
            ->with('success', 'Floor created successfully.');
    }

    public function show(Floor $floor)
    {
        $floor->load('block.hostel');

        return view('floors.show', compact('floor'));
    }

    public function edit(Floor $floor)
    {
        $blocks = Block::with('hostel')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('floors.edit', compact('floor', 'blocks'));
    }

    public function update(Request $request, Floor $floor)
    {
        $validated = $request->validate([
            'block_id' => 'required|exists:blocks,id',

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('floors', 'name')
                    ->where('block_id', $request->block_id)
                    ->ignore($floor->id),
            ],

            'status' => 'required|in:active,inactive',
        ]);

        $floor->update($validated);

        return redirect()
            ->route('admin.floors.index')
            ->with('success', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        $floor->delete();

        return redirect()
            ->route('admin.floors.index')
            ->with('success', 'Floor deleted successfully.');
    }
}
