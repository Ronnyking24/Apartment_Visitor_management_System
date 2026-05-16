@extends('layouts.dashboard')
@section('title','Active Visitors')
@section('page-title','Active Visitors')

@push('styles')
<style>
/* ── RESIDENT ACTIVE VISITORS ── */

/* Header banner */
.tav-header {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius:14px; padding:20px 26px;
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; flex-wrap:wrap; margin-bottom:22px;
    position:relative; overflow:hidden;
}
.tav-header::after {
    content:''; position:absolute; right:-20px; top:-20px;
    width:170px; height:170px;
    background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%);
    pointer-events:none;
}
.tav-header-left h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; display:flex; align-items:center; gap:9px; }
.tav-header-left p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }

/* Live badge in header */
.tav-live-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(99,102,241,.2); border:1px solid rgba(99,102,241,.35);
    padding:4px 12px; border-radius:20px;
    font-size:11.5px; font-weight:700; color:#c7d2fe;
}
.tav-live-dot { width:7px; height:7px; border-radius:50%; background:#c7d2fe; animation:tav-pulse 1.3s ease-in-out infinite; }
@keyframes tav-pulse { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:.3;transform:scale(.6);} }

/* Count chip */
.tav-count-chip {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    padding:7px 18px; border-radius:10px; color:#fff; white-space:nowrap;
}
.tav-count-chip .chip-num { font-size:22px; font-weight:800; line-height:1; }
.tav-count-chip .chip-lbl { font-size:10px; color:rgba(255,255,255,.5); display:block; margin-top:1px; }

