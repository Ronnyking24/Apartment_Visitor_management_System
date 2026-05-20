<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Resident::with(['user', 'apartment']);

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
        $apartments = Apartment::where('status', 'vacant')->get();
        return view('admin.tenants.create', compact('apartments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8|confirmed',
            'apartment_id' => [
                'required',
                Rule::exists('apartments', 'id')->where(fn ($q) => $q->where('status', 'vacant')),
            ],
            'phone'        => 'nullable|string|max:20',
            'national_id'  => 'nullable|string|max:50',
            'gender'       => 'nullable|in:male,female,other',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'resident',
        ]);

        Resident::create([
            'user_id'      => $user->id,
            'apartment_id' => $validated['apartment_id'],
            'phone'        => $validated['phone'] ?? null,
            'national_id'  => $validated['national_id'] ?? null,
            'gender'       => $validated['gender'] ?? null,
        ]);

        Apartment::find($validated['apartment_id'])->update(['status' => 'occupied']);

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Resident created successfully.');
    }

    public function show(Resident $tenant)
    {
        $tenant->load(['user', 'apartment', 'visits.visitor']);
        return view('admin.tenants.show', compact('tenant'));
    }

    public function edit(Resident $tenant)
    {
        $apartments = Apartment::where('status', 'vacant')
            ->orWhere('id', $tenant->apartment_id)
            ->get();
        $tenant->load('user');
        return view('admin.tenants.edit', compact('tenant', 'apartments'));
    }

    public function update(Request $request, Resident $tenant)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $tenant->user_id,
            'apartment_id' => [
                'nullable',
                Rule::exists('apartments', 'id')->where(function ($q) use ($tenant, $request) {
                    if ($request->apartment_id == $tenant->apartment_id) {
                        return $q;
                    }
                    return $q->where('status', 'vacant');
                }),
            ],
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
                $stillOccupied = Resident::where('apartment_id', $oldApartmentId)
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
            ->with('success', 'Resident updated successfully.');
    }

    public function destroy(Resident $tenant)
    {
        $apartmentId = $tenant->apartment_id;
        $tenant->user->delete();
        if (Resident::where('apartment_id', $apartmentId)->count() === 0) {
            Apartment::find($apartmentId)?->update(['status' => 'vacant']);
        }

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Resident deleted successfully.');
    }
}
