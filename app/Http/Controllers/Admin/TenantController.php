<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::with(['user', 'apartment']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('apartment', function ($q) use ($search) {
                $q->where('apartment_number', 'like', "%{$search}%");
            })->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('national_id', 'like', "%{$search}%");
        }

        $tenants = $query->latest()->paginate(15);

        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $apartments = Apartment::where('status', 'vacant')->orWhere('status', 'occupied')->get();
        return view('admin.tenants.create', compact('apartments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8|confirmed',
            'apartment_id' => 'required|exists:apartments,id',
            'phone'        => 'nullable|string|max:20',
            'national_id'  => 'nullable|string|max:50',
            'gender'       => 'nullable|in:male,female,other',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'tenant',
        ]);

        Tenant::create([
            'user_id'      => $user->id,
            'apartment_id' => $validated['apartment_id'],
            'phone'        => $validated['phone'] ?? null,
            'national_id'  => $validated['national_id'] ?? null,
            'gender'       => $validated['gender'] ?? null,
        ]);

        Apartment::find($validated['apartment_id'])->update(['status' => 'occupied']);

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant created successfully.');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load(['user', 'apartment', 'visits.visitor']);
        return view('admin.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        $apartments = Apartment::all();
        $tenant->load('user');
        return view('admin.tenants.edit', compact('tenant', 'apartments'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $tenant->user_id,
            'apartment_id' => 'nullable|exists:apartments,id',
            'phone'        => 'nullable|string|max:20',
            'national_id'  => 'nullable|string|max:50',
            'gender'       => 'nullable|in:male,female,other',
            'password'     => 'nullable|min:8|confirmed',
        ]);

        $userUpdate = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ];
        if (!empty($validated['password'])) {
            $userUpdate['password'] = Hash::make($validated['password']);
        }
        $tenant->user->update($userUpdate);

        $oldApartmentId = $tenant->apartment_id;
        $newApartmentId = $validated['apartment_id'] ?? null;

        $tenant->update([
            'apartment_id' => $newApartmentId,
            'phone'        => $validated['phone'] ?? null,
            'national_id'  => $validated['national_id'] ?? null,
            'gender'       => $validated['gender'] ?? null,
        ]);

        // Sync apartment statuses when the assignment changes
        if ($oldApartmentId !== $newApartmentId) {
            // Free the previously assigned apartment if no other tenant occupies it
            if ($oldApartmentId) {
                $stillOccupied = Tenant::where('apartment_id', $oldApartmentId)
                    ->where('id', '!=', $tenant->id)
                    ->exists();
                if (!$stillOccupied) {
                    Apartment::find($oldApartmentId)?->update(['status' => 'vacant']);
                }
            }
            // Mark the newly assigned apartment as occupied
            if ($newApartmentId) {
                Apartment::find($newApartmentId)?->update(['status' => 'occupied']);
            }
        }

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant updated successfully.');
    }

    public function destroy(Tenant $tenant)
    {
        $apartmentId = $tenant->apartment_id;
        $tenant->user->delete();

        if (Tenant::where('apartment_id', $apartmentId)->count() === 0) {
            Apartment::find($apartmentId)?->update(['status' => 'vacant']);
        }

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant deleted successfully.');
    }
}
