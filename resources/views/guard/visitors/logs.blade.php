@extends('layouts.dashboard')
@section('title', "Today's Logs")
@section('page-title', "Today's Logs")

@push('styles')
<style>
/* ── LOGS PAGE v3 ── */
.lg-header {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius: 14px;
    padding: 20px 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
}
.lg-header::after {
    content:'';position:absolute;right:-20px;top:-20px;
    width:160px;height:160px;
    background:radial-gradient(circle,rgba(99,102,241,.2) 0%,transparent 70%);
    pointer-events:none;
}
.lg-header-left h2 { font-size:17px;font-weight:800;color:#fff;margin:0 0 2px; }
.lg-header-left p  { font-size:12px;color:rgba(255,255,255,.45);margin:0; }
.lg-header-stats   { display:flex;gap:20px;flex-wrap:wrap; }
.lg-hstat { text-align:center; }
.lg-hstat-num { font-size:22px;font-weight:800;color:#fff;line-height:1;font-variant-numeric:tabular-nums; }
.lg-hstat-lbl { font-size:10px;color:rgba(255,255,255,.4);font-weight:600;text-transform:uppercase;letter-spacing:.6px;margin-top:2px; }
.lg-hstat-div { width:1px;background:rgba(255,255,255,.12);align-self:stretch; }
.lg-reg-btn {
    display:inline-flex;align-items:center;gap:8px;
    padding:10px 18px;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    color:#fff;font-size:13px;font-weight:700;
    border-radius:10px;text-decoration:none;
    transition:all .2s;white-space:nowrap;
    backdrop-filter:blur(4px);
}
.lg-reg-btn:hover { background:rgba(255,255,255,.22);color:#fff; }

/* Toolbar */
.lg-toolbar {
    background:#fff;
    border-radius:14px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 1px 4px rgba(0,0,0,.05);
    padding:14px 18px;
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
    margin-bottom:18px;
}
.lg-search-wrap {
    position:relative;
    flex:1;
    min-width:200px;
}
.lg-search-wrap i {
    position:absolute;left:13px;top:50%;transform:translateY(-50%);
    color:#94a3b8;font-size:13px;pointer-events:none;
}
.lg-search-input {
    width:100%;
    padding:10px 14px 10px 38px;
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    font-size:13.5px;color:#0f172a;
    outline:none;
    transition:border-color .2s,box-shadow .2s;
    font-family:inherit;
    background:#fff;
}
.lg-search-input:focus { border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.lg-search-btn {
    padding:10px 20px;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    color:#fff;font-size:13px;font-weight:700;
    border:none;border-radius:10px;cursor:pointer;
    transition:all .2s;white-space:nowrap;font-family:inherit;
    box-shadow:0 2px 8px rgba(59,130,246,.3);
}
.lg-search-btn:hover { background:linear-gradient(135deg,#2563eb,#1d4ed8); }
.lg-reset-btn {
    padding:10px 16px;
    background:#f1f5f9;color:#64748b;
    border:1.5px solid #e2e8f0;border-radius:10px;
    font-size:13px;font-weight:600;text-decoration:none;
    transition:all .2s;white-space:nowrap;
    display:inline-flex;align-items:center;gap:6px;
}
.lg-reset-btn:hover { background:#e2e8f0;color:#0f172a; }
.lg-export-btn {
    padding:10px 16px;
    background:#fff;color:#ef4444;
    border:1.5px solid #fecaca;border-radius:10px;
    font-size:13px;font-weight:600;text-decoration:none;
    transition:all .2s;white-space:nowrap;
    display:inline-flex;align-items:center;gap:6px;
}
.lg-export-btn:hover { background:#fef2f2;color:#dc2626;border-color:#fca5a5; }

/* Filter tabs */
.lg-tabs {
    display:flex;gap:6px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:10px;
    padding:4px;
}
.lg-tab {
    padding:6px 14px;
    border-radius:7px;
    font-size:12.5px;font-weight:600;
    cursor:pointer;
    border:none;background:transparent;
    color:#64748b;transition:all .18s;
    font-family:inherit;
    display:inline-flex;align-items:center;gap:6px;
}
.lg-tab.active { background:#fff;color:#0f172a;box-shadow:0 1px 4px rgba(0,0,0,.1); }
.lg-tab-count {
    background:#e2e8f0;color:#64748b;
    font-size:10px;font-weight:700;
    padding:1px 6px;border-radius:20px;
    min-width:18px;text-align:center;
}
.lg-tab.active .lg-tab-count { background:#dbeafe;color:#1d4ed8; }

/* ─── Visit Records Panel ─── */
.lg-panel {
    background:#fff;
    border-radius:16px;
    border:1px solid #e8ecf1;
    box-shadow:0 1px 4px rgba(0,0,0,.05);
    overflow:hidden;
}
.lg-panel-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 22px;
    border-bottom:1px solid #f1f5f9;
}
.lg-panel-head-left { display:flex; align-items:center; gap:10px; }
.lg-panel-title { font-size:15px; font-weight:700; color:#0f172a; }
.lg-count-badge {
    background:#eff6ff; color:#3b82f6;
    font-size:11.5px; font-weight:700;
    padding:2px 10px; border-radius:20px;
}
.lg-panel-meta { font-size:12.5px; color:#94a3b8; }

/* Column header row */
.lg-col-hdr-row {
    display:grid;
    grid-template-columns:56px 1fr 190px 130px 240px;
    padding:9px 22px;
    background:#fafbfc;
    border-bottom:1px solid #f1f5f9;
}
.lg-col-hdr-row > *, .lg-row > * { min-width:0; }
.lg-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.lg-col-h.right { text-align:right; }

/* Visit rows */
.lg-row {
    display:grid;
    grid-template-columns:56px 1fr 190px 130px 240px;
    align-items:center;
    padding:16px 22px;
    border-bottom:1px solid #f3f4f6;
    border-left:3px solid transparent;
    transition:background .15s;
}
.lg-row:last-child { border-bottom:none; }
.lg-row:hover { background:#f8faff; }
.lg-row.row-active    { border-left-color:#22c55e; }
.lg-row.row-completed { border-left-color:transparent; }

/* Row number */
.lg-num { font-size:12.5px; font-weight:700; color:#94a3b8; font-variant-numeric:tabular-nums; }

/* Visitor cell */
.lg-visitor-cell { display:flex; align-items:center; gap:12px; min-width:0; }
.lg-avatar-circle {
    width:38px; height:38px; border-radius:50%;
    background:#dbeafe; color:#3b82f6;
    display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:700; flex-shrink:0;
    letter-spacing:.3px; overflow:hidden;
}
.lg-avatar-circle img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.lg-vinfo { min-width:0; }
.lg-vname-row { display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:3px; }
.lg-visitor-name  { font-size:13.5px; font-weight:700; color:#0f172a; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.lg-visitor-phone { font-size:12px; color:#94a3b8; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

/* Purpose pill */
.lg-purpose {
    display:inline-flex; align-items:center; gap:4px;
    padding:2px 10px; border-radius:20px;
    font-size:11.5px; font-weight:600; white-space:nowrap;
}
.pur-delivery    { background:#dbeafe; color:#2563eb; }
.pur-family      { background:#dcfce7; color:#16a34a; }
.pur-business    { background:#ede9fe; color:#6d28d9; }
.pur-maintenance { background:#fef9c3; color:#92400e; }
.pur-social      { background:#ccfbf1; color:#0e7490; }
.pur-other       { background:#f1f5f9; color:#475569; }

/* Host / Apt cell */
.lg-host-name { display:block; font-size:13px; font-weight:600; color:#0f172a; margin-bottom:4px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.lg-host-apt  { display:inline-flex; align-items:center; gap:5px; font-size:12px; color:#64748b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.lg-host-apt i { font-size:10px; color:#94a3b8; }

/* Times cell */
.lg-time-row { display:flex; align-items:center; gap:8px; min-width:0; }
.lg-time-row + .lg-time-row { margin-top:5px; }
.lg-tlbl { font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; width:24px; flex-shrink:0; }
.lg-tval      { font-size:13px; font-weight:700; color:#0f172a; font-variant-numeric:tabular-nums; }
.lg-tval-out  { font-size:13px; font-weight:700; color:#475569; font-variant-numeric:tabular-nums; }
.lg-tval-dash { font-size:13px; color:#d1d5db; }

/* Status cell */
.lg-status-cell { display:flex; align-items:center; justify-content:flex-end; gap:7px; }

/* Live pill */
.lg-pill-live {
    display:inline-flex; align-items:center; gap:5px;
    padding:5px 12px; border-radius:20px;
    border:1.5px solid #e2e8f0; background:#fff;
    font-size:12px; font-weight:600; color:#64748b; white-space:nowrap;
}
/* Inside pill */
.lg-pill-inside {
    display:inline-flex; align-items:center; gap:5px;
    padding:5px 12px; border-radius:20px;
    border:1.5px solid #22c55e; background:#fff;
    font-size:12px; font-weight:600; color:#16a34a; white-space:nowrap;
}
.lg-pill-inside::before { content:'\25CF'; font-size:7px; color:#22c55e; }
/* Duration pill */
.lg-pill-dur {
    display:inline-flex; align-items:center; gap:5px;
    padding:5px 11px; border-radius:20px;
    border:1.5px solid #e2e8f0; background:#fff;
    font-size:12px; font-weight:600; color:#64748b; white-space:nowrap;
}
/* Out done pill */
.lg-pill-out-done {
    display:inline-flex; align-items:center; gap:4px;
    padding:5px 12px; border-radius:20px;
    border:1.5px solid #e2e8f0; background:#fff;
    font-size:12px; font-weight:600; color:#94a3b8; white-space:nowrap;
}
.lg-pill-out-done::before { content:'\25CB'; font-size:9px; }
/* Checkout button */
.lg-out-btn {
    display:inline-flex; align-items:center; gap:5px;
    padding:7px 16px; border-radius:20px;
    background:linear-gradient(135deg,#ef4444,#dc2626);
    color:#fff; border:none; font-size:12px; font-weight:700;
    cursor:pointer; font-family:inherit;
    box-shadow:0 2px 8px rgba(239,68,68,.2);
    transition:all .18s; white-space:nowrap;
}
.lg-out-btn:hover { background:linear-gradient(135deg,#dc2626,#b91c1c); transform:translateY(-1px); }
/* View button */
.lg-view-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:34px; height:34px;
    background:#fff; color:#64748b;
    border-radius:50%; border:1.5px solid #e2e8f0;
    font-size:13px; text-decoration:none; transition:all .18s;
}
.lg-view-btn:hover { background:#f1f5f9; color:#0f172a; }

/* Empty state */
.lg-empty { text-align:center; padding:60px 20px; }
.lg-empty-icon { width:72px; height:72px; background:#f1f5f9; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:28px; color:#cbd5e1; margin:0 auto 16px; }
.lg-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.lg-empty p  { font-size:13px; color:#94a3b8; margin:0; }

/* Pagination */
.lg-pagination { padding:14px 22px; border-top:1px solid #f1f5f9; }

/* Dark mode */
.dark-mode .lg-toolbar,
.dark-mode .lg-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .lg-search-input { background:#0f172a; border-color:rgba(255,255,255,.1); color:#e2e8f0; }
.dark-mode .lg-search-input:focus { background:#0f172a; }
.dark-mode .lg-tabs { background:#0f172a; border-color:rgba(255,255,255,.08); }
.dark-mode .lg-tab.active { background:#1e293b; color:#f1f5f9; }
.dark-mode .lg-reset-btn { background:#0f172a; border-color:rgba(255,255,255,.1); color:#94a3b8; }
.dark-mode .lg-reset-btn:hover { color:#f1f5f9; }
.dark-mode .lg-col-hdr-row { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .lg-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .lg-panel-title { color:#f1f5f9; }
.dark-mode .lg-count-badge { background:#1e3a5f; color:#60a5fa; }
.dark-mode .lg-row { border-color:rgba(255,255,255,.04); }
.dark-mode .lg-row:hover { background:#243044; }
.dark-mode .lg-visitor-name { color:#e2e8f0; }
.dark-mode .lg-host-name { color:#e2e8f0; }
.dark-mode .lg-tval { color:#e2e8f0; }
.dark-mode .lg-pill-live,.dark-mode .lg-pill-dur,
.dark-mode .lg-pill-out-done,.dark-mode .lg-pill-inside { background:#0f172a; border-color:rgba(255,255,255,.12); }
.dark-mode .lg-view-btn { background:#0f172a; border-color:rgba(255,255,255,.1); color:#94a3b8; }
.dark-mode .lg-view-btn:hover { background:#1e293b; color:#f1f5f9; }
.dark-mode .lg-pagination { border-color:rgba(255,255,255,.07); }
.dark-mode .lg-empty-icon { background:#0f172a; }
.dark-mode .lg-empty h5 { color:#f1f5f9; }

@media(max-width:960px) {
    .lg-col-hdr-row,.lg-row { grid-template-columns:44px 1fr 160px 110px auto; }
}
@media(max-width:680px) {
    .lg-col-hdr-row { display:none; }
    .lg-row { grid-template-columns:36px 1fr auto; }
    .lg-host-cell,.lg-times-cell,.lg-pill-live,.lg-pill-dur { display:none; }
}
</style>
@endpush

@section('content')

@php
    $totalToday     = $visits->total();
    $activeCount    = $visits->getCollection()->where('status','active')->count();
    $completedCount = $visits->getCollection()->where('status','completed')->count();
    $purposeIcons   = [
        'Family visit'     => ['icon'=>'fa-house-user',        'class'=>'pur-family'],
        'Delivery'         => ['icon'=>'fa-box',               'class'=>'pur-delivery'],
        'Business meeting' => ['icon'=>'fa-briefcase',         'class'=>'pur-business'],
        'Maintenance'      => ['icon'=>'fa-screwdriver-wrench','class'=>'pur-maintenance'],
        'Social visit'     => ['icon'=>'fa-people-group',      'class'=>'pur-social'],
    ];
@endphp

{{-- HEADER BANNER --}}
<div class="lg-header">
    <div class="lg-header-left">
        <h2><i class="fas fa-clipboard-list me-2" style="color:#93c5fd;"></i>Today's Visitor Log</h2>
        <p>{{ now()->format('l, F d, Y') }}</p>
    </div>
    <div class="lg-header-stats d-none d-md-flex">
        <div class="lg-hstat">
            <div class="lg-hstat-num">{{ $totalToday }}</div>
            <div class="lg-hstat-lbl">Total</div>
        </div>
        <div class="lg-hstat-div"></div>
        <div class="lg-hstat">
            <div class="lg-hstat-num">{{ $activeCount }}</div>
            <div class="lg-hstat-lbl">Inside</div>
        </div>
        <div class="lg-hstat-div"></div>
        <div class="lg-hstat">
            <div class="lg-hstat-num">{{ $completedCount }}</div>
            <div class="lg-hstat-lbl">Out</div>
        </div>
    </div>
    <a href="{{ route('guard.visitors.create') }}" class="lg-reg-btn">
        <i class="fas fa-user-plus"></i> Register Visitor
    </a>
</div>

{{-- TOOLBAR --}}
<div class="lg-toolbar">
    <form method="GET" style="display:contents;">
        <div class="lg-search-wrap">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" name="search" class="lg-search-input"
                placeholder="Search visitor name or national ID…"
                value="{{ request('search') }}">
        </div>
        <button type="submit" class="lg-search-btn"><i class="fas fa-search me-1"></i>Search</button>
        @if(request('search'))
        <a href="{{ route('guard.visitors.logs') }}" class="lg-reset-btn">
            <i class="fas fa-xmark"></i> Clear
        </a>
        @endif
    </form>

    {{-- Status filter tabs --}}
    <a href="{{ route('guard.visitors.logs.export', request()->only('search')) }}"
       class="lg-export-btn" title="Export today's log as PDF">
        <i class="fas fa-file-pdf"></i> Export PDF
    </a>

    <div class="lg-tabs ms-auto">
        <button type="button" class="lg-tab active" onclick="filterRows('all', this)">
            All <span class="lg-tab-count" id="cnt-all">{{ $totalToday }}</span>
        </button>
        <button type="button" class="lg-tab" onclick="filterRows('active', this)">
            Inside <span class="lg-tab-count" id="cnt-active">{{ $activeCount }}</span>
        </button>
        <button type="button" class="lg-tab" onclick="filterRows('completed', this)">
            Out <span class="lg-tab-count" id="cnt-completed">{{ $completedCount }}</span>
        </button>
    </div>
</div>

{{-- VISIT RECORDS PANEL --}}
<div class="lg-panel">

    {{-- Panel header --}}
    <div class="lg-panel-head">
        <div class="lg-panel-head-left">
            <i class="fas fa-clipboard-list" style="color:#3b82f6;font-size:15px;"></i>
            <span class="lg-panel-title">Visit Records</span>
            <span class="lg-count-badge">{{ $totalToday }}</span>
        </div>
        <span class="lg-panel-meta">Showing {{ $visits->firstItem() ?? 0 }}–{{ $visits->lastItem() ?? 0 }} of {{ $totalToday }} entries</span>
    </div>

    {{-- Column headers --}}
    <div class="lg-col-hdr-row">
        <span class="lg-col-h">#</span>
        <span class="lg-col-h">Visitor</span>
        <span class="lg-col-h">Host / Apt</span>
        <span class="lg-col-h">Times</span>
        <span class="lg-col-h right">Status</span>
    </div>

    @forelse($visits as $i => $visit)
    @php
        $p       = $purposeIcons[$visit->purpose] ?? ['icon'=>'fa-ellipsis','class'=>'pur-other'];
        $rowCls  = 'row-'.$visit->status;
        $dur     = '';
        if($visit->check_out_time && $visit->check_in_time) {
            $mins = (int)$visit->check_in_time->diffInMinutes($visit->check_out_time);
            $dur  = $mins < 60 ? $mins.'m' : floor($mins/60).'h '.($mins%60).'m';
        }
        $parts    = explode(' ', trim($visit->visitor->full_name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
        $rowNum   = str_pad($visits->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT);
    @endphp
    <div class="lg-row {{ $rowCls }}" data-status="{{ $visit->status }}">

        {{-- # --}}
        <span class="lg-num">{{ $rowNum }}</span>

        {{-- Visitor --}}
        <div class="lg-visitor-cell">
            <div class="lg-avatar-circle">
                @if($visit->visitor->photo)
                    <img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div class="lg-vinfo">
                <div class="lg-vname-row">
                    <span class="lg-visitor-name">{{ $visit->visitor->full_name }}</span>
                    <span class="lg-purpose {{ $p['class'] }}">
                        <i class="fas {{ $p['icon'] }}" style="font-size:10px;"></i>
                        {{ $visit->purpose }}
                    </span>
                </div>
                <span class="lg-visitor-phone">{{ $visit->visitor->phone_number ?: ($visit->visitor->national_id ? 'ID: '.$visit->visitor->national_id : '') }}</span>
            </div>
        </div>

        {{-- Host / Apt --}}
        <div class="lg-host-cell">
            <span class="lg-host-name">{{ $visit->tenant->user->name ?? '—' }}</span>
            <span class="lg-host-apt">
                <i class="fas fa-building"></i>
                {{ $visit->tenant->apartment_display ?? 'N/A' }}
            </span>
        </div>

        {{-- Times --}}
        <div class="lg-times-cell">
            <div class="lg-time-row">
                <span class="lg-tlbl">In</span>
                <span class="lg-tval">{{ $visit->check_in_time?->format('H:i') ?? '—' }}</span>
            </div>
            <div class="lg-time-row">
                <span class="lg-tlbl">Out</span>
                @if($visit->check_out_time)
                    <span class="lg-tval-out">{{ $visit->check_out_time->format('H:i') }}</span>
                @else
                    <span class="lg-tval-dash">—</span>
                @endif
            </div>
        </div>

        {{-- Status + Action --}}
        <div class="lg-status-cell">
            @if($visit->status === 'active')
                <span class="lg-pill-live">
                    <i class="fas fa-clock" style="font-size:10px;"></i> Live
                </span>
                <span class="lg-pill-inside">Inside</span>
                <form method="POST" action="{{ route('guard.visits.checkout', $visit) }}"
                      onsubmit="return confirm('Check out {{ addslashes($visit->visitor->full_name) }}?')" style="margin:0;">
                    @csrf @method('PATCH')
                    <button class="lg-out-btn">
                        <i class="fas fa-right-from-bracket" style="font-size:11px;"></i> Out
                    </button>
                </form>
            @else
                <span class="lg-pill-dur">
                    <i class="fas fa-clock" style="font-size:10px;"></i> {{ $dur ?: '—' }}
                </span>
                <span class="lg-pill-out-done">Out</span>
                <a href="{{ route('guard.visits.show', $visit) }}" class="lg-view-btn" title="View details">
                    <i class="fas fa-eye"></i>
                </a>
            @endif
        </div>
    </div>
    @empty
    <div class="lg-empty">
        <div class="lg-empty-icon"><i class="fas fa-clipboard-list"></i></div>
        <h5>No visits logged today</h5>
        <p>Visitor activity will appear here once check-ins are recorded.</p>
    </div>
    @endforelse

    @if($visits->hasPages())
    <div class="lg-pagination">{{ $visits->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function filterRows(status, btn) {
    document.querySelectorAll('.lg-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.lg-row').forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });
}
</script>
@endpush
