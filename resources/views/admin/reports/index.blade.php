@extends('layouts.dashboard')
@section('title','Reports')
@section('page-title','Reports')

@push('styles')
<style>
/* ── REPORTS ── */
.rp-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:20px; position:relative; overflow:hidden; }
.rp-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.rp-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.rp-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.rp-head-actions { display:flex; gap:8px; flex-wrap:wrap; }
.rp-pdf-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; background:#ef4444; color:#fff; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s; }
.rp-pdf-btn:hover { background:#dc2626; color:#fff; transform:translateY(-1px); }
.rp-date-chip { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); border-radius:10px; color:#fff; font-size:12px; font-weight:600; }

/* Stats strip */
.rp-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
.rp-stat { background:#fff; border-radius:14px; border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); padding:18px 20px; display:flex; align-items:center; gap:14px; }
.rp-stat-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
.rp-stat-val { font-size:26px; font-weight:800; color:#0f172a; line-height:1; }
.rp-stat-lbl { font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:.4px; margin-top:3px; }

/* Toolbar */
.rp-toolbar { background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,.06); box-shadow:0 1px 4px rgba(0,0,0,.05); padding:16px 20px; display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; margin-bottom:18px; }
.rp-fg { display:flex; flex-direction:column; gap:5px; }
.rp-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; }
.rp-inp { padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; outline:none; font-family:inherit; transition:border-color .2s,box-shadow .2s; background:#fff; }
.rp-inp:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.rp-fbtn { padding:9px 20px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; font-size:13px; font-weight:700; border:none; border-radius:10px; cursor:pointer; font-family:inherit; display:inline-flex; align-items:center; gap:6px; }
.rp-rbtn { padding:9px 16px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .2s; }
.rp-rbtn:hover { background:#e2e8f0; color:#0f172a; }

/* Chart card */
.rp-chart-card { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden; margin-bottom:18px; }
.rp-chart-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.rp-chart-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.rp-chart-body { padding:20px 22px 16px; }

/* Data panel */
.rp-panel { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden; }
.rp-panel-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.rp-panel-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.rp-col-hdr { display:grid; grid-template-columns:40px 1.4fr 1fr 100px 1fr 130px 130px 90px 100px; padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9; }
.rp-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.rp-row { display:grid; grid-template-columns:40px 1.4fr 1fr 100px 1fr 130px 130px 90px 100px; align-items:center; padding:12px 22px; border-bottom:1px solid #f3f4f6; transition:background .15s; }
.rp-row:last-child { border-bottom:none; }
.rp-row:hover { background:#f8faff; }
.rp-num { font-size:12px; font-weight:700; color:#94a3b8; }
.rp-visitor-name { font-size:13px; font-weight:700; color:#0f172a; display:block; }
.rp-visitor-id   { font-size:11px; color:#94a3b8; font-family:monospace; }
.rp-cell-sm { font-size:13px; color:#475569; }
.rp-cell-mono { font-size:12px; color:#64748b; }
.rp-purpose { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:20px; background:#f1f5f9; color:#475569; font-size:12px; font-weight:600; }
.rp-status { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:11.5px; font-weight:700; white-space:nowrap; }
.rp-status-active    { background:#dbeafe; color:#1e40af; }
.rp-status-completed { background:#dcfce7; color:#15803d; }
.rp-status-pending   { background:#fef3c7; color:#b45309; }
.rp-status-rejected  { background:#fee2e2; color:#dc2626; }
.rp-empty { text-align:center; padding:56px 20px; color:#94a3b8; font-size:13px; }
.rp-pag { padding:14px 22px; border-top:1px solid #f1f5f9; }
@media(max-width:1100px){ .rp-col-hdr,.rp-row { grid-template-columns:36px 1.4fr 1fr 100px 1fr 120px auto; } .rp-col-hdr span:nth-child(n+7),.rp-row>div:nth-child(n+7) { display:none; } }
@media(max-width:700px){ .rp-stats { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="rp-header">
    <div>
        <h2><i class="fas fa-chart-bar me-2" style="color:#93c5fd;font-size:15px;"></i>Visit Reports</h2>
        <p>Analytics &amp; export for visit records &mdash; {{ now()->year }}</p>
    </div>
    <div class="rp-head-actions">
        <span class="rp-date-chip">
            <i class="fas fa-calendar" style="font-size:11px;color:rgba(255,255,255,.5);"></i>
            {{ \Carbon\Carbon::parse($dateFrom)->format('M d') }} &rarr; {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
        </span>
        <a href="{{ route('admin.reports.export', request()->query()) }}" class="rp-pdf-btn">
            <i class="fas fa-file-pdf" style="font-size:12px;"></i> Export PDF
        </a>
    </div>
</div>

{{-- STATS STRIP --}}
<div class="rp-stats">
    <div class="rp-stat">
        <div class="rp-stat-icon" style="background:#eff6ff;color:#1e3a8a;"><i class="fas fa-clipboard-list"></i></div>
        <div>
            <div class="rp-stat-val">{{ $totalVisits }}</div>
            <div class="rp-stat-lbl">Visits in Period</div>
        </div>
    </div>
    <div class="rp-stat">
        <div class="rp-stat-icon" style="background:#dcfce7;color:#15803d;"><i class="fas fa-circle-check"></i></div>
        <div>
            <div class="rp-stat-val">{{ $completedVisits }}</div>
            <div class="rp-stat-lbl">Completed</div>
        </div>
    </div>
    <div class="rp-stat">
        <div class="rp-stat-icon" style="background:#dbeafe;color:#1d4ed8;"><i class="fas fa-circle-dot"></i></div>
        <div>
            <div class="rp-stat-val">{{ $activeVisits }}</div>
            <div class="rp-stat-lbl">Currently Active</div>
        </div>
    </div>
</div>

{{-- FILTER TOOLBAR --}}
<div class="rp-toolbar">
    <form method="GET" style="display:contents;">
        <div class="rp-fg">
            <span class="rp-lbl">From Date</span>
            <input type="date" name="date_from" class="rp-inp" value="{{ $dateFrom }}">
        </div>
        <div class="rp-fg">
            <span class="rp-lbl">To Date</span>
            <input type="date" name="date_to" class="rp-inp" value="{{ $dateTo }}">
        </div>
        <div class="rp-fg">
            <span class="rp-lbl">Status</span>
            <select name="status" class="rp-inp" style="min-width:130px;">
                <option value="">All Statuses</option>
                <option value="active"    {{ request('status')==='active'   ?'selected':'' }}>Active</option>
                <option value="completed" {{ request('status')==='completed'?'selected':'' }}>Completed</option>
                <option value="pending"   {{ request('status')==='pending'  ?'selected':'' }}>Pending</option>
                <option value="rejected"  {{ request('status')==='rejected' ?'selected':'' }}>Rejected</option>
            </select>
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;">
            <button type="submit" class="rp-fbtn"><i class="fas fa-filter" style="font-size:11px;"></i> Apply</button>
            <a href="{{ route('admin.reports.index') }}" class="rp-rbtn"><i class="fas fa-rotate-left" style="font-size:11px;"></i> Reset</a>
        </div>
    </form>
</div>

{{-- CHART CARD --}}
<div class="rp-chart-card">
    <div class="rp-chart-head">
        <span class="rp-chart-title">
            <i class="fas fa-chart-column" style="color:#1e3a8a;font-size:13px;"></i>
            Monthly Visitor Trends — {{ now()->year }}
        </span>
        <span style="font-size:12px;color:#94a3b8;">Jan – Dec</span>
    </div>
    <div class="rp-chart-body"><canvas id="monthlyChart" height="80"></canvas></div>
</div>

{{-- DATA PANEL --}}
<div class="rp-panel">
    <div class="rp-panel-head">
        <span class="rp-panel-title">
            <i class="fas fa-table-list" style="color:#1e3a8a;font-size:13px;"></i>
            Visit Records
            <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $visits->total() }}</span>
        </span>
        <span style="font-size:12.5px;color:#94a3b8;">Showing {{ $visits->firstItem() ?? 0 }}–{{ $visits->lastItem() ?? 0 }}</span>
    </div>
    <div class="rp-col-hdr">
        <span class="rp-col-h">#</span>
        <span class="rp-col-h">Visitor</span>
        <span class="rp-col-h">Tenant</span>
        <span class="rp-col-h">Apt.</span>
        <span class="rp-col-h">Purpose</span>
        <span class="rp-col-h">Check In</span>
        <span class="rp-col-h">Check Out</span>
        <span class="rp-col-h">Duration</span>
        <span class="rp-col-h">Status</span>
    </div>

    @forelse($visits as $visit)
    <div class="rp-row">
        <span class="rp-num">{{ $visits->firstItem() + $loop->index }}</span>
        <div>
            <span class="rp-visitor-name">{{ $visit->visitor->full_name }}</span>
            <span class="rp-visitor-id">{{ $visit->visitor->national_id ?? '' }}</span>
        </div>
        <div class="rp-cell-sm">{{ $visit->tenant->user->name ?? '—' }}</div>
        <div style="font-size:13px;font-weight:700;color:#1e3a8a;">{{ $visit->tenant->apartment->apartment_number ?? '—' }}</div>
        <div><span class="rp-purpose">{{ Str::limit($visit->purpose, 20) }}</span></div>
        <div class="rp-cell-mono">{{ $visit->check_in_time?->format('M d, H:i') ?? '—' }}</div>
        <div class="rp-cell-mono">{{ $visit->check_out_time?->format('M d, H:i') ?? '—' }}</div>
        <div class="rp-cell-mono">{{ $visit->duration ?? '—' }}</div>
        <div><span class="rp-status rp-status-{{ $visit->status }}">{{ ucfirst($visit->status) }}</span></div>
    </div>
    @empty
    <div class="rp-empty">
        <i class="fas fa-chart-bar" style="font-size:32px;color:#e2e8f0;display:block;margin-bottom:12px;"></i>
        No visit records found for the selected filters.
    </div>
    @endforelse

    @if($visits->hasPages())
    <div class="rp-pag">{{ $visits->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

@endsection

@push('scripts')
<script>
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: @json($monthlyLabels),
        datasets: [{
            label: 'Visits',
            data: @json($monthlyData),
            backgroundColor: 'rgba(30,58,138,.1)',
            borderColor: '#1e3a8a',
            borderWidth: 2,
            borderRadius: 8,
            hoverBackgroundColor: 'rgba(30,58,138,.22)',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 12 }, color: '#94a3b8' } },
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,.04)' }, ticks: { stepSize: 1, font: { size: 12 }, color: '#94a3b8' } }
        }
    }
});
</script>
@endpush
