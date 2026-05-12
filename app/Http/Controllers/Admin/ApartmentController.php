<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Apartment::withCount('tenants');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('apartment_number', 'like', "%{$search}%")
                  ->orWhere('block_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $apartments = $query->orderBy('block_name')->orderBy('apartment_number')->paginate(15);

        return view('admin.apartments.index', compact('apartments'));
    }

    public function create()
    {
        return view('admin.apartments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'apartment_number' => 'required|string|unique:apartments,apartment_number',
            'block_name'       => 'required|string|max:100',
            'floor_number'     => 'required|integer|min:0',
            'status'           => 'required|in:occupied,vacant',
            'notes'            => 'nullable|string',
        ]);

        Apartment::create($validated);

        return redirect()->route('admin.apartments.index')
            ->with('success', 'Apartment created successfully.');
    }

    public function show(Apartment $apartment)
    {
        $apartment->load(['tenants.user', 'tenants.visits.visitor']);
        return view('admin.apartments.show', compact('apartment'));
    }

    public function edit(Apartment $apartment)
    {
        return view('admin.apartments.edit', compact('apartment'));
    }

    public function update(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'apartment_number' => 'required|string|unique:apartments,apartment_number,' . $apartment->id,
            'block_name'       => 'required|string|max:100',
            'floor_number'     => 'required|integer|min:0',
            'status'           => 'required|in:occupied,vacant',
            'notes'            => 'nullable|string',
        ]);

        $apartment->update($validated);

        return redirect()->route('admin.apartments.index')
            ->with('success', 'Apartment updated successfully.');
    }

    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('admin.apartments.index')
            ->with('success', 'Apartment deleted successfully.');
    }
}
