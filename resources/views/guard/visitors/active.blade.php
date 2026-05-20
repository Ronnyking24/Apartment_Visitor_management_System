@extends('layouts.dashboard')
@section('title','Active Visitors')
@section('page-title','Active Visitors')

@push('styles')
<style>
/* ── ACTIVE VISITORS PAGE ── */

/* Header banner */
.av-header {
    background: linear-gradient(135deg,#0f172a 0%,#7f1d1d 100%);
    border-radius: 14px;
    padding: 20px 26px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; flex-wrap: wrap;
    margin-bottom: 22px;
    position: relative; overflow: hidden;
}
.av-header::after {
    content:''; position:absolute; right:-20px; top:-20px;
    width:160px; height:160px;
    background:radial-gradient(circle,rgba(239,68,68,.2) 0%,transparent 70%);
    pointer-events:none;
}
.av-header-left h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 4px; }
.av-header-left p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.av-header-stats   { display:flex; gap:20px; flex-wrap:wrap; align-items:center; }
.av-hstat { text-align:center; }
.av-hstat-num { font-size:22px; font-weight:800; color:#fff; line-height:1; font-variant-numeric:tabular-nums; }
.av-hstat-lbl { font-size:10px; color:rgba(255,255,255,.4); font-weight:600; text-transform:uppercase; letter-spacing:.6px; margin-top:2px; }
.av-hstat-div { width:1px; background:rgba(255,255,255,.12); align-self:stretch; }

/* Live pulse badge */
.av-live-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(239,68,68,.15); color:#fca5a5;
    border:1px solid rgba(239,68,68,.3);
    font-size:11.5px; font-weight:700;
    padding:5px 12px; border-radius:20px; white-space:nowrap;
}
.av-live-dot {
    width:7px; height:7px; border-radius:50%; background:#ef4444;
    animation:pulse-red 1.3s ease-in-out infinite;
    flex-shrink:0;
}
@keyframes pulse-red {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(.65); }
}

