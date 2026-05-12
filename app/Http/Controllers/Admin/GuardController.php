<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'guard');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $guards = $query->latest()->paginate(15);

        return view('admin.guards.index', compact('guards'));
    }

    public function create()
    {
        return view('admin.guards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'guard',
            'status'   => 'active',
        ]);

        return redirect()->route('admin.guards.index')
            ->with('success', 'Guard created successfully.');
    }

    public function edit(User $guard)
    {
        return view('admin.guards.edit', compact('guard'));
    }

    public function update(Request $request, User $guard)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $guard->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $updateData = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ];
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $guard->update($updateData);

        return redirect()->route('admin.guards.index')
            ->with('success', 'Guard updated successfully.');
    }

    public function destroy(User $guard)
    {
        $guard->delete();

        return redirect()->route('admin.guards.index')
            ->with('success', 'Guard deleted successfully.');
    }

    public function approve(User $guard)
    {
        $guard->update(['status' => 'active']);

        return redirect()->route('admin.guards.index')
            ->with('success', "Guard account for {$guard->name} has been approved and activated.");
    }

    public function suspend(User $guard)
    {
        $guard->update(['status' => 'suspended']);

        return redirect()->route('admin.guards.index')
            ->with('success', "Guard account for {$guard->name} has been suspended.");
    }

    public function activate(User $guard)
    {
        $guard->update(['status' => 'active']);

        return redirect()->route('admin.guards.index')
            ->with('success', "Guard account for {$guard->name} has been reactivated.");
    }
}
