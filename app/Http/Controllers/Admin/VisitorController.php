<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::withCount('visits');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $visitors = $query->latest()->paginate(15);

        return view('admin.visitors.index', compact('visitors'));
    }

    public function show(Visitor $visitor)
    {
        $visits = $visitor->visits()
            ->with(['tenant.user', 'tenant.apartment'])
            ->latest()
            ->paginate(10);

        return view('admin.visitors.show', compact('visitor', 'visits'));
    }

    public function destroy(Visitor $visitor)
    {
        if ($visitor->photo) {
            Storage::disk('public')->delete($visitor->photo);
        }
        $visitor->delete();

        return redirect()->route('admin.visitors.index')
            ->with('success', 'Visitor deleted successfully.');
    }

    public function visits(Request $request)
    {
        $query = Visit::with(['visitor', 'tenant.user', 'tenant.apartment']);

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

        return view('admin.visits.index', compact('visits'));
    }
}
