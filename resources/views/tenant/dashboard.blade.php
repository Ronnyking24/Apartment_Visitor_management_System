@extends('layouts.dashboard')
@section('title','My Dashboard')
@section('page-title','My Dashboard')

@push('styles')
<style>
/* ── TENANT DASHBOARD ── */

/* Header banner */
.td-header {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius:14px; padding:22px 26px;
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; flex-wrap:wrap; margin-bottom:22px;
    position:relative; overflow:hidden;
}
.td-header::after {
    content:''; position:absolute; right:-30px; top:-30px;
    width:180px; height:180px;
    background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%);
    pointer-events:none;
}
.td-header-left { min-width:0; }
.td-header-left h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.td-header-left p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }

/* Apt chip in header */
.td-apt-chip {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    padding:6px 14px; border-radius:10px; color:#fff; white-space:nowrap;
}
.td-apt-chip .apt-num { font-size:20px; font-weight:800; letter-spacing:.5px; }
.td-apt-chip .apt-sub { font-size:10px; color:rgba(255,255,255,.5); display:block; }

/* Stat strip */
.td-stats-strip { display:flex; gap:0; flex-wrap:wrap; margin-bottom:22px; }
.td-stat {
    flex:1; min-width:120px;
    background:#fff; border:1px solid #e8ecf1;
    border-right:none;
    padding:18px 20px; position:relative;
    transition:background .15s;
}
.td-stat:first-child { border-radius:14px 0 0 14px; }
.td-stat:last-child  { border-radius:0 14px 14px 0; border-right:1px solid #e8ecf1; }
.td-stat:hover { background:#f8faff; }
.td-stat-icon {
    width:36px; height:36px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    font-size:14px; margin-bottom:12px;
}
.td-stat-val { font-size:26px; font-weight:800; color:#0f172a; line-height:1; margin-bottom:4px; }
.td-stat-lbl { font-size:11.5px; color:#94a3b8; font-weight:600; }
.td-stat-accent {
    position:absolute; bottom:0; left:0; right:0; height:3px; border-radius:0;
}
.td-stat:first-child .td-stat-accent { border-radius:0 0 0 14px; }
.td-stat:last-child  .td-stat-accent { border-radius:0 0 14px 0; }

/* Two-column middle section */
.td-mid { display:grid; grid-template-columns:280px 1fr; gap:18px; margin-bottom:18px; }

/* Apartment card */
.td-apt-card {
    background:#fff; border:1px solid #e8ecf1;
    border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,.05);
    overflow:hidden;
}
.td-apt-card-head {
    padding:14px 18px; border-bottom:1px solid #f1f5f9;
    display:flex; align-items:center; gap:8px;
}
.td-apt-card-title { font-size:14px; font-weight:700; color:#0f172a; }
.td-apt-body { padding:18px; }
.td-apt-row {
    display:flex; justify-content:space-between; align-items:center;
    padding:9px 0; border-bottom:1px dashed #f1f5f9;
}
.td-apt-row:last-child { border-bottom:none; }
.td-apt-lbl { font-size:12px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:.4px; }
.td-apt-val { font-size:13px; font-weight:700; color:#0f172a; }
.td-apt-val.big { font-size:22px; color:#1e3a8a; }

/* Active visitors card */
.td-active-card {
    background:#fff; border:1px solid #e8ecf1;
    border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,.05);
    overflow:hidden; display:flex; flex-direction:column;
}
.td-active-head {
    padding:14px 18px; border-bottom:1px solid #f1f5f9;
    display:flex; align-items:center; justify-content:space-between;
}
.td-active-title { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; color:#0f172a; }
.td-live-dot { width:8px; height:8px; border-radius:50%; background:#ef4444; animation:td-pulse 1.3s ease-in-out infinite; flex-shrink:0; }
@keyframes td-pulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:.4;transform:scale(.65);} }
.td-view-all {
    font-size:12px; font-weight:600; color:#1e3a8a;
    text-decoration:none; padding:5px 12px;
    border:1.5px solid #bfdbfe; border-radius:8px;
    background:#eff6ff; transition:all .18s;
}
.td-view-all:hover { background:#dbeafe; color:#1d4ed8; }

/* Active visitor row */
.td-av-row {
    display:flex; align-items:center; gap:14px;
    padding:12px 18px; border-bottom:1px solid #f3f4f6;
    border-left:3px solid #22c55e;
}
.td-av-row:last-child { border-bottom:none; }
.td-av-avatar {
    width:36px; height:36px; border-radius:50%;
    background:#dbeafe; color:#3b82f6;
    display:flex; align-items:center; justify-content:center;
    font-size:12.5px; font-weight:700; flex-shrink:0; overflow:hidden;
}
.td-av-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.td-av-name  { font-size:13px; font-weight:700; color:#0f172a; }
.td-av-sub   { font-size:11.5px; color:#94a3b8; }
.td-av-meta  { margin-left:auto; text-align:right; flex-shrink:0; }
.td-av-time  { font-size:12px; font-weight:700; color:#0f172a; }
.td-av-ago   { font-size:11px; color:#94a3b8; }

/* Purpose pill */
.td-purpose {
    display:inline-flex; align-items:center; gap:3px;
    padding:2px 8px; border-radius:20px;
    font-size:11px; font-weight:600;
}
.pur-delivery,
.pur-family,
.pur-business,
.pur-maintenance,
.pur-social,
.pur-other       { background:#f1f5f9; color:#475569; }

/* Empty state (mini) */
.td-empty-mini { text-align:center; padding:32px 20px; }
.td-empty-mini i { font-size:30px; color:#e2e8f0; display:block; margin-bottom:10px; }
.td-empty-mini p { font-size:13px; color:#94a3b8; margin:0; }

/* Recent activity panel */
.td-recent-panel {
    background:#fff; border:1px solid #e8ecf1;
    border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden;
}
.td-recent-head {
    padding:14px 22px; border-bottom:1px solid #f1f5f9;
    display:flex; align-items:center; justify-content:space-between;
}
.td-recent-title { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; color:#0f172a; }

/* Recent col headers */
.td-col-hdr-row {
    display:grid;
    grid-template-columns:1fr 150px 130px 130px 120px 100px;
    padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9;
}
.td-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.td-col-h.right { text-align:right; }

/* Recent rows */
.td-row {
    display:grid;
    grid-template-columns:1fr 150px 130px 130px 120px 100px;
    align-items:center; padding:13px 22px;
    border-bottom:1px solid #f3f4f6; transition:background .15s;
}
.td-row:last-child { border-bottom:none; }
.td-row:hover { background:#f8faff; }

.td-visitor-cell { display:flex; align-items:center; gap:10px; min-width:0; }
.td-avatar {
    width:34px; height:34px; border-radius:50%;
    background:#dbeafe; color:#3b82f6;
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:700; flex-shrink:0; overflow:hidden;
}
.td-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.td-vname { font-size:13px; font-weight:700; color:#0f172a; display:block; }

/* Status pills */
.td-status {
    display:inline-flex; align-items:center; gap:4px;
    padding:3px 10px; border-radius:20px;
    font-size:11.5px; font-weight:700;
}
.td-status-active    { background:#dcfce7; color:#16a34a; }
.td-status-completed { background:#f1f5f9; color:#64748b; }
.td-status-pending   { background:#fef9c3; color:#92400e; }
.td-status-rejected  { background:#fee2e2; color:#dc2626; }

/* Action buttons */
.td-approve-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:28px; height:28px; border-radius:8px;
    background:#dcfce7; color:#16a34a;
    border:1.5px solid #bbf7d0; cursor:pointer;
    transition:all .18s; font-size:12px;
}
.td-approve-btn:hover { background:#16a34a; color:#fff; }
.td-reject-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:28px; height:28px; border-radius:8px;
    background:#fee2e2; color:#dc2626;
    border:1.5px solid #fecaca; cursor:pointer;
    transition:all .18s; font-size:12px;
}
.td-reject-btn:hover { background:#dc2626; color:#fff; }
.td-eye-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:28px; height:28px; border-radius:8px;
    background:#f1f5f9; color:#64748b;
    border:1.5px solid #e2e8f0; text-decoration:none;
    transition:all .18s; font-size:12px;
}
.td-eye-btn:hover { background:#e2e8f0; color:#0f172a; }

/* Time display */
.td-time { font-size:12.5px; color:#64748b; font-variant-numeric:tabular-nums; }

/* Pagination */
.td-pagination { padding:14px 22px; border-top:1px solid #f1f5f9; }

/* Dark mode */
.dark-mode .td-stat,
.dark-mode .td-apt-card,
.dark-mode .td-active-card,
.dark-mode .td-recent-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .td-stat-val,
.dark-mode .td-apt-card-title,
.dark-mode .td-active-title,
.dark-mode .td-recent-title { color:#f1f5f9; }
.dark-mode .td-apt-lbl { color:#64748b; }
.dark-mode .td-apt-val { color:#e2e8f0; }
.dark-mode .td-col-hdr-row { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .td-row { border-color:rgba(255,255,255,.04); }
.dark-mode .td-row:hover { background:#243044; }
.dark-mode .td-vname { color:#e2e8f0; }
.dark-mode .td-av-name { color:#e2e8f0; }
.dark-mode .td-time { color:#64748b; }
.dark-mode .td-apt-row { border-color:rgba(255,255,255,.05); }
.dark-mode .td-active-head,
.dark-mode .td-recent-head,
.dark-mode .td-apt-card-head { border-color:rgba(255,255,255,.07); }
.dark-mode .td-stat { border-color:rgba(255,255,255,.06); }

@media(max-width:860px) {
    .td-mid { grid-template-columns:1fr; }
    .td-col-hdr-row,.td-row { grid-template-columns:1fr 120px 110px 110px auto; }
    .td-col-hdr-row span:nth-child(4),.td-row>div:nth-child(4) { display:none; }
}
@media(max-width:560px) {
    .td-col-hdr-row { display:none; }
    .td-row { grid-template-columns:1fr auto auto; }
    .td-row>div:nth-child(2),.td-row>div:nth-child(3),.td-row>div:nth-child(4) { display:none; }
    .td-stats-strip .td-stat { border-radius:0; }
    .td-stats-strip .td-stat:first-child { border-radius:14px 14px 0 0; border-right:1px solid #e8ecf1; border-bottom:none; }
    .td-stats-strip { flex-direction:column; }
}
</style>
@endpush

@section('content')

@php
    $purposeIcons = [
        'Family visit'     => ['icon'=>'fa-house-user',        'class'=>'pur-family'],
        'Delivery'         => ['icon'=>'fa-box',               'class'=>'pur-delivery'],
        'Business meeting' => ['icon'=>'fa-briefcase',         'class'=>'pur-business'],
        'Maintenance'      => ['icon'=>'fa-screwdriver-wrench','class'=>'pur-maintenance'],
        'Social visit'     => ['icon'=>'fa-people-group',      'class'=>'pur-social'],
    ];
    $aptNum   = $tenant->apartment->apartment_number ?? '—';
    $block    = $tenant->apartment->block_name       ?? '—';
    $floor    = $tenant->apartment->floor_number     ?? '—';
@endphp

{{-- HEADER BANNER --}}
<div class="td-header">
    <div class="td-header-left">
        <h2>Welcome back, {{ auth()->user()->name }}</h2>
        <p>{{ now()->format('l, F d, Y') }} &mdash; Here's what's happening at your apartment</p>
    </div>
    @if($tenant->apartment)
    <div class="td-apt-chip">
        <div>
            <span class="apt-num">{{ $aptNum }}</span>
            <span class="apt-sub">{{ $block }} &bull; Floor {{ $floor }}</span>
        </div>
    </div>
    @endif
</div>

{{-- STAT STRIP --}}
<div class="td-stats-strip mb-4">
    <div class="td-stat">
        <div class="td-stat-icon" style="background:#eff6ff;">
            <i class="fas fa-clipboard-list" style="color:#1e3a8a;"></i>
        </div>
        <div class="td-stat-val">{{ $totalVisits }}</div>
        <div class="td-stat-lbl">Total Visitors</div>
        <div class="td-stat-accent" style="background:#1e3a8a;"></div>
    </div>
    <div class="td-stat">
        <div class="td-stat-icon" style="background:#eff6ff;">
            <i class="fas fa-circle-dot" style="color:#1e3a8a;"></i>
        </div>
        <div class="td-stat-val">{{ $activeVisits->count() }}</div>
        <div class="td-stat-lbl">Active Inside</div>
        <div class="td-stat-accent" style="background:#1e3a8a;"></div>
    </div>
    <div class="td-stat">
        <div class="td-stat-icon" style="background:#eff6ff;">
            <i class="fas fa-clock" style="color:#1e3a8a;"></i>
        </div>
        <div class="td-stat-val">{{ $pendingVisits }}</div>
        <div class="td-stat-lbl">Pending Approval</div>
        <div class="td-stat-accent" style="background:#1e3a8a;"></div>
    </div>
    <div class="td-stat">
        <div class="td-stat-icon" style="background:#eff6ff;">
            <i class="fas fa-calendar-day" style="color:#1e3a8a;"></i>
        </div>
        <div class="td-stat-val">{{ $todayVisits }}</div>
        <div class="td-stat-lbl">Today's Visits</div>
        <div class="td-stat-accent" style="background:#1e3a8a;"></div>
    </div>
</div>

{{-- MIDDLE GRID: Apartment + Active Visitors --}}
<div class="td-mid">

    {{-- Apartment Card --}}
    <div class="td-apt-card">
        <div class="td-apt-card-head">
            <i class="fas fa-building" style="color:#3b82f6;font-size:14px;"></i>
            <span class="td-apt-card-title">My Apartment</span>
        </div>
        <div class="td-apt-body">
            @if($tenant->apartment)
            <div class="td-apt-row">
                <span class="td-apt-lbl">Apt. No.</span>
                <span class="td-apt-val big">{{ $aptNum }}</span>
            </div>
            <div class="td-apt-row">
                <span class="td-apt-lbl">Block</span>
                <span class="td-apt-val">{{ $block }}</span>
            </div>
            <div class="td-apt-row">
                <span class="td-apt-lbl">Floor</span>
                <span class="td-apt-val">{{ $floor }}</span>
            </div>
            <div class="td-apt-row">
                <span class="td-apt-lbl">My Phone</span>
                <span class="td-apt-val">{{ $tenant->phone ?? '—' }}</span>
            </div>
            @else
            <p style="color:#94a3b8;font-size:13px;padding:10px 0;">No apartment assigned.</p>
            @endif
        </div>
    </div>

    {{-- Currently Visiting --}}
    <div class="td-active-card">
        <div class="td-active-head">
            <span class="td-active-title">
                <span class="td-live-dot"></span>
                Currently Visiting Me
            </span>
            <a href="{{ route('tenant.visits.active') }}" class="td-view-all">View All</a>
        </div>
        @if($activeVisits->isEmpty())
        <div class="td-empty-mini">
            <i class="fas fa-door-closed"></i>
            <p>No active visitors right now.</p>
        </div>
        @else
        @foreach($activeVisits as $visit)
        @php
            $p2 = $purposeIcons[$visit->purpose] ?? ['icon'=>'fa-ellipsis','class'=>'pur-other'];
            $np = explode(' ', trim($visit->visitor->full_name));
            $ni = strtoupper(substr($np[0],0,1)).(isset($np[1]) ? strtoupper(substr($np[1],0,1)) : '');
        @endphp
        <div class="td-av-row">
            <div class="td-av-avatar">
                @if($visit->visitor->photo)
                    <img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">
                @else
                    {{ $ni }}
                @endif
            </div>
            <div style="min-width:0;">
                <div class="td-av-name">{{ $visit->visitor->full_name }}</div>
                <span class="td-purpose {{ $p2['class'] }}">
                    <i class="fas {{ $p2['icon'] }}" style="font-size:9px;"></i>
                    {{ $visit->purpose }}
                </span>
            </div>
            <div class="td-av-meta">
                <div class="td-av-time">{{ $visit->check_in_time?->format('H:i') ?? '—' }}</div>
                <div class="td-av-ago">{{ $visit->check_in_time?->diffForHumans() ?? '' }}</div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

{{-- RECENT VISITOR ACTIVITY --}}
<div class="td-recent-panel">
    <div class="td-recent-head">
        <span class="td-recent-title">
            <i class="fas fa-clock-rotate-left" style="color:#3b82f6;font-size:14px;"></i>
            Recent Visitor Activity
        </span>
        <a href="{{ route('tenant.visits.index') }}" class="td-view-all">View All</a>
    </div>

    {{-- Col headers --}}
    <div class="td-col-hdr-row">
        <span class="td-col-h">Visitor</span>
        <span class="td-col-h">Purpose</span>
        <span class="td-col-h">Check In</span>
        <span class="td-col-h">Check Out</span>
        <span class="td-col-h">Status</span>
        <span class="td-col-h right">Action</span>
    </div>

    @forelse($recentVisits as $visit)
    @php
        $p3     = $purposeIcons[$visit->purpose] ?? ['icon'=>'fa-ellipsis','class'=>'pur-other'];
        $rparts = explode(' ', trim($visit->visitor->full_name));
        $ri     = strtoupper(substr($rparts[0],0,1)).(isset($rparts[1]) ? strtoupper(substr($rparts[1],0,1)) : '');
        $sCls   = 'td-status-'.($visit->status);
        $sLabel = match($visit->status) {
            'active'    => 'Inside',
            'completed' => 'Checked Out',
            'pending'   => 'Pending',
            'rejected'  => 'Rejected',
            default     => ucfirst($visit->status),
        };
    @endphp
    <div class="td-row">

        {{-- Visitor --}}
        <div class="td-visitor-cell">
            <div class="td-avatar">
                @if($visit->visitor->photo)
                    <img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">
                @else
                    {{ $ri }}
                @endif
            </div>
            <span class="td-vname">{{ $visit->visitor->full_name }}</span>
        </div>

        {{-- Purpose --}}
        <div>
            <span class="td-purpose {{ $p3['class'] }}">
                <i class="fas {{ $p3['icon'] }}" style="font-size:9px;"></i>
                {{ Str::limit($visit->purpose, 20) }}
            </span>
        </div>

        {{-- Check In --}}
        <div>
            <span class="td-time">{{ $visit->check_in_time?->format('M d, H:i') ?? '—' }}</span>
        </div>

        {{-- Check Out --}}
        <div>
            <span class="td-time">{{ $visit->check_out_time?->format('M d, H:i') ?? '—' }}</span>
        </div>

        {{-- Status --}}
        <div>
            <span class="td-status {{ $sCls }}">{{ $sLabel }}</span>
        </div>

        {{-- Action --}}
        <div style="display:flex;justify-content:flex-end;gap:6px;">
            @if($visit->status === 'pending')
            <form method="POST" action="{{ route('tenant.visits.approve', $visit) }}" style="margin:0;">
                @csrf @method('PATCH')
                <button class="td-approve-btn" title="Approve"><i class="fas fa-check"></i></button>
            </form>
            <form method="POST" action="{{ route('tenant.visits.reject', $visit) }}" style="margin:0;">
                @csrf @method('PATCH')
                <button class="td-reject-btn" title="Reject"><i class="fas fa-times"></i></button>
            </form>
            @else
            <a href="{{ route('tenant.visits.show', $visit) }}" class="td-eye-btn" title="View"><i class="fas fa-eye"></i></a>
            @endif
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:52px 20px;">
        <i class="fas fa-clock-rotate-left" style="font-size:28px;color:#e2e8f0;display:block;margin-bottom:12px;"></i>
        <p style="color:#94a3b8;font-size:13px;margin:0;">No visitor activity recorded yet.</p>
    </div>
    @endforelse
</div>

@endsection
