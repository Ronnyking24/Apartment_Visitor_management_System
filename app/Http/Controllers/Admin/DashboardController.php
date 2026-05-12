<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalApartments = Apartment::count();
        $totalTenants = Tenant::count();
        $totalVisitors = Visitor::count();
        $activeVisits = Visit::where('status', 'active')->count();
        $totalVisits = Visit::count();
        $totalGuards = User::where('role', 'guard')->count();

        $recentVisits = Visit::with(['visitor', 'tenant.user', 'tenant.apartment'])
            ->latest()
            ->take(10)
            ->get();

        $todayVisits = Visit::whereDate('created_at', today())->count();
        $monthlyVisits = Visit::whereMonth('created_at', now()->month)->count();

        // Action-required items for notification panel
        $unassignedTenants = Tenant::with('user')->whereNull('apartment_id')->get();
        $pendingGuards     = User::where('role', 'guard')->where('status', 'pending')->get();

        // Chart data - last 7 days
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('D');
            $chartData[] = Visit::whereDate('created_at', $date)->count();
        }

        // Visit status distribution
        $statusData = [
            Visit::where('status', 'active')->count(),
            Visit::where('status', 'completed')->count(),
            Visit::where('status', 'pending')->count(),
            Visit::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalApartments', 'totalTenants', 'totalVisitors',
            'activeVisits', 'totalVisits', 'totalGuards',
            'recentVisits', 'todayVisits', 'monthlyVisits',
            'chartLabels', 'chartData', 'statusData',
            'unassignedTenants', 'pendingGuards'
        ));
    }
}
