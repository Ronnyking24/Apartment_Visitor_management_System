<?php

namespace App\Http\Controllers\Guard;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function show(Visit $visit)
    {
        $visit->load(['visitor', 'tenant.user', 'tenant.apartment']);
        return view('guard.visits.show', compact('visit'));
    }

    public function checkOut(Visit $visit)
    {
        if ($visit->status !== 'active') {
            return back()->with('error', 'This visit is not active.');
        }

        $visit->update([
            'check_out_time' => now(),
            'status'         => 'completed',
        ]);

        return redirect()->route('guard.dashboard')
            ->with('success', 'Visitor checked out successfully.');
    }
}
