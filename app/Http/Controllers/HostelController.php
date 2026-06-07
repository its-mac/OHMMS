<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::latest()->paginate(10);

        return view('hostels.index', compact('hostels'));
    }

    public function create()
    {
        return view('hostels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:hostels,name',
            'type' => 'required|in:boys,girls',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        Hostel::create($validated);

        return redirect()->route('admin.hostels.index')
            ->with('success', 'Hostel created successfully.');
    }

    public function show(Hostel $hostel)
    {
        return view('hostels.show', compact('hostel'));
    }

    public function edit(Hostel $hostel)
    {
        return view('hostels.edit', compact('hostel'));
    }

    public function update(Request $request, Hostel $hostel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:hostels,name,' . $hostel->id,
            'type' => 'required|in:boys,girls',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $hostel->update($validated);

        return redirect()->route('admin.hostels.index')
            ->with('success', 'Hostel updated successfully.');
    }

    public function destroy(Hostel $hostel)
    {
        $hostel->delete();

        return redirect()->route('admin.hostels.index')
            ->with('success', 'Hostel deleted successfully.');
    }
}
