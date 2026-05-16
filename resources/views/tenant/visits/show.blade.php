@extends('layouts.dashboard')
@section('title','Visit Details')
@section('page-title','Visit Details')

@push('styles')
<style>
/* ── VISIT DETAIL PAGE ── */

.vd-wrap { max-width:720px; margin:0 auto; }

/* Breadcrumb nav */
.vd-breadcrumb {
    display:flex; align-items:center; gap:8px;
    font-size:12.5px; color:#94a3b8; margin-bottom:20px;
}
.vd-breadcrumb a { color:#64748b; text-decoration:none; font-weight:600; }
.vd-breadcrumb a:hover { color:#1e3a8a; }
.vd-breadcrumb i { font-size:10px; }

/* Visitor hero card */
.vd-hero {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius:18px; padding:28px 26px 24px;
    position:relative; overflow:hidden; margin-bottom:14px;
}
.vd-hero::after {
    content:''; position:absolute; right:-30px; top:-30px;
    width:200px; height:200px;
    background:radial-gradient(circle,rgba(99,102,241,.2) 0%,transparent 70%);
    pointer-events:none;
}
.vd-hero-inner { display:flex; align-items:center; gap:20px; position:relative; z-index:1; }
.vd-big-avatar {
    width:72px; height:72px; border-radius:18px;
    flex-shrink:0; overflow:hidden;
    background:rgba(255,255,255,.15);
    display:flex; align-items:center; justify-content:center;
    font-size:26px; font-weight:800; color:#fff;
    border:2px solid rgba(255,255,255,.2);
}
.vd-big-avatar img { width:100%; height:100%; object-fit:cover; border-radius:18px; }
.vd-hero-info { flex:1; min-width:0; }
.vd-hero-name { font-size:20px; font-weight:800; color:#fff; margin:0 0 5px; }
.vd-hero-meta { display:flex; flex-wrap:wrap; gap:12px; }
.vd-hero-chip {
    display:inline-flex; align-items:center; gap:5px;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.12);
    padding:3px 11px; border-radius:20px;
    font-size:12px; color:rgba(255,255,255,.8);
}
.vd-hero-chip i { font-size:10px; color:rgba(255,255,255,.5); }

/* Status badge on hero */
.vd-status-badge {
    position:absolute; top:18px; right:18px; z-index:2;
    display:inline-flex; align-items:center; gap:5px;
    padding:5px 14px; border-radius:20px;
    font-size:12px; font-weight:700; backdrop-filter:blur(4px);
}
.vd-status-active    { background:rgba(34,197,94,.2); border:1px solid rgba(34,197,94,.4); color:#86efac; }
.vd-status-completed { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); color:rgba(255,255,255,.7); }
.vd-status-pending   { background:rgba(245,158,11,.2); border:1px solid rgba(245,158,11,.35); color:#fcd34d; }
.vd-status-rejected  { background:rgba(239,68,68,.2); border:1px solid rgba(239,68,68,.35); color:#fca5a5; }
.vd-live-dot { width:7px; height:7px; border-radius:50%; background:#86efac; animation:vd-pulse 1.3s ease-in-out infinite; }
@keyframes vd-pulse { 0%,100%{opacity:1;} 50%{opacity:.35;} }

/* Detail card */
.vd-card {
    background:#fff; border-radius:16px;
    border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05);
    overflow:hidden; margin-bottom:14px;
}
.vd-card-head {
    display:flex; align-items:center; gap:8px;
    padding:14px 22px; border-bottom:1px solid #f1f5f9;
}
.vd-card-title { font-size:14px; font-weight:700; color:#0f172a; }

/* Purpose section */
.vd-purpose-row {
    display:flex; align-items:center; gap:12px;
    padding:18px 22px; border-bottom:1px solid #f3f4f6;
}
.vd-purpose-icon {
    width:42px; height:42px; border-radius:12px;
    background:#eff6ff; display:flex; align-items:center; justify-content:center;
    font-size:16px; color:#1e3a8a; flex-shrink:0;
}
.vd-purpose-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; margin-bottom:3px; }
.vd-purpose-val { font-size:15px; font-weight:700; color:#0f172a; }

/* Timeline */
.vd-timeline {
    display:grid; grid-template-columns:1fr auto 1fr;
    align-items:center; gap:0; padding:22px 22px; border-bottom:1px solid #f3f4f6;
}
.vd-tl-node { display:block; }
.vd-tl-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; margin-bottom:5px; display:flex; align-items:center; gap:5px; }
.vd-tl-lbl i { font-size:10px; }
.vd-tl-time { font-size:17px; font-weight:800; color:#0f172a; line-height:1; margin-bottom:2px; }
.vd-tl-date { font-size:12px; color:#94a3b8; }
.vd-tl-center { display:flex; flex-direction:column; align-items:center; gap:3px; padding:0 18px; }
.vd-tl-line { display:flex; align-items:center; gap:0; width:100%; }
.vd-tl-dash { flex:1; height:2px; background:#e2e8f0; }
.vd-tl-arrow { font-size:14px; color:#94a3b8; }
.vd-duration-chip {
    background:#eff6ff; color:#1e3a8a;
    border:1px solid #bfdbfe; padding:3px 12px;
    border-radius:20px; font-size:12px; font-weight:700; white-space:nowrap;
}
.vd-tl-empty { font-size:22px; font-weight:700; color:#cbd5e1; }

/* Info grid */
.vd-info-grid {
    display:grid; grid-template-columns:1fr 1fr;
    gap:0;
}
.vd-info-cell {
    padding:16px 22px; border-bottom:1px solid #f3f4f6;
}
.vd-info-cell:nth-child(odd) { border-right:1px solid #f3f4f6; }
.vd-info-cell:last-child,
.vd-info-cell:nth-last-child(2):nth-child(odd) { border-bottom:none; }
.vd-info-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; margin-bottom:6px; display:flex; align-items:center; gap:5px; }
.vd-info-lbl i { font-size:10px; }
.vd-info-val { font-size:13.5px; font-weight:700; color:#0f172a; }

/* Approved badge */
.vd-appr {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 12px; border-radius:20px;
    font-size:12.5px; font-weight:700;
}
.vd-appr.yes { background:#dcfce7; color:#16a34a; }
.vd-appr.no  { background:#fef9c3; color:#92400e; }

/* Pending action card */
.vd-action-card {
    background:#fffbeb; border:1.5px solid #fde68a;
    border-radius:16px; padding:20px 22px; margin-bottom:14px;
}
.vd-action-card-title {
    display:flex; align-items:center; gap:8px;
    font-size:14px; font-weight:700; color:#92400e; margin-bottom:14px;
}
.vd-action-btns { display:flex; gap:10px; }
.vd-approve-btn {
    flex:1; padding:11px 20px; border-radius:11px; border:none;
    background:linear-gradient(135deg,#16a34a,#15803d); color:#fff;
    font-size:14px; font-weight:700; cursor:pointer; font-family:inherit;
    display:flex; align-items:center; justify-content:center; gap:7px;
    box-shadow:0 2px 8px rgba(22,163,74,.25); transition:all .2s;
}
.vd-approve-btn:hover { background:linear-gradient(135deg,#15803d,#166534); }
.vd-reject-btn {
    flex:1; padding:11px 20px; border-radius:11px;
    background:#fff; color:#dc2626;
    border:1.5px solid #fecaca;
    font-size:14px; font-weight:700; cursor:pointer; font-family:inherit;
    display:flex; align-items:center; justify-content:center; gap:7px;
    transition:all .2s;
}
.vd-reject-btn:hover { background:#fee2e2; border-color:#fca5a5; }

/* Back button */
.vd-back {
    display:flex; align-items:center; justify-content:center; gap:8px;
    width:100%; padding:12px 20px; border-radius:12px;
    background:#fff; border:1.5px solid #e2e8f0; color:#64748b;
    font-size:14px; font-weight:600; text-decoration:none;
    transition:all .2s;
}
.vd-back:hover { background:#f8faff; border-color:#bfdbfe; color:#1e3a8a; }

/* Dark mode */
.dark-mode .vd-card { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .vd-card-head,
.dark-mode .vd-purpose-row,
.dark-mode .vd-timeline,
.dark-mode .vd-info-cell { border-color:rgba(255,255,255,.05); }
.dark-mode .vd-card-title,
.dark-mode .vd-purpose-val,
.dark-mode .vd-tl-time,
.dark-mode .vd-info-val { color:#f1f5f9; }
.dark-mode .vd-purpose-icon { background:#1e3366; color:#93c5fd; }
.dark-mode .vd-back { background:#1e293b; border-color:rgba(255,255,255,.1); color:#94a3b8; }
.dark-mode .vd-back:hover { background:#243044; border-color:#3b82f6; color:#93c5fd; }
.dark-mode .vd-action-card { background:#1c1200; border-color:#92400e; }
.dark-mode .vd-reject-btn { background:#1e293b; }
</style>
@endpush

@section('content')

@php
    $parts   = explode(' ', trim($visit->visitor->full_name));
    $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');

    $purposeIcons = [
        'Family visit'     => 'fa-house-user',
        'Delivery'         => 'fa-box',
        'Business meeting' => 'fa-briefcase',
        'Maintenance'      => 'fa-screwdriver-wrench',
        'Social visit'     => 'fa-people-group',
    ];
    $purIcon = $purposeIcons[$visit->purpose] ?? 'fa-tag';

    $statusLabels = [
        'active'    => 'Inside',
        'completed' => 'Checked Out',
        'pending'   => 'Pending',
        'rejected'  => 'Rejected',
    ];
    $sLabel = $statusLabels[$visit->status] ?? ucfirst($visit->status);

    $duration = null;
    if ($visit->check_in_time && $visit->check_out_time) {
        $mins = (int) $visit->check_in_time->diffInMinutes($visit->check_out_time);
        $duration = $mins >= 60
            ? floor($mins/60).'h '.($mins%60).'m'
            : $mins.'m';
    } elseif ($visit->duration) {
        $duration = $visit->duration;
    }
@endphp

<div class="vd-wrap">

    {{-- Breadcrumb --}}
    <div class="vd-breadcrumb">
        <a href="{{ route('resident.visits.index') }}"><i class="fas fa-clock-rotate-left"></i> Visit History</a>
        <i class="fas fa-chevron-right"></i>
        <span>Visit #{{ $visit->id }}</span>
    </div>

    {{-- HERO: Visitor profile --}}
    <div class="vd-hero">
        <span class="vd-status-badge vd-status-{{ $visit->status }}">
            @if($visit->status === 'active')<span class="vd-live-dot"></span>@endif
            {{ $sLabel }}
        </span>
        <div class="vd-hero-inner">
            <div class="vd-big-avatar">
                @if($visit->visitor->photo)
                    <img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div class="vd-hero-info">
                <h2 class="vd-hero-name">{{ $visit->visitor->full_name }}</h2>
                <div class="vd-hero-meta">
                    @if($visit->visitor->phone_number)
                    <span class="vd-hero-chip"><i class="fas fa-phone"></i> {{ $visit->visitor->phone_number }}</span>
                    @endif
                    @if($visit->visitor->national_id)
                    <span class="vd-hero-chip"><i class="fas fa-id-card"></i> {{ $visit->visitor->national_id }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- VISIT DETAIL CARD --}}
    <div class="vd-card">
        <div class="vd-card-head">
            <i class="fas fa-clipboard-check" style="color:#1e3a8a;font-size:14px;"></i>
            <span class="vd-card-title">Visit Details</span>
        </div>

        {{-- Purpose row --}}
        <div class="vd-purpose-row">
            <div class="vd-purpose-icon">
                <i class="fas {{ $purIcon }}"></i>
            </div>
            <div>
                <div class="vd-purpose-lbl"><i class="fas fa-tag"></i> Purpose</div>
                <div class="vd-purpose-val">{{ $visit->purpose }}</div>
            </div>
        </div>

        {{-- Timeline: Check In → Duration → Check Out --}}
        <div class="vd-timeline">
            <div class="vd-tl-node">
                <div class="vd-tl-lbl" style="color:#22c55e;"><i class="fas fa-arrow-right-to-bracket"></i> Check In</div>
                @if($visit->check_in_time)
                    <div class="vd-tl-time">{{ $visit->check_in_time->format('H:i') }}</div>
                    <div class="vd-tl-date">{{ $visit->check_in_time->format('M d, Y') }}</div>
                @else
                    <div class="vd-tl-empty">—</div>
                @endif
            </div>
            <div class="vd-tl-center">
                <div class="vd-tl-line">
                    <div class="vd-tl-dash"></div>
                    <i class="fas fa-arrow-right vd-tl-arrow" style="margin:0 6px;"></i>
                    <div class="vd-tl-dash"></div>
                </div>
                @if($duration)
                <span class="vd-duration-chip"><i class="fas fa-hourglass-half" style="font-size:9px;"></i> {{ $duration }}</span>
                @endif
            </div>
            <div class="vd-tl-node" style="text-align:right;">
                <div class="vd-tl-lbl" style="justify-content:flex-end;"><i class="fas fa-arrow-right-from-bracket"></i> Check Out</div>
                @if($visit->check_out_time)
                    <div class="vd-tl-time">{{ $visit->check_out_time->format('H:i') }}</div>
                    <div class="vd-tl-date">{{ $visit->check_out_time->format('M d, Y') }}</div>
                @else
                    <div class="vd-tl-empty">—</div>
                @endif
            </div>
        </div>

        {{-- Info grid --}}
        <div class="vd-info-grid">
            <div class="vd-info-cell">
                <div class="vd-info-lbl"><i class="fas fa-shield-check"></i> Resident Approval</div>
                <div class="vd-info-val">
                    @if($visit->approved_by_resident)
                        <span class="vd-appr yes"><i class="fas fa-check" style="font-size:10px;"></i> Approved</span>
                    @else
                        <span class="vd-appr no"><i class="fas fa-clock" style="font-size:10px;"></i> Not Yet</span>
                    @endif
                </div>
            </div>
            <div class="vd-info-cell">
                <div class="vd-info-lbl"><i class="fas fa-building"></i> Apartment</div>
                <div class="vd-info-val">
                    {{ $visit->tenant->apartment_display ?? '—' }}
                    @if($visit->tenant->apartment)
                        <span style="font-size:12px;color:#94a3b8;font-weight:500;"> &bull; {{ $visit->tenant->apartment->block_name }}</span>
                    @endif
                </div>
            </div>
            <div class="vd-info-cell">
                <div class="vd-info-lbl"><i class="fas fa-calendar-plus"></i> Recorded On</div>
                <div class="vd-info-val">{{ $visit->created_at->format('M d, Y') }}</div>
            </div>
            <div class="vd-info-cell">
                <div class="vd-info-lbl"><i class="fas fa-hashtag"></i> Visit ID</div>
                <div class="vd-info-val" style="font-family:monospace;font-size:13px;">#{{ str_pad($visit->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
    </div>

    {{-- PENDING ACTIONS --}}
    @if($visit->status === 'pending')
    <div class="vd-action-card">
        <div class="vd-action-card-title">
            <i class="fas fa-triangle-exclamation"></i>
            This visit is awaiting your approval
        </div>
        <div class="vd-action-btns">
            <form method="POST" action="{{ route('resident.visits.approve', $visit) }}" style="flex:1;display:flex;">
                @csrf @method('PATCH')
                <button class="vd-approve-btn">
                    <i class="fas fa-check"></i> Approve Visit
                </button>
            </form>
            <form method="POST" action="{{ route('resident.visits.reject', $visit) }}" style="flex:1;display:flex;"
                  onsubmit="return confirm('Reject this visit?')">
                @csrf @method('PATCH')
                <button class="vd-reject-btn">
                    <i class="fas fa-times"></i> Reject
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- BACK BUTTON --}}
    <a href="{{ route('resident.visits.index') }}" class="vd-back">
        <i class="fas fa-arrow-left" style="font-size:12px;"></i>
        Back to Visit History
    </a>

</div>
@endsection
