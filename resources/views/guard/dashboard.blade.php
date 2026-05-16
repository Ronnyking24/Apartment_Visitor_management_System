@extends('layouts.dashboard')
@section('title','Guard Dashboard')
@section('page-title','Command Center')

@push('styles')
<style>
/* ── GUARD DASHBOARD ── */
.gd-shift-banner {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f2460 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(15,23,42,.25);
}
.gd-shift-banner::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(59,130,246,.18) 0%, transparent 70%);
    pointer-events: none;
}
.gd-shift-banner::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 20%;
    width: 300px; height: 200px;
    background: radial-gradient(circle, rgba(99,102,241,.12) 0%, transparent 70%);
    pointer-events: none;
}
.gd-duty-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(132,204,22,.2);
    border: 1px solid rgba(132,204,22,.4);
    color: #bef264;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 20px;
    margin-bottom: 8px;
}
.gd-duty-dot {
    width: 7px; height: 7px;
    background: #bef264;
    border-radius: 50%;
    animation: gdPulse 1.6s ease-in-out infinite;
}
@keyframes gdPulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: .5; transform: scale(1.4); }
}
.gd-shift-name {
    font-size: 24px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 4px;
    line-height: 1.2;
}
.gd-shift-sub {
    font-size: 13px;
    color: rgba(255,255,255,.5);
}
.gd-clock-block {
    text-align: right;
}
.gd-clock {
    font-size: 38px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -1px;
    line-height: 1;
    font-variant-numeric: tabular-nums;
}
.gd-date {
    font-size: 12px;
    color: rgba(255,255,255,.5);
    margin-top: 6px;
}
.gd-shift-divider {
    width: 1px;
    height: 60px;
    background: rgba(255,255,255,.12);
    flex-shrink: 0;
}

