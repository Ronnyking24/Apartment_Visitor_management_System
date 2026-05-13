@extends('layouts.dashboard')
@section('title','Search Visitors')
@section('page-title','Search Visitors')

@push('styles')
<style>
/* ── SEARCH VISITORS PAGE ── */

/* Header banner */
.sv-header {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius: 14px;
    padding: 20px 26px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; flex-wrap: wrap;
    margin-bottom: 22px;
    position: relative; overflow: hidden;
}
.sv-header::after {
    content:''; position:absolute; right:-20px; top:-20px;
    width:160px; height:160px;
    background:radial-gradient(circle,rgba(99,102,241,.2) 0%,transparent 70%);
    pointer-events:none;
}
.sv-header-left h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.sv-header-left p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.sv-reg-btn {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 18px;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    color:#fff; font-size:13px; font-weight:700;
    border-radius:10px; text-decoration:none;
    transition:all .2s; white-space:nowrap;
    backdrop-filter:blur(4px);
}
.sv-reg-btn:hover { background:rgba(255,255,255,.22); color:#fff; }

/* Search toolbar */
.sv-toolbar {
    background:#fff;
    border-radius:14px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 1px 4px rgba(0,0,0,.05);
    padding:16px 20px;
    display:flex; align-items:center; gap:12px; flex-wrap:wrap;
    margin-bottom:18px;
}
.sv-search-wrap { position:relative; flex:1; min-width:220px; max-width:480px; }
.sv-search-wrap i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px; pointer-events:none; }
.sv-search-input {
    width:100%; padding:10px 14px 10px 38px;
    border:1.5px solid #e2e8f0; border-radius:10px;
    font-size:13.5px; color:#0f172a; outline:none;
    transition:border-color .2s,box-shadow .2s;
    font-family:inherit; background:#fff;
}
.sv-search-input:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.sv-search-btn {
    padding:10px 20px;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    color:#fff; font-size:13px; font-weight:700;
    border:none; border-radius:10px; cursor:pointer;
    transition:all .2s; white-space:nowrap; font-family:inherit;
    box-shadow:0 2px 8px rgba(59,130,246,.3);
    display:inline-flex; align-items:center; gap:6px;
}
.sv-search-btn:hover { background:linear-gradient(135deg,#2563eb,#1d4ed8); }
.sv-reset-btn {
    padding:10px 16px;
    background:#f1f5f9; color:#64748b;
    border:1.5px solid #e2e8f0; border-radius:10px;
    font-size:13px; font-weight:600; text-decoration:none;
    transition:all .2s; white-space:nowrap;
    display:inline-flex; align-items:center; gap:6px;
}
.sv-reset-btn:hover { background:#e2e8f0; color:#0f172a; }
.sv-result-pill {
    display:inline-flex; align-items:center; gap:6px;
    background:#eff6ff; color:#3b82f6;
    border:1px solid #bfdbfe;
    padding:5px 12px; border-radius:20px;
    font-size:12px; font-weight:600; white-space:nowrap;
}

/* Panel */
.sv-panel {
    background:#fff;
    border-radius:16px;
    border:1px solid #e8ecf1;
    box-shadow:0 1px 4px rgba(0,0,0,.05);
    overflow:hidden;
}
.sv-panel-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 22px;
    border-bottom:1px solid #f1f5f9;
}
.sv-panel-head-left { display:flex; align-items:center; gap:10px; }
.sv-panel-title { font-size:15px; font-weight:700; color:#0f172a; }
.sv-count-badge {
    background:#eff6ff; color:#3b82f6;
    font-size:11.5px; font-weight:700;
    padding:2px 10px; border-radius:20px;
}
.sv-panel-meta { font-size:12.5px; color:#94a3b8; }

/* Column header row */
.sv-col-hdr-row {
    display:grid;
    grid-template-columns:44px 1fr 160px 160px 100px 140px 110px;
    padding:9px 22px;
    background:#fafbfc;
    border-bottom:1px solid #f1f5f9;
}
.sv-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.sv-col-h.right { text-align:right; }

/* Rows */
.sv-row {
    display:grid;
    grid-template-columns:44px 1fr 160px 160px 100px 140px 110px;
    align-items:center;
    padding:14px 22px;
    border-bottom:1px solid #f3f4f6;
    border-left:3px solid transparent;
    transition:background .15s;
}
.sv-row:last-child { border-bottom:none; }
.sv-row:hover { background:#f8faff; border-left-color:#3b82f6; }

/* Row number */
.sv-num { font-size:12.5px; font-weight:700; color:#94a3b8; font-variant-numeric:tabular-nums; }

/* Visitor cell */
.sv-visitor-cell { display:flex; align-items:center; gap:12px; min-width:0; }
.sv-avatar-circle {
    width:38px; height:38px; border-radius:50%;
    background:#dbeafe; color:#3b82f6;
    display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:700; flex-shrink:0;
    letter-spacing:.3px; overflow:hidden;
}
.sv-avatar-circle img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.sv-visitor-name { font-size:13.5px; font-weight:700; color:#0f172a; display:block; margin-bottom:2px; }
.sv-visitor-sub  { font-size:11.5px; color:#94a3b8; }

/* National ID */
.sv-nid {
    font-size:12px; font-weight:600; color:#64748b;
    background:#f8fafc; border:1px solid #e2e8f0;
    padding:2px 8px; border-radius:6px;
    display:inline-block; font-family:monospace; letter-spacing:.3px;
}

/* Phone */
.sv-phone { font-size:13px; color:#475569; font-variant-numeric:tabular-nums; }

/* Visit count badge */
.sv-visits-badge {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:28px; height:24px;
    background:#f1f5f9; color:#475569;
    font-size:12px; font-weight:700;
    border-radius:6px; padding:0 8px;
}
.sv-visits-badge.high { background:#dbeafe; color:#1d4ed8; }

/* Last visit */
.sv-last-visit { font-size:12.5px; color:#64748b; }
.sv-last-visit.recent { color:#16a34a; font-weight:600; }

/* View button */
.sv-view-btn {
    display:inline-flex; align-items:center; gap:5px;
    padding:6px 14px; border-radius:20px;
    border:1.5px solid #e2e8f0; background:#fff;
    color:#64748b; font-size:12px; font-weight:600;
    text-decoration:none; transition:all .18s; white-space:nowrap;
}
.sv-view-btn:hover { background:#f1f5f9; color:#0f172a; border-color:#cbd5e1; }

/* Empty state */
.sv-empty { text-align:center; padding:64px 20px; }
.sv-empty-icon {
    width:72px; height:72px; background:#f1f5f9; border-radius:20px;
    display:flex; align-items:center; justify-content:center;
    font-size:28px; color:#cbd5e1; margin:0 auto 16px;
}
.sv-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.sv-empty p  { font-size:13px; color:#94a3b8; margin:0; }

/* Pagination */
.sv-pagination { padding:14px 22px; border-top:1px solid #f1f5f9; }

/* Dark mode */
.dark-mode .sv-toolbar,
.dark-mode .sv-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .sv-search-input { background:#0f172a; border-color:rgba(255,255,255,.1); color:#e2e8f0; }
.dark-mode .sv-reset-btn { background:#0f172a; border-color:rgba(255,255,255,.1); color:#94a3b8; }
.dark-mode .sv-col-hdr-row { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .sv-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .sv-panel-title { color:#f1f5f9; }
.dark-mode .sv-row { border-color:rgba(255,255,255,.04); }
.dark-mode .sv-row:hover { background:#243044; }
.dark-mode .sv-visitor-name { color:#e2e8f0; }
.dark-mode .sv-nid { background:#0f172a; border-color:rgba(255,255,255,.1); color:#94a3b8; }
.dark-mode .sv-view-btn { background:#0f172a; border-color:rgba(255,255,255,.1); color:#94a3b8; }
.dark-mode .sv-view-btn:hover { background:#1e293b; color:#f1f5f9; }
.dark-mode .sv-empty-icon { background:#0f172a; }
.dark-mode .sv-empty h5 { color:#f1f5f9; }
.dark-mode .sv-pagination { border-color:rgba(255,255,255,.07); }
.dark-mode .sv-count-badge { background:#1e3a5f; color:#60a5fa; }

@media(max-width:960px) {
    .sv-col-hdr-row,.sv-row { grid-template-columns:36px 1fr 130px 130px 80px 120px auto; }
}
@media(max-width:680px) {
    .sv-col-hdr-row { display:none; }
    .sv-row { grid-template-columns:32px 1fr auto; }
    .sv-nid-cell,.sv-phone-cell,.sv-visits-cell,.sv-last-cell { display:none; }
}
</style>
@endpush

@section('content')

@php $total = $visitors->total(); @endphp

{{-- HEADER BANNER --}}
<div class="sv-header">
    <div class="sv-header-left">
        <h2><i class="fas fa-magnifying-glass me-2" style="color:#93c5fd;font-size:15px;"></i>Visitor Directory</h2>
        <p>Search and manage all registered visitors in the system</p>
    </div>
    <a href="{{ route('guard.visitors.create') }}" class="sv-reg-btn">
        <i class="fas fa-user-plus"></i> Register Visitor
    </a>
</div>

{{-- SEARCH TOOLBAR --}}
<div class="sv-toolbar">
    <form method="GET" style="display:contents;">
        <div class="sv-search-wrap">
            <i class="fas fa-magnifying-glass"></i>
            <input type="text" name="search" class="sv-search-input"
                placeholder="Search by name, national ID, or phone…"
                value="{{ request('search') }}" autofocus>
        </div>
        <button type="submit" class="sv-search-btn">
            <i class="fas fa-search"></i> Search
        </button>
        @if(request('search'))
        <a href="{{ route('guard.visitors.index') }}" class="sv-reset-btn">
            <i class="fas fa-xmark"></i> Clear
        </a>
        <span class="sv-result-pill">
            <i class="fas fa-filter" style="font-size:10px;"></i>
            "{{ request('search') }}" &mdash; {{ $total }} result{{ $total != 1 ? 's' : '' }}
        </span>
        @endif
    </form>
</div>

{{-- VISITOR PANEL --}}
<div class="sv-panel">

    {{-- Panel header --}}
    <div class="sv-panel-head">
        <div class="sv-panel-head-left">
            <i class="fas fa-users" style="color:#3b82f6;font-size:15px;"></i>
            <span class="sv-panel-title">{{ request('search') ? 'Search Results' : 'All Visitors' }}</span>
            <span class="sv-count-badge">{{ $total }}</span>
        </div>
        <span class="sv-panel-meta">
            Showing {{ $visitors->firstItem() ?? 0 }}–{{ $visitors->lastItem() ?? 0 }} of {{ $total }}
        </span>
    </div>

    {{-- Column headers --}}
    <div class="sv-col-hdr-row">
        <span class="sv-col-h">#</span>
        <span class="sv-col-h">Visitor</span>
        <span class="sv-col-h">National ID</span>
        <span class="sv-col-h">Phone</span>
        <span class="sv-col-h">Visits</span>
        <span class="sv-col-h">Last Visit</span>
        <span class="sv-col-h right">Action</span>
    </div>

    @forelse($visitors as $visitor)
    @php
        $parts    = explode(' ', trim($visitor->full_name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
        $rowNum   = str_pad($visitors->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT);
        $visitCount = $visitor->latestVisit ? $visitor->visits()->count() : 0;
        $lastDate   = $visitor->latestVisit?->check_in_time;
        $isRecent   = $lastDate && $lastDate->isAfter(now()->subDays(7));
    @endphp
    <div class="sv-row">

        {{-- # --}}
        <span class="sv-num">{{ $rowNum }}</span>

        {{-- Visitor --}}
        <div class="sv-visitor-cell">
            <div class="sv-avatar-circle">
                @if($visitor->photo)
                    <img src="{{ asset('storage/'.$visitor->photo) }}" alt="">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div>
                <span class="sv-visitor-name">{{ $visitor->full_name }}</span>
                <span class="sv-visitor-sub">
                    {{ $visitor->phone_number ?: ($visitor->national_id ?: 'No contact') }}
                </span>
            </div>
        </div>

        {{-- National ID --}}
        <div class="sv-nid-cell">
            @if($visitor->national_id)
                <span class="sv-nid">{{ $visitor->national_id }}</span>
            @else
                <span style="color:#d1d5db;font-size:13px;">—</span>
            @endif
        </div>

        {{-- Phone --}}
        <div class="sv-phone-cell">
            <span class="sv-phone">{{ $visitor->phone_number ?? '—' }}</span>
        </div>

        {{-- Visit count --}}
        <div class="sv-visits-cell">
            <span class="sv-visits-badge {{ $visitCount >= 3 ? 'high' : '' }}">{{ $visitCount }}</span>
        </div>

        {{-- Last visit --}}
        <div class="sv-last-cell">
            @if($lastDate)
                <span class="sv-last-visit {{ $isRecent ? 'recent' : '' }}">
                    {{ $lastDate->format('M d, Y') }}
                </span>
            @else
                <span style="color:#d1d5db;font-size:13px;">—</span>
            @endif
        </div>

        {{-- Action --}}
        <div style="display:flex;justify-content:flex-end;">
            <a href="{{ route('guard.visitors.show', $visitor) }}" class="sv-view-btn">
                <i class="fas fa-eye" style="font-size:11px;"></i> View
            </a>
        </div>
    </div>
    @empty
    <div class="sv-empty">
        @if(request('search'))
            <div class="sv-empty-icon"><i class="fas fa-magnifying-glass"></i></div>
            <h5>No results found</h5>
            <p>No visitors match "<strong>{{ request('search') }}</strong>". Try a different name, ID, or phone number.</p>
        @else
            <div class="sv-empty-icon"><i class="fas fa-users"></i></div>
            <h5>No visitors registered yet</h5>
            <p>Use the search bar to look up a visitor, or register a new one.</p>
        @endif
    </div>
    @endforelse

    @if($visitors->hasPages())
    <div class="sv-pagination">{{ $visitors->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

@endsection