/* Register button */
.av-reg-btn {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 18px;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    color:#fff; font-size:13px; font-weight:700;
    border-radius:10px; text-decoration:none;
    transition:all .2s; white-space:nowrap;
    backdrop-filter:blur(4px);
}
.av-reg-btn:hover { background:rgba(255,255,255,.22); color:#fff; }

/* Panel */
.av-panel {
    background:#fff;
    border-radius:16px;
    border:1px solid #e8ecf1;
    box-shadow:0 1px 4px rgba(0,0,0,.05);
    overflow:hidden;
}

/* Panel header */
.av-panel-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 22px;
    border-bottom:1px solid #f1f5f9;
}
.av-panel-head-left { display:flex; align-items:center; gap:10px; }
.av-panel-title { font-size:15px; font-weight:700; color:#0f172a; }
.av-count-badge {
    background:#fef2f2; color:#ef4444;
    font-size:11.5px; font-weight:700;
    padding:2px 10px; border-radius:20px;
}
.av-panel-meta { font-size:12.5px; color:#94a3b8; }

/* Column header row */
.av-col-hdr-row {
    display:grid;
    grid-template-columns:40px 1.2fr 0.9fr 130px 100px 100px 1fr;
    column-gap:12px;
    padding:9px 22px;
    background:#fafbfc;
    border-bottom:1px solid #f1f5f9;
    align-items:center;
}
.av-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.av-col-h.right { text-align:right; }

/* Rows */
.av-row {
    display:grid;
    grid-template-columns:40px 1.2fr 0.9fr 130px 100px 100px 1fr;
    column-gap:12px;
    align-items:center;
    padding:15px 22px;
    border-bottom:1px solid #f3f4f6;
    border-left:3px solid #22c55e;
    transition:background .15s;
}
.av-row:last-child { border-bottom:none; }
.av-row:hover { background:#f8faff; }

/* Row number */
.av-num { font-size:12.5px; font-weight:700; color:#94a3b8; font-variant-numeric:tabular-nums; }

/* Visitor cell */
.av-visitor-cell { display:flex; align-items:center; gap:16px; min-width:0; }
.av-avatar-circle {
    width:38px; height:38px; border-radius:50%;
    background:#dbeafe; color:#3b82f6;
    display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:700; flex-shrink:0;
    letter-spacing:.3px; overflow:hidden;
}
.av-avatar-circle img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.av-vinfo { min-width:0; }
.av-visitor-name  { font-size:13.5px; font-weight:700; color:#0f172a; display:block; margin-bottom:2px; }
.av-visitor-sub   { font-size:11.5px; color:#94a3b8; }

/* Host / Apt cell */
.av-host-cell { display:flex; flex-direction:column; min-width:0; }
.av-host-name { display:block; font-size:13px; font-weight:600; color:#0f172a; margin-bottom:6px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.av-host-apt  { display:inline-flex; align-items:center; gap:6px; font-size:12px; color:#64748b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.av-host-apt i { font-size:10px; color:#94a3b8; }

/* Purpose cell */
.av-purpose-cell { display:flex; align-items:center; min-width:0; }
.av-purpose {
    display:inline-flex; align-items:center; gap:4px;
    padding:4px 11px; border-radius:20px;
    font-size:11.5px; font-weight:600; white-space:nowrap;
    overflow:hidden; text-overflow:ellipsis;
}
.pur-delivery    { background:#dbeafe; color:#2563eb; }
.pur-family      { background:#dcfce7; color:#16a34a; }
.pur-business    { background:#ede9fe; color:#6d28d9; }
.pur-maintenance { background:#fef9c3; color:#92400e; }
.pur-social      { background:#ccfbf1; color:#0e7490; }
.pur-other       { background:#f1f5f9; color:#475569; }

/* Check-in time */
.av-checkin-cell { display:flex; flex-direction:column; min-width:0; }
.av-checkin-time { font-size:13px; font-weight:700; color:#0f172a; font-variant-numeric:tabular-nums; display:block; margin-bottom:2px; }
.av-checkin-ago  { font-size:11.5px; color:#94a3b8; }

/* Live duration */
.av-dur-timer {
    font-size:14px; font-weight:800;
    color:#ef4444; font-variant-numeric:tabular-nums;
    letter-spacing:.5px;
}

/* Checkout button */
.av-dur-cell { display:flex; align-items:center; justify-content:center; }
.av-action-cell { display:flex; align-items:center; justify-content:flex-end; }
.av-checkout-btn {
    display:inline-flex; align-items:center; gap:5px;
    padding:7px 15px; border-radius:20px;
    background:linear-gradient(135deg,#ef4444,#dc2626);
    color:#fff; border:none; font-size:12px; font-weight:700;
    cursor:pointer; font-family:inherit;
    box-shadow:0 2px 8px rgba(239,68,68,.2);
    transition:all .18s; white-space:nowrap;
}
.av-checkout-btn:hover { background:linear-gradient(135deg,#dc2626,#b91c1c); transform:translateY(-1px); }

/* Empty state */
.av-empty { text-align:center; padding:64px 20px; }
.av-empty-icon {
    width:72px; height:72px; background:#f0fdf4; border-radius:20px;
    display:flex; align-items:center; justify-content:center;
    font-size:28px; color:#22c55e; margin:0 auto 16px;
}
.av-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.av-empty p  { font-size:13px; color:#94a3b8; margin:0; }

/* Pagination */
.av-pagination { padding:14px 22px; border-top:1px solid #f1f5f9; }

/* Dark mode */
.dark-mode .av-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .av-col-hdr-row { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .av-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .av-panel-title { color:#f1f5f9; }
.dark-mode .av-count-badge { background:#450a0a; color:#fca5a5; }
.dark-mode .av-row { border-color:rgba(255,255,255,.04); }
.dark-mode .av-row:hover { background:#243044; }
.dark-mode .av-visitor-name { color:#e2e8f0; }
.dark-mode .av-host-name { color:#e2e8f0; }
.dark-mode .av-checkin-time { color:#e2e8f0; }
.dark-mode .av-empty-icon { background:#0f2918; }
.dark-mode .av-empty h5 { color:#f1f5f9; }
.dark-mode .av-pagination { border-color:rgba(255,255,255,.07); }

@media(max-width:1024px) {
    .av-col-hdr-row,
    .av-row { grid-template-columns:36px 1fr 0.8fr 120px 90px 90px auto; }
}
@media(max-width:768px) {
    .av-col-hdr-row { font-size:9px; }
    .av-row { grid-template-columns:32px 1.5fr 120px 80px auto; }
    .av-host-cell { display:none; }
    .av-checkin-cell { display:none; }
    .av-col-h:nth-child(3),
    .av-col-h:nth-child(5) { display:none; }
}
@media(max-width:680px) {
    .av-col-hdr-row { display:none; }
    .av-row { grid-template-columns:32px 1fr auto; }
    .av-host-cell,.av-purpose-cell,.av-checkin-cell { display:none; }
}
</style>
@endpush

@section('content')

@php
    $total = $visits->total();
    $purposeIcons = [
        'Family visit'     => ['icon'=>'fa-house-user',        'class'=>'pur-family'],
        'Delivery'         => ['icon'=>'fa-box',               'class'=>'pur-delivery'],
        'Business meeting' => ['icon'=>'fa-briefcase',         'class'=>'pur-business'],
        'Maintenance'      => ['icon'=>'fa-screwdriver-wrench','class'=>'pur-maintenance'],
        'Social visit'     => ['icon'=>'fa-people-group',      'class'=>'pur-social'],
    ];
@endphp

{{-- HEADER BANNER --}}
<div class="av-header">
    <div class="av-header-left">
        <h2>
            <span class="av-live-badge me-2"><span class="av-live-dot"></span>LIVE</span>
            Active Visitors
        </h2>
        <p>{{ now()->format('l, F d, Y') }} &mdash; Visitors currently inside the complex</p>
    </div>
    <div class="av-header-stats d-none d-md-flex">
        <div class="av-hstat">
            <div class="av-hstat-num">{{ $total }}</div>
            <div class="av-hstat-lbl">Inside Now</div>
        </div>
    </div>
    <a href="{{ route('guard.visitors.create') }}" class="av-reg-btn">
        <i class="fas fa-user-plus"></i> Register Visitor
    </a>
</div>

{{-- PANEL --}}
<div class="av-panel">

    {{-- Panel header --}}
    <div class="av-panel-head">
        <div class="av-panel-head-left">
            <i class="fas fa-circle-dot" style="color:#ef4444;font-size:14px;"></i>
            <span class="av-panel-title">Active Visitors</span>
            <span class="av-count-badge">{{ $total }}</span>
        </div>
        <span class="av-panel-meta">
            {{ $visits->firstItem() ?? 0 }}–{{ $visits->lastItem() ?? 0 }} of {{ $total }} visitors inside
        </span>
    </div>

    {{-- Column headers --}}
    <div class="av-col-hdr-row">
        <span class="av-col-h">#</span>
        <span class="av-col-h">Visitor</span>
        <span class="av-col-h">Host / Apt</span>
        <span class="av-col-h">Purpose</span>
        <span class="av-col-h">Check In</span>
        <span class="av-col-h">Duration</span>
        <span class="av-col-h right">Action</span>
    </div>

    @forelse($visits as $visit)
    @php
        $p       = $purposeIcons[$visit->purpose] ?? ['icon'=>'fa-ellipsis','class'=>'pur-other'];
        $parts   = explode(' ', trim($visit->visitor->full_name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
        $rowNum  = str_pad($visits->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT);
        $checkinTs = $visit->check_in_time?->timestamp ?? 0;
        $initialDur = $visit->check_in_time ? gmdate('H:i:s', now()->diffInSeconds($visit->check_in_time)) : '—';
    @endphp
    <div class="av-row">

        {{-- # --}}
        <span class="av-num">{{ $rowNum }}</span>

        {{-- Visitor --}}
        <div class="av-visitor-cell">
            <div class="av-avatar-circle">
                @if($visit->visitor->photo)
                    <img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div class="av-vinfo">
                <span class="av-visitor-name">{{ $visit->visitor->full_name }}</span>
                <span class="av-visitor-sub">
                    {{ $visit->visitor->phone_number ?: ($visit->visitor->national_id ? $visit->visitor->national_id : 'No contact') }}
                </span>
            </div>
        </div>

        {{-- Host / Apt --}}
        <div class="av-host-cell">
            <span class="av-host-name">{{ $visit->tenant->user->name ?? '—' }}</span>
            <span class="av-host-apt">
                <i class="fas fa-building"></i>
                {{ $visit->tenant->apartment_display ?? 'N/A' }}
            </span>
        </div>

        {{-- Purpose --}}
        <div class="av-purpose-cell">
            <span class="av-purpose {{ $p['class'] }}">
                <i class="fas {{ $p['icon'] }}" style="font-size:10px;"></i>
                {{ $visit->purpose }}
            </span>
        </div>

        {{-- Check-in time --}}
        <div class="av-checkin-cell">
            <span class="av-checkin-time">{{ $visit->check_in_time?->format('H:i') ?? '—' }}</span>
            <span class="av-checkin-ago">{{ $visit->check_in_time?->diffForHumans() ?? '' }}</span>
        </div>

        {{-- Live duration --}}
        <div class="av-dur-cell">
            <span class="av-dur-timer" data-checkin="{{ $checkinTs }}">{{ $initialDur }}</span>
        </div>

        {{-- Action --}}
        <div class="av-action-cell">
            <form method="POST" action="{{ route('guard.visits.checkout', $visit) }}"
                  onsubmit="return confirm('Check out {{ addslashes($visit->visitor->full_name) }}?')"
                  style="margin:0;">
                @csrf @method('PATCH')
                <button class="av-checkout-btn">
                    <i class="fas fa-right-from-bracket" style="font-size:11px;"></i> Check Out
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="av-empty">
        <div class="av-empty-icon"><i class="fas fa-check-circle"></i></div>
        <h5>No active visitors</h5>
        <p>The complex is clear. All checked-in visitors have been checked out.</p>
    </div>
    @endforelse

    @if($visits->hasPages())
    <div class="av-pagination">{{ $visits->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

@endsection

@push('scripts')
<script>
(function () {
    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        const now = Math.floor(Date.now() / 1000);
        document.querySelectorAll('.av-dur-timer').forEach(function (el) {
            const checkin = parseInt(el.dataset.checkin, 10);
            if (!checkin) return;
            const diff = now - checkin;
            const h = Math.floor(diff / 3600);
            const m = Math.floor((diff % 3600) / 60);
            const s = diff % 60;
            el.textContent = (h > 0 ? pad(h) + ':' : '') + pad(m) + ':' + pad(s);
        });
    }

    tick();
    setInterval(tick, 1000);
})();
</script>
@endpush