/* ── STAT CARDS ── */
.gd-stat {
    background: #fff;
    border-radius: 16px;
    padding: 20px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    border: 1px solid #e8ecf1;
    position: relative;
    overflow: hidden;
    transition: transform .2s, box-shadow .2s, border-color .2s;
}
.gd-stat:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.12); border-color: #dbeafe; }
.gd-stat-stripe {
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 4px;
    border-radius: 14px 0 0 14px;
}
.gd-stat-icon {
    width: 50px; height: 50px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.gd-stat-num {
    font-size: 32px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
    font-variant-numeric: tabular-nums;
}
.gd-stat-lbl {
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
    margin-top: 3px;
}
.gd-live-ring {
    position: absolute;
    top: 14px; right: 14px;
    width: 10px; height: 10px;
    border-radius: 50%;
    background: #3b82f6;
    animation: gdRing 1.8s ease-in-out infinite;
}
@keyframes gdRing {
    0%,100% { box-shadow: 0 0 0 0 rgba(59,130,246,.5); }
    50%      { box-shadow: 0 0 0 8px rgba(59,130,246,0); }
}

/* ── ACTION STRIP ── */
.gd-action-strip {
    background: #fff;
    border-radius: 14px;
    padding: 14px 18px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    border: 1px solid rgba(0,0,0,.05);
    margin-bottom: 24px;
}
.gd-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    border: none;
    cursor: pointer;
    white-space: nowrap;
}
.gd-action-btn.primary {
    background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
    color: #fff;
    box-shadow: 0 6px 16px rgba(30,58,138,.35);
}
.gd-action-btn.primary:hover { background: linear-gradient(135deg, #1d4ed8, #2563eb); box-shadow: 0 8px 20px rgba(30,58,138,.45); color:#fff; transform: translateY(-1px); }
.gd-action-btn.danger {
    background: #f1f5f9;
    color: #1e3a8a;
    border: 1.5px solid #dbeafe;
}
.gd-action-btn.danger:hover { background: #dbeafe; color: #1e3a8a; }
.gd-action-btn.ghost {
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
}
.gd-action-btn.ghost:hover { background: #e2e8f0; color: #0f172a; }
.gd-action-sep {
    width: 1px;
    background: #e2e8f0;
    margin: 4px 0;
    align-self: stretch;
}

/* ── PANELS ── */
.gd-panel {
    background: #fff;
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,.05);
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    overflow: hidden;
}
.gd-panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
}
.gd-panel-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}
.gd-panel-badge {
    background: #dbeafe;
    color: #1e40af;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
    letter-spacing: .4px;
}
.gd-panel-link {
    font-size: 12px;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 8px;
    background: #eff6ff;
    transition: background .2s;
}
.gd-panel-link:hover { background: #dbeafe; color: #1d4ed8; }

/* ── VISITOR CARDS ── */
.gd-visitor-list {
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 420px;
    overflow-y: auto;
}
.gd-visitor-list::-webkit-scrollbar { width: 4px; }
.gd-visitor-list::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 2px; }
.gd-vcard {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: border-color .2s, box-shadow .2s;
}
.gd-vcard:hover { border-color: #bfdbfe; box-shadow: 0 2px 8px rgba(59,130,246,.1); }
.gd-vcard-avatar {
    width: 42px; height: 42px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 800;
    color: #fff;
    flex-shrink: 0;
}
.gd-vcard-name { font-size: 13.5px; font-weight: 700; color: #0f172a; }
.gd-vcard-meta { font-size: 11.5px; color: #94a3b8; margin-top: 1px; }
.gd-vcard-apt {
    margin-left: auto;
    text-align: right;
    flex-shrink: 0;
}
.gd-apt-pill {
    background: #eff6ff;
    color: #1e3a8a;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 6px;
    display: inline-block;
    margin-bottom: 4px;
}
.gd-time-in {
    font-size: 11px;
    color: #94a3b8;
    white-space: nowrap;
}
.gd-checkout-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 13px;
    background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(30,58,138,.25);
}
.gd-checkout-btn:hover { background: linear-gradient(135deg, #1d4ed8, #2563eb); transform: translateY(-1px); }
.gd-empty {
    text-align: center;
    padding: 40px 20px;
    color: #94a3b8;
}
.gd-empty i { font-size: 36px; margin-bottom: 10px; display: block; opacity: .4; }
.gd-empty span { font-size: 13px; font-weight: 500; display: block; }

/* ── ACTIVITY FEED ── */
.gd-feed {
    padding: 16px 20px;
    max-height: 420px;
    overflow-y: auto;
}
.gd-feed::-webkit-scrollbar { width: 4px; }
.gd-feed::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 2px; }
.gd-feed-item {
    display: flex;
    gap: 12px;
    padding-bottom: 14px;
    position: relative;
}
.gd-feed-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 15px; top: 32px; bottom: 0;
    width: 1px;
    background: #e2e8f0;
}
.gd-feed-dot {
    width: 30px; height: 30px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
    flex-shrink: 0;
    margin-top: 1px;
    position: relative;
    z-index: 1;
}
.fd-active    { background: #dbeafe; color: #1e40af; }
.fd-completed { background: #f1f5f9; color: #64748b; }
.fd-pending   { background: #e0e7ff; color: #4338ca; }
.gd-feed-body { flex: 1; min-width: 0; }
.gd-feed-name { font-size: 13px; font-weight: 700; color: #0f172a; }
.gd-feed-sub  { font-size: 11.5px; color: #94a3b8; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.gd-feed-time { font-size: 11px; color: #94a3b8; white-space: nowrap; margin-top: 2px; }
.gd-status-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 10.5px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
}
.gd-status-chip::before {
    content: '●';
    font-size: 7px;
}
.chip-active    { background: #dbeafe; color: #1e40af; }
.chip-completed { background: #f1f5f9; color: #64748b; }
.chip-pending   { background: #e0e7ff; color: #4338ca; }

/* avatar colours — navy/blue palette only */
.av-0 { background: linear-gradient(135deg,#0f172a,#1e3a8a); }
.av-1 { background: linear-gradient(135deg,#1e3a8a,#1d4ed8); }
.av-2 { background: linear-gradient(135deg,#1d4ed8,#2563eb); }
.av-3 { background: linear-gradient(135deg,#2563eb,#3b82f6); }
.av-4 { background: linear-gradient(135deg,#334155,#475569); }
.av-5 { background: linear-gradient(135deg,#1e3a8a,#3b82f6); }

/* Dark mode */
.dark-mode .gd-stat,
.dark-mode .gd-action-strip,
.dark-mode .gd-panel { background: #1e293b; border-color: rgba(255,255,255,.07); }
.dark-mode .gd-stat-num,
.dark-mode .gd-panel-title,
.dark-mode .gd-vcard-name,
.dark-mode .gd-feed-name { color: #f1f5f9; }
.dark-mode .gd-vcard { background: #0f172a; border-color: rgba(255,255,255,.08); }
.dark-mode .gd-apt-pill { background: #1e3a5f; color: #60a5fa; }
.dark-mode .gd-panel-head,
.dark-mode .gd-action-sep { border-color: rgba(255,255,255,.07); }
.dark-mode .gd-action-btn.ghost { background: #0f172a; border-color: rgba(255,255,255,.1); color: #cbd5e1; }
.dark-mode .gd-action-btn.ghost:hover { background: #1e3a5f; color: #f1f5f9; }
.dark-mode .gd-panel-link { background: #1e3a5f; color: #60a5fa; }
.dark-mode .gd-panel-link:hover { background: #1e40af; }
.dark-mode .gd-feed-item:not(:last-child)::before { background: rgba(255,255,255,.07); }
</style>
@endpush

@section('content')

{{-- SHIFT BANNER --}}
<div class="gd-shift-banner">
    <div>
        <div class="gd-duty-badge"><span class="gd-duty-dot"></span>On Duty</div>
        <p class="gd-shift-name">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</p>
        <p class="gd-shift-sub">Security Command Center &mdash; Gate Operations</p>
    </div>
    <div class="gd-shift-divider d-none d-md-block"></div>
    <div class="gd-clock-block">
        <div class="gd-clock" id="gdClock">--:--:--</div>
        <div class="gd-date" id="gdDate"></div>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="gd-stat">
            <div class="gd-live-ring"></div>
            <div class="gd-stat-stripe" style="background:#1e3a8a;"></div>
            <div class="gd-stat-icon" style="background:#dbeafe;">
                <i class="fas fa-person-walking-arrow-right" style="color:#1e3a8a;"></i>
            </div>
            <div>
                <div class="gd-stat-num">{{ $totalActive }}</div>
                <div class="gd-stat-lbl">Active Inside</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="gd-stat">
            <div class="gd-stat-stripe" style="background:#1d4ed8;"></div>
            <div class="gd-stat-icon" style="background:#dbeafe;">
                <i class="fas fa-calendar-day" style="color:#1d4ed8;"></i>
            </div>
            <div>
                <div class="gd-stat-num">{{ $totalToday }}</div>
                <div class="gd-stat-lbl">Today's Visits</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="gd-stat">
            <div class="gd-stat-stripe" style="background:#475569;"></div>
            <div class="gd-stat-icon" style="background:#f1f5f9;">
                <i class="fas fa-circle-check" style="color:#475569;"></i>
            </div>
            <div>
                <div class="gd-stat-num">{{ $completedToday }}</div>
                <div class="gd-stat-lbl">Checked Out</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="gd-stat">
            <div class="gd-stat-stripe" style="background:#3b82f6;"></div>
            <div class="gd-stat-icon" style="background:#eff6ff;">
                <i class="fas fa-users" style="color:#3b82f6;"></i>
            </div>
            <div>
                <div class="gd-stat-num">{{ $totalVisitors }}</div>
                <div class="gd-stat-lbl">Total in DB</div>
            </div>
        </div>
    </div>
</div>

{{-- QUICK ACTIONS STRIP --}}
<div class="gd-action-strip">
    <a href="{{ route('guard.visitors.create') }}" class="gd-action-btn primary">
        <i class="fas fa-user-plus"></i> Register Visitor
    </a>
    <a href="{{ route('guard.visitors.active') }}" class="gd-action-btn danger">
        <i class="fas fa-circle-dot"></i> Active Visitors
        @if($totalActive > 0)<span style="background:rgba(255,255,255,.25);border-radius:20px;padding:1px 8px;font-size:11px;margin-left:2px;">{{ $totalActive }}</span>@endif
    </a>
    <div class="gd-action-sep d-none d-sm-block"></div>
    <a href="{{ route('guard.visitors.logs') }}" class="gd-action-btn ghost">
        <i class="fas fa-clipboard-list"></i> Today's Logs
    </a>
    <a href="{{ route('guard.visitors.index') }}" class="gd-action-btn ghost">
        <i class="fas fa-magnifying-glass"></i> Search Visitors
    </a>
</div>

{{-- MAIN PANELS --}}
<div class="row g-3">

    {{-- Currently Inside --}}
    <div class="col-xl-5 col-lg-6">
        <div class="gd-panel h-100">
            <div class="gd-panel-head">
                <h6 class="gd-panel-title">
                    <span style="width:8px;height:8px;background:#3b82f6;border-radius:50%;animation:gdRing 1.8s ease-in-out infinite;display:inline-block;"></span>
                    Currently Inside
                    @if($totalActive > 0)
                    <span class="gd-panel-badge">{{ $totalActive }} Active</span>
                    @endif
                </h6>
                <a href="{{ route('guard.visitors.active') }}" class="gd-panel-link">View All</a>
            </div>
            <div class="gd-visitor-list">
                @forelse($activeVisits->take(6) as $i => $visit)
                <div class="gd-vcard">
                    <div class="gd-vcard-avatar av-{{ $i % 6 }}">
                        {{ strtoupper(substr($visit->visitor->full_name, 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="gd-vcard-name">{{ $visit->visitor->full_name }}</div>
                        <div class="gd-vcard-meta">{{ Str::limit($visit->purpose, 28) }}</div>
                    </div>
                        <div class="gd-vcard-apt">
                        <div class="gd-apt-pill">{{ $visit->tenant->apartment_display ?? 'N/A' }}</div>
                        <div class="gd-time-in"><i class="fas fa-clock" style="font-size:10px;"></i> {{ $visit->check_in_time?->format('H:i') }}</div>
                    </div>
                    <form method="POST" action="{{ route('guard.visits.checkout', $visit) }}" onsubmit="return confirm('Check out {{ $visit->visitor->full_name }}?')">
                        @csrf @method('PATCH')
                        <button class="gd-checkout-btn"><i class="fas fa-right-from-bracket"></i> Out</button>
                    </form>
                </div>
                @empty
                <div class="gd-empty">
                    <i class="fas fa-shield-check"></i>
                    <span>No visitors currently inside</span>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Today's Activity Feed --}}
    <div class="col-xl-7 col-lg-6">
        <div class="gd-panel h-100">
            <div class="gd-panel-head">
                <h6 class="gd-panel-title">
                    <i class="fas fa-wave-square" style="color:#3b82f6;font-size:13px;"></i>
                    Today's Activity
                </h6>
                <a href="{{ route('guard.visitors.logs') }}" class="gd-panel-link">Full Log</a>
            </div>
            <div class="gd-feed">
                @forelse($todayVisits->take(10) as $visit)
                @php $cls = $visit->status === 'active' ? 'fd-active' : ($visit->status === 'completed' ? 'fd-completed' : 'fd-pending'); @endphp
                <div class="gd-feed-item">
                    <div class="gd-feed-dot {{ $cls }}">
                        @if($visit->status === 'active')<i class="fas fa-circle-dot"></i>
                        @elseif($visit->status === 'completed')<i class="fas fa-check"></i>
                        @else<i class="fas fa-clock"></i>@endif
                    </div>
                    <div class="gd-feed-body">
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <span class="gd-feed-name">{{ $visit->visitor->full_name }}</span>
                            <span class="gd-status-chip chip-{{ $visit->status }}">{{ $visit->status === 'active' ? 'Inside' : ($visit->status === 'completed' ? 'Out' : ucfirst($visit->status)) }}</span>
                        </div>
                        <div class="gd-feed-sub">{{ Str::limit($visit->purpose, 40) }} &bull; Apartment {{ $visit->tenant->apartment_display ?? '—' }}</div>
                    </div>
                    <div class="gd-feed-time">
                        {{ $visit->check_in_time?->format('H:i') ?? '—' }}
                        @if($visit->check_out_time)<br><span style="color:#64748b;font-size:10px;">Out {{ $visit->check_out_time->format('H:i') }}</span>@endif
                    </div>
                </div>
                @empty
                <div class="gd-empty">
                    <i class="fas fa-calendar-xmark"></i>
                    <span>No visits recorded today</span>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    function tick() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2,'0');
        const m = String(now.getMinutes()).padStart(2,'0');
        const s = String(now.getSeconds()).padStart(2,'0');
        const el = document.getElementById('gdClock');
        const de = document.getElementById('gdDate');
        if (el) el.textContent = h + ':' + m + ':' + s;
        if (de) de.textContent = days[now.getDay()] + ', ' + months[now.getMonth()] + ' ' + now.getDate() + ' ' + now.getFullYear();
    }
    tick(); setInterval(tick, 1000);
})();
</script>
@endpush