/* Panel */
.tav-panel {
    background:#fff; border-radius:16px;
    border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden;
}
.tav-panel-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:15px 22px; border-bottom:1px solid #f1f5f9;
}
.tav-panel-head-left { display:flex; align-items:center; gap:10px; }
.tav-panel-title { font-size:14px; font-weight:700; color:#0f172a; }

/* Column headers */
.tav-col-hdr {
    display:grid;
    grid-template-columns:44px 1fr 150px 170px 160px 160px;
    padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9;
}
.tav-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.tav-col-h.right { text-align:right; }

/* Rows */
.tav-row {
    display:grid;
    grid-template-columns:44px 1fr 150px 170px 160px 160px;
    align-items:center; padding:14px 22px;
    border-bottom:1px solid #f3f4f6;
    border-left:3px solid #1e3a8a;
    transition:background .15s;
}
.tav-row:last-child { border-bottom:none; }
.tav-row:hover { background:#f8faff; }

.tav-num { font-size:12.5px; font-weight:700; color:#94a3b8; }

/* Visitor cell */
.tav-visitor-cell { display:flex; align-items:center; gap:10px; min-width:0; }
.tav-avatar {
    width:38px; height:38px; border-radius:50%;
    background:#dbeafe; color:#1e3a8a;
    display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:700; flex-shrink:0; overflow:hidden;
    border:2px solid #bfdbfe;
}
.tav-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.tav-vname { font-size:13px; font-weight:700; color:#0f172a; display:block; margin-bottom:1px; }
.tav-vsub  { font-size:11.5px; color:#94a3b8; font-family:monospace; }

/* Phone */
.tav-phone { font-size:13px; color:#475569; }

/* Purpose pill */
.tav-purpose {
    display:inline-flex; align-items:center; gap:4px;
    padding:3px 10px; border-radius:20px;
    font-size:11.5px; font-weight:600;
    background:#f1f5f9; color:#475569;
}

/* Check-in cell */
.tav-checkin-time { font-size:15px; font-weight:800; color:#0f172a; display:block; line-height:1; margin-bottom:3px; }
.tav-checkin-ago  { font-size:11px; color:#94a3b8; }

/* Duration cell */
.tav-dur-cell { text-align:right; }
.tav-dur-val {
    font-size:16px; font-weight:800; color:#dc2626;
    font-variant-numeric:tabular-nums; font-family:monospace;
    letter-spacing:.5px; line-height:1; display:block; margin-bottom:3px;
}
.tav-dur-lbl {
    font-size:10px; font-weight:700; color:#94a3b8;
    text-transform:uppercase; letter-spacing:.6px;
}

/* Empty state */
.tav-empty { text-align:center; padding:72px 20px; }
.tav-empty-icon {
    width:76px; height:76px; background:#eff6ff;
    border-radius:22px; border:2px solid #bfdbfe;
    display:flex; align-items:center; justify-content:center;
    font-size:28px; color:#93c5fd; margin:0 auto 18px;
}
.tav-empty h5 { font-size:16px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.tav-empty p  { font-size:13px; color:#94a3b8; margin:0; }

/* Pagination */
.tav-pagination { padding:14px 22px; border-top:1px solid #f1f5f9; }

/* Dark mode */
.dark-mode .tav-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .tav-col-hdr { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .tav-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .tav-panel-title { color:#f1f5f9; }
.dark-mode .tav-row { border-color:rgba(255,255,255,.04); }
.dark-mode .tav-row:hover { background:#1e2d4a; }
.dark-mode .tav-vname { color:#e2e8f0; }
.dark-mode .tav-checkin-time { color:#e2e8f0; }
.dark-mode .tav-empty-icon { background:#0f1e38; }
.dark-mode .tav-empty h5 { color:#f1f5f9; }
.dark-mode .tav-pagination { border-color:rgba(255,255,255,.07); }

@media(max-width:900px) {
    .tav-col-hdr,.tav-row { grid-template-columns:36px 1fr 140px 140px auto; }
    .tav-col-hdr span:nth-child(3),.tav-row>div:nth-child(3) { display:none; }
}
@media(max-width:600px) {
    .tav-col-hdr { display:none; }
    .tav-row { grid-template-columns:30px 1fr auto; }
    .tav-row>div:nth-child(3),.tav-row>div:nth-child(4),.tav-row>div:nth-child(5) { display:none; }
}
</style>
@endpush

@section('content')

@php
    $count = $visits->total();
    $purposeIcons = [
        'Family visit'     => 'fa-house-user',
        'Delivery'         => 'fa-box',
        'Business meeting' => 'fa-briefcase',
        'Maintenance'      => 'fa-screwdriver-wrench',
        'Social visit'     => 'fa-people-group',
    ];
@endphp

{{-- HEADER BANNER --}}
<div class="tav-header">
    <div class="tav-header-left">
        <h2>
            <span class="tav-live-badge"><span class="tav-live-dot"></span> LIVE</span>
            Active Visitors
        </h2>
        <p>{{ now()->format('l, F d, Y') }} &mdash; Visitors currently inside your apartment</p>
    </div>
    <div class="tav-count-chip">
        <div>
            <span class="chip-num">{{ $count }}</span>
            <span class="chip-lbl">Inside Now</span>
        </div>
    </div>
</div>

{{-- PANEL --}}
<div class="tav-panel">
    <div class="tav-panel-head">
        <div class="tav-panel-head-left">
            <i class="fas fa-circle-dot" style="color:#3b82f6;font-size:13px;"></i>
            <span class="tav-panel-title">Currently Inside</span>
            <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $count }}</span>
        </div>
        <span style="font-size:12.5px;color:#94a3b8;">
            Showing {{ $visits->firstItem() ?? 0 }}–{{ $visits->lastItem() ?? 0 }} of {{ $count }}
        </span>
    </div>

    <div class="tav-col-hdr">
        <span class="tav-col-h">#</span>
        <span class="tav-col-h">Visitor</span>
        <span class="tav-col-h">Phone</span>
        <span class="tav-col-h">Purpose</span>
        <span class="tav-col-h">Check In</span>
        <span class="tav-col-h right">Duration</span>
    </div>

    @forelse($visits as $visit)
    @php
        $parts    = explode(' ', trim($visit->visitor->full_name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
        $rowNum   = str_pad($visits->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT);
        $purIcon  = $purposeIcons[$visit->purpose] ?? 'fa-tag';
        $elapsedSec = $visit->check_in_time ? abs((int) now()->diffInSeconds($visit->check_in_time)) : 0;
    @endphp
    <div class="tav-row">

        <span class="tav-num">{{ $rowNum }}</span>

        <div class="tav-visitor-cell">
            <div class="tav-avatar">
                @if($visit->visitor->photo)
                    <img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div>
                <span class="tav-vname">{{ $visit->visitor->full_name }}</span>
                <span class="tav-vsub">{{ $visit->visitor->national_id ?? '—' }}</span>
            </div>
        </div>

        <div>
            <span class="tav-phone">{{ $visit->visitor->phone_number ?? '—' }}</span>
        </div>

        <div>
            <span class="tav-purpose">
                <i class="fas {{ $purIcon }}" style="font-size:10px;"></i>
                {{ Str::limit($visit->purpose, 18) }}
            </span>
        </div>

        <div>
            <span class="tav-checkin-time">{{ $visit->check_in_time?->format('H:i') ?? '—' }}</span>
            <span class="tav-checkin-ago">{{ $visit->check_in_time?->diffForHumans() ?? '' }}</span>
        </div>

        <div class="tav-dur-cell">
            @if($visit->check_in_time)
@php
                $dh = floor($elapsedSec / 3600);
                $dm = floor(($elapsedSec % 3600) / 60);
                $ds = $elapsedSec % 60;
                $durFmt = $dh > 0
                    ? sprintf('%d:%02d:%02d', $dh, $dm, $ds)
                    : sprintf('%02d:%02d', $dm, $ds);
            @endphp
            <span class="tav-dur-val" data-seconds="{{ $elapsedSec }}">{{ $durFmt }}</span>
            <span class="tav-dur-lbl">duration</span>
            @else
            <span style="color:#94a3b8;font-size:13px;">—</span>
            @endif
        </div>
    </div>
    @empty
    <div class="tav-empty">
        <div class="tav-empty-icon"><i class="fas fa-door-closed"></i></div>
        <h5>No Active Visitors</h5>
        <p>No one is currently visiting your apartment.</p>
    </div>
    @endforelse

    @if($visits->hasPages())
    <div class="tav-pagination">{{ $visits->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const timers = document.querySelectorAll('.tav-dur-val[data-seconds]');
    if (!timers.length) return;

    timers.forEach(el => {
        let secs = parseInt(el.dataset.seconds, 10);
        function pad(n){ return String(n).padStart(2,'0'); }
        function tick(){
            secs++;
            const h = Math.floor(secs / 3600);
            const m = Math.floor((secs % 3600) / 60);
            const s = secs % 60;
            el.textContent = h > 0
                ? pad(h) + ':' + pad(m) + ':' + pad(s)
                : pad(m) + ':' + pad(s);
        }
        setInterval(tick, 1000);
    });
});
</script>
@endpush
