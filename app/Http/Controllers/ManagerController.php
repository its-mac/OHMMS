<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = User::where('role', 'manager')->latest()->paginate(10);

        return view('managers.index', compact('managers'));
    }

    public function create()
    {
        return view('managers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => 'manager',
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Manager created successfully.');
    }

    public function edit(User $manager)
    {
        abort_if($manager->role !== 'manager', 404);

        return view('managers.edit', compact('manager'));
    }

    public function update(Request $request, User $manager)
    {
        abort_if($manager->role !== 'manager', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($manager->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $manager->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => !empty($validated['password'])
                ? Hash::make($validated['password'])
                : $manager->password,
        ]);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Manager updated successfully.');
    }

    public function destroy(User $manager)
    {
        abort_if($manager->role !== 'manager', 404);

        $manager->delete();

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Manager deleted successfully.');
    }
}
