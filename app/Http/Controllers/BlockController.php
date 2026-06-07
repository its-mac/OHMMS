<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::with('hostel')->latest()->paginate(10);

        return view('blocks.index', compact('blocks'));
    }

    public function create()
    {
        $hostels = Hostel::where('status', 'active')->orderBy('name')->get();

        return view('blocks.create', compact('hostels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blocks', 'name')->where('hostel_id', $request->hostel_id),
            ],
            'status' => 'required|in:active,inactive',
        ]);

        Block::create($validated);

        return redirect()->route('admin.blocks.index')
            ->with('success', 'Block created successfully.');
    }

    public function show(Block $block)
    {
        $block->load('hostel');

        return view('blocks.show', compact('block'));
    }

    public function edit(Block $block)
    {
        $hostels = Hostel::where('status', 'active')->orderBy('name')->get();

        return view('blocks.edit', compact('block', 'hostels'));
    }

    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'hostel_id' => 'required|exists:hostels,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blocks', 'name')
                    ->where('hostel_id', $request->hostel_id)
                    ->ignore($block->id),
            ],
            'status' => 'required|in:active,inactive',
        ]);

        $block->update($validated);

        return redirect()->route('admin.blocks.index')
            ->with('success', 'Block updated successfully.');
    }

    public function destroy(Block $block)
    {
        $block->delete();

        return redirect()->route('admin.blocks.index')
            ->with('success', 'Block deleted successfully.');
    }
}
