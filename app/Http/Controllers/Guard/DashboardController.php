<?php

namespace App\Http\Controllers\Guard;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $activeVisits = Visit::with(['visitor', 'tenant.user', 'tenant.apartment'])
            ->where('status', 'active')
            ->latest('check_in_time')
            ->get();

        $todayVisits = Visit::with(['visitor', 'tenant.user', 'tenant.apartment'])
            ->whereDate('created_at', today())
            ->latest()
            ->get();

        $totalToday  = $todayVisits->count();
        $totalActive = $activeVisits->count();
        $totalVisitors = Visitor::count();

        $completedToday = Visit::where('status', 'completed')
            ->whereDate('check_out_time', today())
            ->count();

        return view('guard.dashboard', compact(
            'activeVisits', 'todayVisits',
            'totalToday', 'totalActive', 'totalVisitors', 'completedToday'
        ));
    }
}
