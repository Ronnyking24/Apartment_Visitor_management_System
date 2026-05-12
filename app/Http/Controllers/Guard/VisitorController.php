<?php

namespace App\Http\Controllers\Guard;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::with('latestVisit');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $visitors = $query->latest()->paginate(15);

        return view('guard.visitors.index', compact('visitors'));
    }

    public function create()
    {
        $tenants = Tenant::with(['user', 'apartment'])->get();
        return view('guard.visitors.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'national_id'  => 'nullable|string|max:50',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tenant_id'    => 'required|exists:tenants,id',
            'purpose'      => 'required|string|max:500',
        ]);

        // Check if visitor already exists by national_id
        $visitor = null;
        if (!empty($validated['national_id'])) {
            $visitor = Visitor::where('national_id', $validated['national_id'])->first();
        }

        // Block check-in if this visitor already has an active visit anywhere
        if ($visitor) {
            $activeVisit = Visit::where('visitor_id', $visitor->id)
                ->where('status', 'active')
                ->with('tenant.apartment')
                ->first();

            if ($activeVisit) {
                $apt = $activeVisit->tenant->apartment->apartment_number ?? 'unknown apartment';
                return back()
                    ->withInput()
                    ->withErrors(['national_id' => "This visitor is already checked in at Apt {$apt}. Check them out first before registering a new visit."]);
            }
        }

        if (!$visitor) {
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('visitors', 'public');
            }

            $visitor = Visitor::create([
                'full_name'    => $validated['full_name'],
                'phone_number' => $validated['phone_number'] ?? null,
                'national_id'  => $validated['national_id'] ?? null,
                'photo'        => $photoPath,
            ]);
        }

        $visit = Visit::create([
            'visitor_id'        => $visitor->id,
            'tenant_id'         => $validated['tenant_id'],
            'purpose'           => $validated['purpose'],
            'check_in_time'     => now(),
            'status'            => 'active',
            'approved_by_tenant' => false,
        ]);

        return redirect()->route('guard.visits.show', $visit)
            ->with('success', 'Visitor checked in successfully.');
    }

    public function show(Visitor $visitor)
    {
        $visitor->load(['visits.tenant.user', 'visits.tenant.apartment']);
        return view('guard.visitors.show', compact('visitor'));
    }

    public function activeVisitors()
    {
        $visits = Visit::with(['visitor', 'tenant.user', 'tenant.apartment'])
            ->where('status', 'active')
            ->latest('check_in_time')
            ->paginate(15);

        return view('guard.visitors.active', compact('visits'));
    }

    public function logs(Request $request)
    {
        $query = Visit::with(['visitor', 'tenant.user', 'tenant.apartment'])
            ->whereDate('check_in_time', today());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('visitor', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%");
            });
        }

        $visits = $query->latest()->paginate(15);

        return view('guard.visitors.logs', compact('visits'));
    }

    public function exportLogs(Request $request)
    {
        $query = Visit::with(['visitor', 'tenant.user', 'tenant.apartment'])
            ->whereDate('check_in_time', today());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('visitor', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%");
            });
        }

        $visits = $query->latest()->get();
        $date   = now()->format('F d, Y');

        $pdf = Pdf::loadView('guard.visitors.logs-pdf', compact('visits', 'date'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('visitor-logs-'.now()->format('Y-m-d').'.pdf');
    }
}
