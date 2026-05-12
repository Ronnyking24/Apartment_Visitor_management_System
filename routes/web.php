<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Guard;
use App\Http\Controllers\Tenant;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'guard') return redirect()->route('guard.dashboard');
        return redirect()->route('tenant.dashboard');
    }
    return redirect()->route('login');
});

// Fallback route named 'dashboard' used internally by Breeze middleware
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'guard') return redirect()->route('guard.dashboard');
        return redirect()->route('tenant.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// ─────────────────────────────────────────────
// PENDING APPROVAL PAGE
// ─────────────────────────────────────────────
Route::get('/pending-approval', function () {
    if (!auth()->check()) return redirect()->route('login');
    if (auth()->user()->isActive()) {
        $role = auth()->user()->role;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'guard') return redirect()->route('guard.dashboard');
        return redirect()->route('tenant.dashboard');
    }
    return view('auth.pending');
})->middleware('auth')->name('auth.pending');

// ─────────────────────────────────────────────
// ADMIN ROUTES
// ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Apartments
    Route::resource('apartments', Admin\ApartmentController::class);

    // Tenants
    Route::resource('tenants', Admin\TenantController::class);

    // Guards
    Route::resource('guards', Admin\GuardController::class)->except(['show']);
    Route::patch('guards/{guard}/approve',  [Admin\GuardController::class, 'approve'])->name('guards.approve');
    Route::patch('guards/{guard}/suspend',  [Admin\GuardController::class, 'suspend'])->name('guards.suspend');
    Route::patch('guards/{guard}/activate', [Admin\GuardController::class, 'activate'])->name('guards.activate');

    // Visitors
    Route::get('visitors',        [Admin\VisitorController::class, 'index'])->name('visitors.index');
    Route::get('visitors/{visitor}', [Admin\VisitorController::class, 'show'])->name('visitors.show');
    Route::delete('visitors/{visitor}', [Admin\VisitorController::class, 'destroy'])->name('visitors.destroy');

    // Visits
    Route::get('visits', [Admin\VisitorController::class, 'visits'])->name('visits.index');

    // Reports
    Route::get('reports',        [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [Admin\ReportController::class, 'exportPdf'])->name('reports.export');
});

// ─────────────────────────────────────────────
// GUARD ROUTES
// ─────────────────────────────────────────────
Route::prefix('guard')->name('guard.')->middleware(['auth', 'role:guard'])->group(function () {

    Route::get('/dashboard', [Guard\DashboardController::class, 'index'])->name('dashboard');

    // Visitor management
    Route::get('visitors',              [Guard\VisitorController::class, 'index'])->name('visitors.index');
    Route::get('visitors/create',       [Guard\VisitorController::class, 'create'])->name('visitors.create');
    Route::post('visitors',             [Guard\VisitorController::class, 'store'])->name('visitors.store');
    Route::get('visitors/active',       [Guard\VisitorController::class, 'activeVisitors'])->name('visitors.active');
    Route::get('visitors/logs',         [Guard\VisitorController::class, 'logs'])->name('visitors.logs');
    Route::get('visitors/logs/export',  [Guard\VisitorController::class, 'exportLogs'])->name('visitors.logs.export');
    Route::get('visitors/{visitor}',    [Guard\VisitorController::class, 'show'])->name('visitors.show');

    // Visit actions
    Route::get('visits/{visit}',        [Guard\VisitController::class, 'show'])->name('visits.show');
    Route::patch('visits/{visit}/checkout', [Guard\VisitController::class, 'checkOut'])->name('visits.checkout');
});

// ─────────────────────────────────────────────
// TENANT ROUTES
// ─────────────────────────────────────────────
Route::prefix('tenant')->name('tenant.')->middleware(['auth', 'role:tenant'])->group(function () {

    Route::get('/dashboard', [Tenant\DashboardController::class, 'index'])->name('dashboard');

    Route::get('visits',                    [Tenant\VisitController::class, 'index'])->name('visits.index');
    Route::get('visits/active',             [Tenant\VisitController::class, 'activeVisits'])->name('visits.active');
    Route::get('visits/{visit}',            [Tenant\VisitController::class, 'show'])->name('visits.show');
    Route::patch('visits/{visit}/approve',  [Tenant\VisitController::class, 'approve'])->name('visits.approve');
    Route::patch('visits/{visit}/reject',   [Tenant\VisitController::class, 'reject'])->name('visits.reject');
});

require __DIR__.'/auth.php';
