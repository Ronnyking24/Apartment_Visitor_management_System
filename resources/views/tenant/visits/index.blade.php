@extends('layouts.dashboard')
@section('title','Visit History')
@section('page-title','My Visitor History')

@push('styles')
<style>
/* ── VISIT HISTORY PAGE ── */

.vh-header {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius:14px; padding:20px 26px;
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; flex-wrap:wrap; margin-bottom:22px;
    position:relative; overflow:hidden;
}
.vh-header::after {
    content:''; position:absolute; right:-20px; top:-20px;
    width:160px; height:160px;
    background:radial-gradient(circle,rgba(99,102,241,.18) 0%,transparent 70%);
    pointer-events:none;
}
.vh-header-left h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.vh-header-left p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.vh-total-chip {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    padding:7px 16px; border-radius:10px; color:#fff; white-space:nowrap;
}
.vh-total-chip .chip-num { font-size:20px; font-weight:800; line-height:1; }
.vh-total-chip .chip-lbl { font-size:10px; color:rgba(255,255,255,.5); display:block; margin-top:1px; }

/* Filter toolbar */
.vh-toolbar {
    background:#fff; border-radius:14px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 1px 4px rgba(0,0,0,.05);
    padding:16px 20px;
    display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap;
    margin-bottom:18px;
}
.vh-filter-group { display:flex; flex-direction:column; gap:5px; }
.vh-filter-lbl {
    font-size:10.5px; font-weight:700; color:#94a3b8;
    text-transform:uppercase; letter-spacing:.6px;
}
.vh-filter-input,
.vh-filter-select {
    padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:10px;
    font-size:13px; color:#0f172a; outline:none; font-family:inherit;
    transition:border-color .2s,box-shadow .2s; background:#fff;
}
.vh-filter-input:focus,
.vh-filter-select:focus  { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.vh-search-wrap { position:relative; }
.vh-search-wrap i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.vh-search-wrap .vh-filter-input { padding-left:34px; min-width:200px; }
.vh-filter-btn {
    padding:9px 20px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8);
    color:#fff; font-size:13px; font-weight:700; border:none; border-radius:10px;
    cursor:pointer; font-family:inherit; white-space:nowrap;
    box-shadow:0 2px 8px rgba(30,58,138,.25); transition:all .2s;
    display:inline-flex; align-items:center; gap:6px;
}
.vh-filter-btn:hover { background:linear-gradient(135deg,#1d4ed8,#1e40af); }
.vh-reset-btn {
    padding:9px 16px; background:#f1f5f9; color:#64748b;
    border:1.5px solid #e2e8f0; border-radius:10px;
    font-size:13px; font-weight:600; text-decoration:none;
    transition:all .2s; white-space:nowrap;
    display:inline-flex; align-items:center; gap:6px;
}
.vh-reset-btn:hover { background:#e2e8f0; color:#0f172a; }

/* Active filter pills */
.vh-active-filters { display:flex; gap:6px; flex-wrap:wrap; align-items:center; margin-bottom:14px; }
.vh-filter-pill {
    display:inline-flex; align-items:center; gap:5px;
    background:#eff6ff; color:#1e3a8a; border:1px solid #bfdbfe;
    padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:600;
}
.vh-filter-pill i { font-size:9px; opacity:.7; }

/* Panel */
.vh-panel {
    background:#fff; border-radius:16px;
    border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden;
}
.vh-panel-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:15px 22px; border-bottom:1px solid #f1f5f9;
}
.vh-panel-head-left { display:flex; align-items:center; gap:10px; }
.vh-panel-title { font-size:15px; font-weight:700; color:#0f172a; }
.vh-count-badge {
    background:#eff6ff; color:#1e3a8a;
    font-size:11.5px; font-weight:700;
    padding:2px 10px; border-radius:20px;
}
.vh-panel-meta { font-size:12.5px; color:#94a3b8; }

/* Column headers */
.vh-col-hdr {
    display:grid;
    grid-template-columns:44px 1fr 160px 140px 140px 90px 130px 90px;
    padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9;
}
.vh-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.vh-col-h.right { text-align:right; }

/* Rows */
.vh-row {
    display:grid;
    grid-template-columns:44px 1fr 160px 140px 140px 90px 130px 90px;
    align-items:center; padding:13px 22px;
    border-bottom:1px solid #f3f4f6; transition:background .15s;
}
.vh-row.row-pending  { border-left:3px solid #f59e0b; }
.vh-row.row-active   { border-left:3px solid #22c55e; }
.vh-row.row-completed,
.vh-row.row-rejected { border-left:3px solid #e2e8f0; }
.vh-row:last-child { border-bottom:none; }
.vh-row:hover { background:#f8faff; }

.vh-num { font-size:12.5px; font-weight:700; color:#94a3b8; font-variant-numeric:tabular-nums; }

/* Visitor cell */
.vh-visitor-cell { display:flex; align-items:center; gap:10px; min-width:0; }
.vh-avatar {
    width:36px; height:36px; border-radius:50%;
    background:#dbeafe; color:#1e3a8a;
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:700; flex-shrink:0; overflow:hidden;
}
.vh-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.vh-vname { font-size:13px; font-weight:700; color:#0f172a; display:block; margin-bottom:1px; }
.vh-vsub  { font-size:11.5px; color:#94a3b8; }

/* Purpose pill — all neutral */
.vh-purpose {
    display:inline-flex; align-items:center; gap:4px;
    padding:3px 10px; border-radius:20px;
    font-size:11.5px; font-weight:600;
    background:#f1f5f9; color:#475569;
}

/* Time cell */
.vh-time { font-size:12.5px; color:#475569; font-variant-numeric:tabular-nums; display:block; }
.vh-time-date { font-size:11px; color:#94a3b8; display:block; margin-top:1px; }

/* Approval badge */
.vh-approved {
    display:inline-flex; align-items:center; gap:5px;
    font-size:11.5px; font-weight:600;
    padding:3px 10px; border-radius:20px;
}
.vh-approved.yes { background:#dcfce7; color:#16a34a; }
.vh-approved.no  { background:#f1f5f9; color:#94a3b8; }

/* Status pills */
.vh-status {
    display:inline-flex; align-items:center; gap:4px;
    padding:3px 10px; border-radius:20px;
    font-size:11.5px; font-weight:700;
}
.vh-status-active    { background:#dcfce7; color:#16a34a; }
.vh-status-completed { background:#f1f5f9; color:#64748b; }
.vh-status-pending   { background:#fef9c3; color:#92400e; }
.vh-status-rejected  { background:#fee2e2; color:#dc2626; }

/* Action buttons */
.vh-approve-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:28px; height:28px; border-radius:8px;
    background:#dcfce7; color:#16a34a; border:1.5px solid #bbf7d0;
    cursor:pointer; transition:all .18s; font-size:12px;
}
.vh-approve-btn:hover { background:#16a34a; color:#fff; }
.vh-reject-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:28px; height:28px; border-radius:8px;
    background:#fee2e2; color:#dc2626; border:1.5px solid #fecaca;
    cursor:pointer; transition:all .18s; font-size:12px;
}
.vh-reject-btn:hover { background:#dc2626; color:#fff; }
.vh-eye-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:28px; height:28px; border-radius:8px;
    background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0;
    text-decoration:none; transition:all .18s; font-size:12px;
}
.vh-eye-btn:hover { background:#e2e8f0; color:#0f172a; }

/* Empty state */
.vh-empty { text-align:center; padding:64px 20px; }
.vh-empty-icon {
    width:72px; height:72px; background:#f1f5f9; border-radius:20px;
    display:flex; align-items:center; justify-content:center;
    font-size:28px; color:#cbd5e1; margin:0 auto 16px;
}
.vh-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.vh-empty p  { font-size:13px; color:#94a3b8; margin:0; }

/* Pagination */
.vh-pagination { padding:14px 22px; border-top:1px solid #f1f5f9; }

/* Dark mode */
.dark-mode .vh-toolbar,
.dark-mode .vh-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .vh-filter-input,
.dark-mode .vh-filter-select { background:#0f172a; border-color:rgba(255,255,255,.1); color:#e2e8f0; }
.dark-mode .vh-col-hdr { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .vh-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .vh-panel-title { color:#f1f5f9; }
.dark-mode .vh-row { border-color:rgba(255,255,255,.04); }
.dark-mode .vh-row:hover { background:#243044; }
.dark-mode .vh-vname { color:#e2e8f0; }
.dark-mode .vh-empty-icon { background:#0f172a; }
.dark-mode .vh-empty h5 { color:#f1f5f9; }
.dark-mode .vh-pagination { border-color:rgba(255,255,255,.07); }

@media(max-width:980px) {
    .vh-col-hdr,.vh-row { grid-template-columns:36px 1fr 140px 120px 120px 80px auto; }
    .vh-col-hdr span:nth-child(6),.vh-row>div:nth-child(6) { display:none; }
}
@media(max-width:680px) {
    .vh-col-hdr { display:none; }
    .vh-row { grid-template-columns:30px 1fr auto auto; }
    .vh-row>div:nth-child(3),.vh-row>div:nth-child(4),
    .vh-row>div:nth-child(5),.vh-row>div:nth-child(6) { display:none; }
}
</style>
@endpush

@section('content')

@php
    $purposeIcons = [
        'Family visit'     => 'fa-house-user',
        'Delivery'         => 'fa-box',
        'Business meeting' => 'fa-briefcase',
        'Maintenance'      => 'fa-screwdriver-wrench',
        'Social visit'     => 'fa-people-group',
    ];
    $total = $visits->total();
    $hasFilters = request()->hasAny(['search','status','date_from','date_to']) &&
                  array_filter(request()->only(['search','status','date_from','date_to']));
    $statusLabels = [
        'active'    => 'Inside',
        'completed' => 'Checked Out',
        'pending'   => 'Pending',
        'rejected'  => 'Rejected',
    ];
@endphp

{{-- HEADER BANNER --}}
<div class="vh-header">
    <div class="vh-header-left">
        <h2><i class="fas fa-clock-rotate-left me-2" style="color:#93c5fd;font-size:15px;"></i>Visitor History</h2>
        <p>{{ now()->format('l, F d, Y') }} &mdash; All visits to your apartment</p>
    </div>
    <div class="vh-total-chip">
        <div>
            <span class="chip-num">{{ $total }}</span>
            <span class="chip-lbl">Total Records</span>
        </div>
    </div>
</div>

{{-- FILTER TOOLBAR --}}
<div class="vh-toolbar">
    <form method="GET" style="display:contents;">
        <div class="vh-filter-group">
            <span class="vh-filter-lbl">Search Visitor</span>
            <div class="vh-search-wrap">
                <i class="fas fa-magnifying-glass"></i>
                <input type="text" name="search" class="vh-filter-input"
                    placeholder="Name or ID…" value="{{ request('search') }}">
            </div>
        </div>
        <div class="vh-filter-group">
            <span class="vh-filter-lbl">Status</span>
            <select name="status" class="vh-filter-select" style="min-width:140px;">
                <option value="">All Statuses</option>
                <option value="pending"   {{ request('status')=='pending'   ?'selected':'' }}>Pending</option>
                <option value="active"    {{ request('status')=='active'    ?'selected':'' }}>Inside</option>
                <option value="completed" {{ request('status')=='completed' ?'selected':'' }}>Checked Out</option>
                <option value="rejected"  {{ request('status')=='rejected'  ?'selected':'' }}>Rejected</option>
            </select>
        </div>
        <div class="vh-filter-group">
            <span class="vh-filter-lbl">From</span>
            <input type="date" name="date_from" class="vh-filter-input" value="{{ request('date_from') }}">
        </div>
        <div class="vh-filter-group">
            <span class="vh-filter-lbl">To</span>
            <input type="date" name="date_to" class="vh-filter-input" value="{{ request('date_to') }}">
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;padding-bottom:1px;">
            <button type="submit" class="vh-filter-btn">
                <i class="fas fa-filter" style="font-size:11px;"></i> Apply
            </button>
            @if($hasFilters)
            <a href="{{ route('tenant.visits.index') }}" class="vh-reset-btn">
                <i class="fas fa-xmark"></i> Clear
            </a>
            @endif
        </div>
    </form>
</div>

{{-- ACTIVE FILTER PILLS --}}
@if($hasFilters)
<div class="vh-active-filters">
    <span style="font-size:11.5px;color:#94a3b8;font-weight:600;">Filtering by:</span>
    @if(request('search'))
        <span class="vh-filter-pill"><i class="fas fa-magnifying-glass"></i> "{{ request('search') }}"</span>
    @endif
    @if(request('status'))
        <span class="vh-filter-pill"><i class="fas fa-circle-dot"></i> {{ $statusLabels[request('status')] ?? ucfirst(request('status')) }}</span>
    @endif
    @if(request('date_from'))
        <span class="vh-filter-pill"><i class="fas fa-calendar"></i> From {{ \Carbon\Carbon::parse(request('date_from'))->format('M d, Y') }}</span>
    @endif
    @if(request('date_to'))
        <span class="vh-filter-pill"><i class="fas fa-calendar"></i> To {{ \Carbon\Carbon::parse(request('date_to'))->format('M d, Y') }}</span>
    @endif
    <span style="font-size:11.5px;color:#64748b;margin-left:4px;">— {{ $total }} result{{ $total!=1?'s':'' }}</span>
</div>
@endif

{{-- RECORDS PANEL --}}
<div class="vh-panel">

    <div class="vh-panel-head">
        <div class="vh-panel-head-left">
            <i class="fas fa-list-ul" style="color:#1e3a8a;font-size:14px;"></i>
            <span class="vh-panel-title">Visit Records</span>
            <span class="vh-count-badge">{{ $total }}</span>
        </div>
        <span class="vh-panel-meta">
            Showing {{ $visits->firstItem() ?? 0 }}–{{ $visits->lastItem() ?? 0 }} of {{ $total }}
        </span>
    </div>

    <div class="vh-col-hdr">
        <span class="vh-col-h">#</span>
        <span class="vh-col-h">Visitor</span>
        <span class="vh-col-h">Purpose</span>
        <span class="vh-col-h">Check In</span>
        <span class="vh-col-h">Check Out</span>
        <span class="vh-col-h">Approved</span>
        <span class="vh-col-h">Status</span>
        <span class="vh-col-h right">Action</span>
    </div>

    @forelse($visits as $visit)
    @php
        $icon    = $purposeIcons[$visit->purpose] ?? 'fa-ellipsis';
        $parts   = explode(' ', trim($visit->visitor->full_name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
        $rowNum  = str_pad($visits->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT);
        $sLabel  = $statusLabels[$visit->status] ?? ucfirst($visit->status);
        $sCls    = 'vh-status-'.$visit->status;
        $rowCls  = 'row-'.$visit->status;
    @endphp
    <div class="vh-row {{ $rowCls }}">

        <span class="vh-num">{{ $rowNum }}</span>

        <div class="vh-visitor-cell">
            <div class="vh-avatar">
                @if($visit->visitor->photo)
                    <img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div>
                <span class="vh-vname">{{ $visit->visitor->full_name }}</span>
                <span class="vh-vsub">{{ $visit->visitor->phone_number ?: ($visit->visitor->national_id ?? '') }}</span>
            </div>
        </div>

        <div>
            <span class="vh-purpose">
                <i class="fas {{ $icon }}" style="font-size:10px;"></i>
                {{ Str::limit($visit->purpose, 18) }}
            </span>
        </div>

        <div>
            @if($visit->check_in_time)
                <span class="vh-time">{{ $visit->check_in_time->format('H:i') }}</span>
                <span class="vh-time-date">{{ $visit->check_in_time->format('M d, Y') }}</span>
            @else
                <span class="vh-time">—</span>
            @endif
        </div>

        <div>
            @if($visit->check_out_time)
                <span class="vh-time">{{ $visit->check_out_time->format('H:i') }}</span>
                <span class="vh-time-date">{{ $visit->check_out_time->format('M d, Y') }}</span>
            @else
                <span class="vh-time">—</span>
            @endif
        </div>

        <div>
            @if($visit->approved_by_tenant)
                <span class="vh-approved yes"><i class="fas fa-check" style="font-size:9px;"></i> Yes</span>
            @else
                <span class="vh-approved no"><i class="fas fa-minus" style="font-size:9px;"></i> No</span>
            @endif
        </div>

        <div>
            <span class="vh-status {{ $sCls }}">{{ $sLabel }}</span>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:6px;">
            @if($visit->status === 'pending')
            <form method="POST" action="{{ route('tenant.visits.approve', $visit) }}" style="margin:0;">
                @csrf @method('PATCH')
                <button class="vh-approve-btn" title="Approve"><i class="fas fa-check"></i></button>
            </form>
            <form method="POST" action="{{ route('tenant.visits.reject', $visit) }}" style="margin:0;">
                @csrf @method('PATCH')
                <button class="vh-reject-btn" title="Reject"><i class="fas fa-times"></i></button>
            </form>
            @else
            <a href="{{ route('tenant.visits.show', $visit) }}" class="vh-eye-btn" title="View details">
                <i class="fas fa-eye"></i>
            </a>
            @endif
        </div>
    </div>
    @empty
    <div class="vh-empty">
        @if($hasFilters)
            <div class="vh-empty-icon"><i class="fas fa-magnifying-glass"></i></div>
            <h5>No matching visits</h5>
            <p>Try adjusting your filters to find what you're looking for.</p>
        @else
            <div class="vh-empty-icon"><i class="fas fa-clock-rotate-left"></i></div>
            <h5>No visit history yet</h5>
            <p>Visitor activity will appear here once check-ins are recorded.</p>
        @endif
    </div>
    @endforelse

    @if($visits->hasPages())
    <div class="vh-pagination">{{ $visits->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

@endsection
