<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = Auth::user()->tenant;

        // Tenant profile always exists after registration, but apartment may not be assigned yet
        if (!$tenant) {
            return view('tenant.setup');
        }

        $activeVisits = Visit::with('visitor')
            ->where('tenant_id', $tenant->id)
            ->where('status', 'active')
            ->latest('check_in_time')
            ->get();

        $recentVisits = Visit::with('visitor')
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->take(10)
            ->get();

        $totalVisits   = Visit::where('tenant_id', $tenant->id)->count();
        $pendingVisits = Visit::where('tenant_id', $tenant->id)->where('status', 'pending')->count();
        $todayVisits   = Visit::where('tenant_id', $tenant->id)->whereDate('created_at', today())->count();

        return view('tenant.dashboard', compact(
            'tenant', 'activeVisits', 'recentVisits',
            'totalVisits', 'pendingVisits', 'todayVisits'
        ));
    }
}
