@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ── ADMIN DASHBOARD ── */
.adm-header {
    background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius:14px; padding:22px 28px;
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; flex-wrap:wrap; margin-bottom:22px;
    position:relative; overflow:hidden;
}
.adm-header::after {
    content:''; position:absolute; right:-30px; top:-30px;
    width:200px; height:200px;
    background:radial-gradient(circle,rgba(99,102,241,.18) 0%,transparent 70%);
    pointer-events:none;
}
.adm-header h2 { font-size:18px; font-weight:800; color:#fff; margin:0 0 4px; }
.adm-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.adm-head-chip {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    padding:6px 14px; border-radius:10px; color:#fff; font-size:12px; font-weight:600;
}
.adm-head-chip i { font-size:11px; color:rgba(255,255,255,.5); }
.adm-live-dot { width:7px; height:7px; border-radius:50%; background:#86efac; display:inline-block; animation:adm-pulse 1.4s ease infinite; }
@keyframes adm-pulse { 0%,100%{opacity:1;} 50%{opacity:.3;} }

/* Stats grid */
.adm-stats {
    display:grid; grid-template-columns:repeat(6,1fr); gap:14px; margin-bottom:22px;
}
.adm-stat {
    background:#fff; border-radius:14px;
    border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05);
    padding:18px 16px; position:relative; overflow:hidden;
    transition:box-shadow .2s,transform .2s; cursor:default;
}
.adm-stat:hover { box-shadow:0 6px 20px rgba(30,58,138,.1); transform:translateY(-3px); }
.adm-stat-icon {
    width:38px; height:38px; border-radius:10px; background:#eff6ff;
    display:flex; align-items:center; justify-content:center;
    font-size:15px; color:#1e3a8a; margin-bottom:12px;
}
.adm-stat-val { font-size:26px; font-weight:800; color:#0f172a; line-height:1; margin-bottom:4px; }
.adm-stat-lbl { font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:.4px; }
.adm-stat-bar { position:absolute; bottom:0; left:0; right:0; height:3px; background:#1e3a8a; border-radius:0 0 14px 14px; }

/* Action-required panel */
.adm-action-panel {
    border-radius:14px; margin-bottom:20px; overflow:hidden;
    border:1.5px solid #fde68a; box-shadow:0 2px 12px rgba(245,158,11,.12);
}
.adm-action-header {
    background:linear-gradient(135deg,#fffbeb,#fef3c7);
    padding:13px 20px; display:flex; align-items:center; justify-content:space-between; gap:12px;
    border-bottom:1px solid #fde68a;
}
.adm-action-title {
    display:flex; align-items:center; gap:9px;
    font-size:13.5px; font-weight:800; color:#92400e;
}
.adm-action-title .pulse-dot {
    width:9px; height:9px; border-radius:50%; background:#f59e0b;
    animation:adm-pulse 1.4s ease infinite; flex-shrink:0;
}
.adm-action-badge {
    background:#f59e0b; color:#fff; font-size:11px; font-weight:800;
    padding:2px 9px; border-radius:20px;
}
.adm-action-body { background:#fffdf5; }
.adm-action-section-title {
    font-size:10px; font-weight:800; color:#b45309; text-transform:uppercase;
    letter-spacing:.7px; padding:10px 20px 6px; display:flex; align-items:center; gap:6px;
}
.adm-action-section-title i { font-size:10px; }
.adm-action-row {
    display:flex; align-items:center; justify-content:space-between; gap:12px;
    padding:9px 20px; border-top:1px solid #fef3c7; transition:background .15s;
}
.adm-action-row:hover { background:#fef9c3; }
.adm-action-row:first-child { border-top:none; }
.adm-action-info { display:flex; align-items:center; gap:10px; }
.adm-action-avatar {
    width:32px; height:32px; border-radius:50%; background:#fde68a; color:#92400e;
    display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; flex-shrink:0;
}
.adm-guard-avatar { background:#dbeafe; color:#1e40af; }
.adm-action-name { font-size:13px; font-weight:700; color:#0f172a; display:block; }
.adm-action-meta { font-size:11.5px; color:#92400e; }
.adm-action-btn {
    display:inline-flex; align-items:center; gap:6px;
    padding:6px 14px; border-radius:8px; font-size:12px; font-weight:700;
    text-decoration:none; transition:all .18s; white-space:nowrap; border:none; cursor:pointer; font-family:inherit;
}
.adm-action-btn-assign { background:#1e3a8a; color:#fff; }
.adm-action-btn-assign:hover { background:#1e40af; color:#fff; transform:translateY(-1px); }
.adm-action-btn-approve { background:#16a34a; color:#fff; }
.adm-action-btn-approve:hover { background:#15803d; color:#fff; transform:translateY(-1px); }
.adm-action-section-sep { border-top:1.5px solid #fde68a; margin:0; }
.adm-action-footer {
    padding:10px 20px; background:#fffbeb; border-top:1px solid #fde68a;
    display:flex; justify-content:flex-end; gap:8px;
}
.adm-action-footer a { font-size:12px; font-weight:600; color:#92400e; text-decoration:none; }
.adm-action-footer a:hover { text-decoration:underline; }

/* Chart cards */
.adm-chart-card {
    background:#fff; border-radius:16px;
    border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden; height:100%;
}
.adm-chart-head {
    display:flex; align-items:center; gap:8px;
    padding:15px 22px; border-bottom:1px solid #f1f5f9;
    font-size:14px; font-weight:700; color:#0f172a;
}
.adm-chart-body { padding:20px 22px; }
.adm-legend { display:flex; gap:14px; flex-wrap:wrap; justify-content:center; margin-top:14px; }
.adm-legend-item { display:flex; align-items:center; gap:5px; font-size:12px; color:#64748b; font-weight:600; }
.adm-legend-dot { width:10px; height:10px; border-radius:3px; }

/* Recent visits panel */
.adm-panel {
    background:#fff; border-radius:16px;
    border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden;
}
.adm-panel-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:15px 22px; border-bottom:1px solid #f1f5f9;
    font-size:14px; font-weight:700; color:#0f172a;
}
.adm-panel-title { display:flex; align-items:center; gap:8px; }
.adm-view-all {
    font-size:12px; font-weight:600; color:#1e3a8a; text-decoration:none;
    padding:5px 12px; border:1.5px solid #bfdbfe; border-radius:8px; background:#eff6ff; transition:all .18s;
}
.adm-view-all:hover { background:#dbeafe; color:#1d4ed8; }
.adm-col-hdr {
    display:grid; grid-template-columns:1fr 140px 120px 160px 150px 110px;
    padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9;
}
.adm-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.adm-row {
    display:grid; grid-template-columns:1fr 140px 120px 160px 150px 110px;
    align-items:center; padding:12px 22px;
    border-bottom:1px solid #f3f4f6; transition:background .15s;
}
.adm-row:last-child { border-bottom:none; }
.adm-row:hover { background:#f8faff; }
.adm-visitor-cell { display:flex; align-items:center; gap:10px; }
.adm-avatar {
    width:34px; height:34px; border-radius:50%;
    background:#dbeafe; color:#1e3a8a;
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:700; flex-shrink:0; overflow:hidden;
}
.adm-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.adm-vname { font-size:13px; font-weight:700; color:#0f172a; display:block; }
.adm-vsub  { font-size:11px; color:#94a3b8; }
.adm-purpose {
    display:inline-flex; align-items:center; gap:4px;
    padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600;
    background:#f1f5f9; color:#475569;
}
.adm-time      { font-size:12px; color:#475569; display:block; }
.adm-time-date { font-size:11px; color:#94a3b8; display:block; }
.adm-status {
    display:inline-flex; align-items:center; gap:4px;
    padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;
}
.adm-status-active    { background:#dcfce7; color:#16a34a; }
.adm-status-completed { background:#f1f5f9; color:#64748b; }
.adm-status-pending   { background:#fef9c3; color:#92400e; }
.adm-status-rejected  { background:#fee2e2; color:#dc2626; }

/* Dark mode */
.dark-mode .adm-stat,.dark-mode .adm-chart-card,.dark-mode .adm-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .adm-stat-val,.dark-mode .adm-vname { color:#f1f5f9; }
.dark-mode .adm-chart-head,.dark-mode .adm-panel-head { color:#f1f5f9; border-color:rgba(255,255,255,.07); }
.dark-mode .adm-col-hdr { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .adm-row { border-color:rgba(255,255,255,.04); }
.dark-mode .adm-row:hover { background:#243044; }

@media(max-width:1200px){ .adm-stats { grid-template-columns:repeat(3,1fr); } }
@media(max-width:680px){
    .adm-stats { grid-template-columns:repeat(2,1fr); }
    .adm-col-hdr,.adm-row { grid-template-columns:1fr 120px 110px; }
    .adm-col-hdr span:nth-child(n+4),.adm-row>div:nth-child(n+4) { display:none; }
}
</style>
@endpush

@section('content')

@php
    $purposeIcons = ['Family visit'=>'fa-house-user','Delivery'=>'fa-box','Business meeting'=>'fa-briefcase','Maintenance'=>'fa-screwdriver-wrench','Social visit'=>'fa-people-group'];
    $statusLabels = ['active'=>'Inside','completed'=>'Checked Out','pending'=>'Pending','rejected'=>'Rejected'];
@endphp

{{-- HEADER --}}
<div class="adm-header">
    <div>
        <h2><i class="fas fa-gauge-high me-2" style="color:#93c5fd;font-size:15px;"></i>Admin Dashboard</h2>
        <p>{{ now()->format('l, F d, Y') }} &mdash; System overview &amp; activity</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <span class="adm-head-chip"><span class="adm-live-dot" style="margin-right:2px;"></span> System Online</span>
        <span class="adm-head-chip"><i class="fas fa-clock"></i> {{ now()->format('H:i') }}</span>
    </div>
</div>

{{-- ACTION-REQUIRED PANEL (compact notifications only) --}}
@php $totalActions = $unassignedTenants->count() + $pendingGuards->count(); @endphp
@if($totalActions > 0)
<div class="adm-action-panel">
    <div class="adm-action-header">
        <div class="adm-action-title">
            <span class="pulse-dot"></span>
            <i class="fas fa-bell" style="font-size:14px;"></i>
            Notifications
        </div>
        <span class="adm-action-badge">{{ $totalActions }}</span>
    </div>
    <div class="adm-action-body" style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;">
        <div style="color:#92400e;font-weight:700;">You have {{ $totalActions }} pending {{ Str::plural('action', $totalActions) }}.</div>
        <div style="display:flex;gap:8px;">
            @if($unassignedTenants->count() > 0)
                <a href="{{ route('admin.tenants.index') }}" class="adm-action-btn adm-action-btn-assign">Assign Residents ({{ $unassignedTenants->count() }})</a>
            @endif
            @if($pendingGuards->count() > 0)
                <a href="{{ route('admin.guards.index') }}" class="adm-action-btn adm-action-btn-approve">Review Guards ({{ $pendingGuards->count() }})</a>
            @endif
        </div>
    </div>
</div>
@endif

{{-- STATS --}}
<div class="adm-stats">
    <div class="adm-stat">
        <div class="adm-stat-icon"><i class="fas fa-building"></i></div>
        <div class="adm-stat-val">{{ $totalApartments }}</div>
        <div class="adm-stat-lbl">Apartments</div>
        <div class="adm-stat-bar"></div>
    </div>
    <div class="adm-stat">
        <div class="adm-stat-icon"><i class="fas fa-users"></i></div>
        <div class="adm-stat-val">{{ $totalTenants }}</div>
        <div class="adm-stat-lbl">Residents</div>
        <div class="adm-stat-bar"></div>
    </div>
    <div class="adm-stat">
        <div class="adm-stat-icon"><i class="fas fa-person-walking-arrow-right"></i></div>
        <div class="adm-stat-val">{{ $totalVisitors }}</div>
        <div class="adm-stat-lbl">Total Visitors</div>
        <div class="adm-stat-bar"></div>
    </div>
    <div class="adm-stat">
        <div class="adm-stat-icon"><i class="fas fa-circle-dot"></i></div>
        <div class="adm-stat-val">{{ $activeVisits }}</div>
        <div class="adm-stat-lbl">Active Inside</div>
        <div class="adm-stat-bar"></div>
    </div>
    <div class="adm-stat">
        <div class="adm-stat-icon"><i class="fas fa-calendar-day"></i></div>
        <div class="adm-stat-val">{{ $todayVisits }}</div>
        <div class="adm-stat-lbl">Today's Visits</div>
        <div class="adm-stat-bar"></div>
    </div>
    <div class="adm-stat">
        <div class="adm-stat-icon"><i class="fas fa-shield-halved"></i></div>
        <div class="adm-stat-val">{{ $totalGuards }}</div>
        <div class="adm-stat-lbl">Security Guards</div>
        <div class="adm-stat-bar"></div>
    </div>
</div>

{{-- CHARTS --}}
<div class="row g-3" style="margin-bottom:22px;">
    <div class="col-lg-8">
        <div class="adm-chart-card">
            <div class="adm-chart-head">
                <i class="fas fa-chart-column" style="color:#1e3a8a;font-size:13px;"></i>
                Visitor Activity — Last 7 Days
            </div>
            <div class="adm-chart-body"><canvas id="visitorChart" height="110"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="adm-chart-card">
            <div class="adm-chart-head">
                <i class="fas fa-chart-pie" style="color:#1e3a8a;font-size:13px;"></i>
                Visit Status Breakdown
            </div>
            <div class="adm-chart-body" style="display:flex;flex-direction:column;align-items:center;">
                <canvas id="statusChart" height="180" style="max-width:200px;"></canvas>
                <div class="adm-legend">
                    <span class="adm-legend-item"><span class="adm-legend-dot" style="background:#3b82f6;"></span>Inside</span>
                    <span class="adm-legend-item"><span class="adm-legend-dot" style="background:#64748b;"></span>Checked Out</span>
                    <span class="adm-legend-item"><span class="adm-legend-dot" style="background:#f59e0b;"></span>Pending</span>
                    <span class="adm-legend-item"><span class="adm-legend-dot" style="background:#ef4444;"></span>Rejected</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RECENT VISITS --}}
<div class="adm-panel">
    <div class="adm-panel-head">
        <span class="adm-panel-title">
            <i class="fas fa-clock-rotate-left" style="color:#1e3a8a;font-size:13px;"></i>
            Recent Visit Activity
        </span>
        <a href="{{ route('admin.visits.index') }}" class="adm-view-all">View All →</a>
    </div>
    <div class="adm-col-hdr">
        <span class="adm-col-h">Visitor</span>
        <span class="adm-col-h">Resident</span>
        <span class="adm-col-h">Room</span>
        <span class="adm-col-h">Purpose</span>
        <span class="adm-col-h">Check In</span>
        <span class="adm-col-h">Status</span>
    </div>
    @forelse($recentVisits as $visit)
    @php
        $parts=$visit->visitor->full_name ? explode(' ',trim($visit->visitor->full_name)) : ['?'];
        $initials=strtoupper(substr($parts[0],0,1)).(isset($parts[1])?strtoupper(substr($parts[1],0,1)):'');
        $purIcon=$purposeIcons[$visit->purpose]??'fa-tag';
        $sLabel=$statusLabels[$visit->status]??ucfirst($visit->status);
        $sCls='adm-status-'.$visit->status;
    @endphp
    <div class="adm-row">
        <div class="adm-visitor-cell">
            <div class="adm-avatar">
                @if($visit->visitor->photo)<img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">@else{{ $initials }}@endif
            </div>
            <div>
                <span class="adm-vname">{{ $visit->visitor->full_name }}</span>
                <span class="adm-vsub">{{ $visit->visitor->phone_number ?? '' }}</span>
            </div>
        </div>
        <div style="font-size:13px;color:#475569;">{{ $visit->tenant->user->name ?? '—' }}</div>
        <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ $visit->tenant->apartment_display ?? '—' }}</div>
        <div><span class="adm-purpose"><i class="fas {{ $purIcon }}" style="font-size:9px;"></i> {{ Str::limit($visit->purpose,16) }}</span></div>
        <div>
            @if($visit->check_in_time)
                <span class="adm-time">{{ $visit->check_in_time->format('H:i') }}</span>
                <span class="adm-time-date">{{ $visit->check_in_time->format('M d, Y') }}</span>
            @else <span style="color:#94a3b8;">—</span>@endif
        </div>
        <div><span class="adm-status {{ $sCls }}">{{ $sLabel }}</span></div>
    </div>
    @empty
    <div style="text-align:center;padding:48px 20px;color:#94a3b8;font-size:13px;">No visit records yet.</div>
    @endforelse
</div>

@endsection

@push('scripts')
<script type="text/javascript">
const chartLabels = JSON.parse('{!! json_encode($chartLabels) !!}');
const chartData   = JSON.parse('{!! json_encode($chartData) !!}');
const statusData  = JSON.parse('{!! json_encode($statusData) !!}');

new Chart(document.getElementById('visitorChart'), {
    type: 'bar',
    data: {
        labels: chartLabels,
        datasets: [{ label:'Visits', data:chartData,
            backgroundColor:'rgba(30,58,138,.12)', borderColor:'#1e3a8a',
            borderWidth:2, borderRadius:8, hoverBackgroundColor:'rgba(30,58,138,.25)' }]
    },
    options: {
        responsive:true,
        plugins:{ legend:{ display:false } },
        scales:{
            x:{ grid:{ display:false }, ticks:{ font:{ size:12 }, color:'#94a3b8' } },
            y:{ beginAtZero:true, grid:{ color:'rgba(0,0,0,.04)' }, ticks:{ font:{ size:12 }, color:'#94a3b8', stepSize:1 } }
        }
    }
});

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Inside','Checked Out','Pending','Rejected'],
        datasets: [{ data:statusData, backgroundColor:['#3b82f6','#64748b','#f59e0b','#ef4444'], borderWidth:0, hoverOffset:6 }]
    },
    options: { cutout:'72%', plugins:{ legend:{ display:false } } }
});
</script>
@endpush
