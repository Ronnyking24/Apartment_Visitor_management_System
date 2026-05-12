<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $tenant = Auth::user()->tenant;

        $query = Visit::with('visitor')
            ->where('tenant_id', $tenant->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('visitor', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('check_in_time', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('check_in_time', '<=', $request->date_to);
        }

        $visits = $query->latest()->paginate(15);

        return view('tenant.visits.index', compact('visits'));
    }

    public function show(Visit $visit)
    {
        $tenant = Auth::user()->tenant;

        if ($visit->tenant_id !== $tenant->id) {
            abort(403);
        }

        $visit->load(['visitor', 'tenant.user', 'tenant.apartment']);

        return view('tenant.visits.show', compact('visit'));
    }

    public function approve(Visit $visit)
    {
        $tenant = Auth::user()->tenant;

        if ($visit->tenant_id !== $tenant->id) {
            abort(403);
        }

        $visit->update([
            'approved_by_tenant' => true,
            'status'             => 'active',
        ]);

        return back()->with('success', 'Visit approved successfully.');
    }

    public function reject(Visit $visit)
    {
        $tenant = Auth::user()->tenant;

        if ($visit->tenant_id !== $tenant->id) {
            abort(403);
        }

        $visit->update([
            'approved_by_tenant' => false,
            'status'             => 'rejected',
        ]);

        return back()->with('success', 'Visit rejected successfully.');
    }

    public function activeVisits()
    {
        $tenant = Auth::user()->tenant;

        $visits = Visit::with('visitor')
            ->where('tenant_id', $tenant->id)
            ->where('status', 'active')
            ->latest('check_in_time')
            ->paginate(15);

        return view('tenant.visits.active', compact('visits'));
    }
}
