<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Visitor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Visit::with(['visitor', 'tenant.user', 'tenant.apartment']);

        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to ?? now()->toDateString();

        $query->whereBetween(DB::raw('DATE(check_in_time)'), [$dateFrom, $dateTo]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $visits = $query->latest()->paginate(20);

        $totalVisits    = $query->count();
        $activeVisits   = Visit::where('status', 'active')->count();
        $completedVisits = Visit::where('status', 'completed')
            ->whereBetween(DB::raw('DATE(check_in_time)'), [$dateFrom, $dateTo])
            ->count();

        // Monthly chart data
        $monthlyData = [];
        $monthlyLabels = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = date('M', mktime(0, 0, 0, $m, 1));
            $monthlyData[] = Visit::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)->count();
        }

        return view('admin.reports.index', compact(
            'visits', 'dateFrom', 'dateTo',
            'totalVisits', 'activeVisits', 'completedVisits',
            'monthlyData', 'monthlyLabels'
        ));
    }

    public function exportPdf(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to ?? now()->toDateString();

        $visits = Visit::with(['visitor', 'tenant.user', 'tenant.apartment'])
            ->whereBetween(DB::raw('DATE(check_in_time)'), [$dateFrom, $dateTo])
            ->latest()->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('visits', 'dateFrom', 'dateTo'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("visitor-report-{$dateFrom}-to-{$dateTo}.pdf");
    }
}
