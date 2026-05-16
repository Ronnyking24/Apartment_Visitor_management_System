@extends('layouts.dashboard')
@section('title','Visitor Profile')
@section('page-title','Visitor Profile')

@push('styles')
<style>
/* ── VISITOR PROFILE ── */
.vp-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:22px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.vp-header::after { content:''; position:absolute; right:-20px; top:-20px; width:180px; height:180px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.vp-header-left { display:flex; align-items:center; gap:16px; }
.vp-header-photo { width:52px; height:52px; border-radius:50%; object-fit:cover; border:2px solid rgba(255,255,255,.3); flex-shrink:0; }
.vp-header-avatar { width:52px; height:52px; border-radius:50%; background:rgba(255,255,255,.15); border:2px solid rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800; color:#fff; flex-shrink:0; }
.vp-header h2 { font-size:18px; font-weight:800; color:#fff; margin:0 0 4px; }
.vp-header p  { font-size:12px; color:rgba(255,255,255,.5); margin:0; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.vp-header-actions { display:flex; gap:8px; }
.vp-back-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); color:#fff; border-radius:10px; font-size:12.5px; font-weight:600; text-decoration:none; transition:all .2s; }
.vp-back-btn:hover { background:rgba(255,255,255,.2); color:#fff; }
.vp-del-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:rgba(239,68,68,.25); border:1px solid rgba(239,68,68,.4); color:#fca5a5; border-radius:10px; font-size:12.5px; font-weight:600; cursor:pointer; font-family:inherit; transition:all .2s; }
.vp-del-btn:hover { background:rgba(239,68,68,.4); color:#fff; }

/* Layout */
.vp-layout { display:grid; grid-template-columns:290px 1fr; gap:18px; }

/* Profile card */
.vp-profile-card { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 2px 10px rgba(0,0,0,.05); overflow:hidden; }
.vp-profile-hero { padding:28px 20px 20px; text-align:center; border-bottom:1px solid #f1f5f9; background:linear-gradient(180deg,#f8faff 0%,#fff 100%); }
.vp-profile-img { width:88px; height:88px; border-radius:50%; object-fit:cover; border:3px solid #dbeafe; box-shadow:0 4px 16px rgba(30,58,138,.15); margin-bottom:14px; }
.vp-profile-icon { width:88px; height:88px; border-radius:50%; background:linear-gradient(135deg,#eff6ff,#dbeafe); border:3px solid #dbeafe; display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:800; color:#1e3a8a; margin:0 auto 14px; box-shadow:0 4px 16px rgba(30,58,138,.1); }
.vp-profile-name { font-size:16px; font-weight:800; color:#0f172a; margin-bottom:5px; }
.vp-profile-phone { font-size:13px; color:#64748b; display:flex; align-items:center; justify-content:center; gap:6px; margin-bottom:12px; }
.vp-total-visits { display:inline-flex; align-items:center; gap:6px; padding:6px 16px; background:#eff6ff; color:#1e3a8a; border-radius:20px; font-size:13px; font-weight:700; }
.vp-stats-row { display:grid; grid-template-columns:1fr 1fr; border-bottom:1px solid #f1f5f9; }
.vp-stat-cell { padding:14px 16px; text-align:center; border-right:1px solid #f1f5f9; }
.vp-stat-cell:last-child { border-right:none; }
.vp-stat-n { font-size:20px; font-weight:800; color:#0f172a; line-height:1; }
.vp-stat-l { font-size:10px; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:.5px; margin-top:3px; }
.vp-info-body { padding:14px 20px; }
.vp-info-row { display:flex; align-items:flex-start; justify-content:space-between; gap:8px; padding:9px 0; border-bottom:1px solid #f8fafc; }
.vp-info-row:last-child { border-bottom:none; }
.vp-info-key { font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; flex-shrink:0; padding-top:1px; }
.vp-info-val { font-size:13px; color:#0f172a; font-weight:600; text-align:right; }

/* Visit history panel */
.vp-panel { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 2px 10px rgba(0,0,0,.05); overflow:hidden; }
.vp-panel-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.vp-panel-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.vp-col-hdr { display:grid; grid-template-columns:1fr 90px 1fr 120px 120px 100px; padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9; }
.vp-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.vp-row { display:grid; grid-template-columns:1fr 90px 1fr 120px 120px 100px; align-items:center; padding:12px 22px; border-bottom:1px solid #f3f4f6; transition:background .15s; }
.vp-row:last-child { border-bottom:none; }
.vp-row:hover { background:#f8faff; }
.vp-tenant-name { font-size:13px; font-weight:700; color:#0f172a; display:block; margin-bottom:1px; }
.vp-apt-badge { font-size:12.5px; font-weight:700; color:#1e3a8a; }
.vp-purpose { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:20px; background:#f1f5f9; color:#475569; font-size:12px; font-weight:600; }
.vp-time { font-size:12px; color:#64748b; display:block; }
.vp-status { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:11.5px; font-weight:700; white-space:nowrap; }
.vp-status-active    { background:#dbeafe; color:#1e40af; }
.vp-status-completed { background:#dcfce7; color:#15803d; }
.vp-status-pending   { background:#fef3c7; color:#b45309; }
.vp-status-rejected  { background:#fee2e2; color:#dc2626; }
.vp-empty { text-align:center; padding:52px 20px; }
.vp-empty i { font-size:30px; color:#e2e8f0; display:block; margin-bottom:12px; }
.vp-empty p { font-size:13px; color:#94a3b8; margin:0; }
.vp-pag { padding:14px 22px; border-top:1px solid #f1f5f9; }
@media(max-width:900px){ .vp-layout { grid-template-columns:1fr; } .vp-col-hdr,.vp-row { grid-template-columns:1fr 90px 1fr auto; } .vp-col-hdr span:nth-child(n+4),.vp-row>div:nth-child(n+4) { display:none; } }
</style>
@endpush

@section('content')

@php
    $vp = explode(' ', trim($visitor->full_name));
    $vi = strtoupper(substr($vp[0],0,1)).(isset($vp[1]) ? strtoupper(substr($vp[1],0,1)) : '');
    $completedCount = $visits->getCollection()->where('status','completed')->count();
    $activeCount    = $visits->getCollection()->where('status','active')->count();
@endphp

{{-- HEADER --}}
<div class="vp-header">
    <div class="vp-header-left">
        @if($visitor->photo)
            <img src="{{ asset('storage/'.$visitor->photo) }}" class="vp-header-photo" alt="">
        @else
            <div class="vp-header-avatar">{{ $vi }}</div>
        @endif
        <div>
            <h2>{{ $visitor->full_name }}</h2>
            <p>
                <i class="fas fa-phone" style="font-size:10px;color:rgba(255,255,255,.4);"></i>
                {{ $visitor->phone_number ?? 'No phone' }}
                @if($visitor->national_id)
                &nbsp;&middot;&nbsp;
                <i class="fas fa-id-card" style="font-size:10px;color:rgba(255,255,255,.4);"></i>
                {{ $visitor->national_id }}
                @endif
            </p>
        </div>
    </div>
    <div class="vp-header-actions">
        <a href="{{ route('admin.visitors.index') }}" class="vp-back-btn">
            <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back
        </a>
        <form method="POST" action="{{ route('admin.visitors.destroy', $visitor) }}" style="margin:0;" onsubmit="return confirm('Permanently delete this visitor and all their records?')">
            @csrf @method('DELETE')
            <button type="submit" class="vp-del-btn">
                <i class="fas fa-trash" style="font-size:11px;"></i> Delete
            </button>
        </form>
    </div>
</div>

<div class="vp-layout">

    {{-- LEFT: PROFILE CARD --}}
    <div>
        <div class="vp-profile-card">
            <div class="vp-profile-hero">
                @if($visitor->photo)
                    <img src="{{ asset('storage/'.$visitor->photo) }}" class="vp-profile-img" alt="">
                @else
                    <div class="vp-profile-icon">{{ $vi }}</div>
                @endif
                <div class="vp-profile-name">{{ $visitor->full_name }}</div>
                <div class="vp-profile-phone">
                    <i class="fas fa-phone" style="font-size:10px;"></i>
                    {{ $visitor->phone_number ?? 'No phone on file' }}
                </div>
                <span class="vp-total-visits">
                    <i class="fas fa-door-open" style="font-size:11px;"></i>
                    {{ $visits->total() }} {{ Str::plural('visit', $visits->total()) }}
                </span>
            </div>

            <div class="vp-stats-row">
                <div class="vp-stat-cell">
                    <div class="vp-stat-n" style="color:#15803d;">{{ $completedCount }}</div>
                    <div class="vp-stat-l">Completed</div>
                </div>
                <div class="vp-stat-cell">
                    <div class="vp-stat-n" style="color:#1d4ed8;">{{ $activeCount }}</div>
                    <div class="vp-stat-l">Active</div>
                </div>
            </div>

            <div class="vp-info-body">
                <div class="vp-info-row">
                    <span class="vp-info-key">National ID</span>
                    <span class="vp-info-val" style="font-family:monospace;font-size:12.5px;">{{ $visitor->national_id ?? '—' }}</span>
                </div>
                <div class="vp-info-row">
                    <span class="vp-info-key">Total Visits</span>
                    <span class="vp-info-val">{{ $visits->total() }}</span>
                </div>
                <div class="vp-info-row">
                    <span class="vp-info-key">First Seen</span>
                    <span class="vp-info-val" style="font-size:12px;">{{ $visitor->created_at->format('M d, Y') }}</span>
                </div>
                <div class="vp-info-row">
                    <span class="vp-info-key">Last Visit</span>
                    <span class="vp-info-val" style="font-size:12px;">
                        @php $last = $visits->first(); @endphp
                        {{ $last?->check_in_time?->format('M d, Y') ?? '—' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: VISIT HISTORY --}}
    <div>
        <div class="vp-panel">
            <div class="vp-panel-head">
                <span class="vp-panel-title">
                    <i class="fas fa-clock-rotate-left" style="color:#1e3a8a;font-size:13px;"></i>
                    Visit History
                    <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $visits->total() }}</span>
                </span>
                <span style="font-size:12.5px;color:#94a3b8;">Showing {{ $visits->firstItem() ?? 0 }}–{{ $visits->lastItem() ?? 0 }}</span>
            </div>

            @if($visits->total())
            <div class="vp-col-hdr">
                <span class="vp-col-h">Resident</span>
                <span class="vp-col-h">Apartment</span>
                <span class="vp-col-h">Purpose</span>
                <span class="vp-col-h">Check In</span>
                <span class="vp-col-h">Check Out</span>
                <span class="vp-col-h">Status</span>
            </div>
            @foreach($visits as $visit)
            <div class="vp-row">
                <div>
                    <span class="vp-tenant-name">{{ $visit->tenant->user->name ?? '—' }}</span>
                </div>
                <div class="vp-apt-badge">{{ $visit->tenant->apartment_display ?? '—' }}</div>
                <div><span class="vp-purpose">{{ Str::limit($visit->purpose, 22) }}</span></div>
                <div>
                    <span class="vp-time">{{ $visit->check_in_time?->format('M d') ?? '—' }}</span>
                    <span class="vp-time" style="font-size:11px;">{{ $visit->check_in_time?->format('H:i') ?? '' }}</span>
                </div>
                <div>
                    <span class="vp-time">{{ $visit->check_out_time?->format('M d') ?? '—' }}</span>
                    <span class="vp-time" style="font-size:11px;">{{ $visit->check_out_time?->format('H:i') ?? '' }}</span>
                </div>
                <div><span class="vp-status vp-status-{{ $visit->status }}">{{ ucfirst($visit->status) }}</span></div>
            </div>
            @endforeach
            @else
            <div class="vp-empty">
                <i class="fas fa-clipboard-list"></i>
                <p>No visit history recorded for this visitor.</p>
            </div>
            @endif

            @if($visits->hasPages())
            <div class="vp-pag">{{ $visits->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>

</div>
@endsection
