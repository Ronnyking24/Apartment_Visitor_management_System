@extends('layouts.dashboard')
@section('title','All Visits')
@section('page-title','All Visits')

@push('styles')
<style>
.avsi-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.avsi-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.avsi-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.avsi-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.avsi-count-chip { display:inline-flex; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); padding:7px 16px; border-radius:10px; color:#fff; white-space:nowrap; }
.avsi-count-chip .cn { font-size:20px; font-weight:800; line-height:1; }
.avsi-count-chip .cl { font-size:10px; color:rgba(255,255,255,.5); display:block; margin-top:1px; }
.avsi-toolbar { background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,.06); box-shadow:0 1px 4px rgba(0,0,0,.05); padding:16px 20px; display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; margin-bottom:18px; }
.avsi-fg { display:flex; flex-direction:column; gap:5px; }
.avsi-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; }
.avsi-inp,.avsi-sel { padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; outline:none; font-family:inherit; transition:border-color .2s,box-shadow .2s; background:#fff; }
.avsi-inp:focus,.avsi-sel:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.avsi-sw { position:relative; }
.avsi-sw i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.avsi-sw .avsi-inp { padding-left:34px; min-width:200px; }
.avsi-fbtn { padding:9px 20px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; font-size:13px; font-weight:700; border:none; border-radius:10px; cursor:pointer; font-family:inherit; display:inline-flex; align-items:center; gap:6px; }
.avsi-rbtn { padding:9px 16px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .2s; }
.avsi-rbtn:hover { background:#e2e8f0; color:#0f172a; }
.avsi-panel { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden; }
.avsi-panel-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.avsi-panel-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.avsi-col-hdr { display:grid; grid-template-columns:44px 1fr 130px 110px 140px 130px 130px 80px 110px; padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9; }
.avsi-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.avsi-row { display:grid; grid-template-columns:44px 1fr 130px 110px 140px 130px 130px 80px 110px; align-items:center; padding:12px 22px; border-bottom:1px solid #f3f4f6; transition:background .15s; }
.avsi-row:last-child { border-bottom:none; }
.avsi-row:hover { background:#f8faff; }
.avsi-num { font-size:12.5px; font-weight:700; color:#94a3b8; }
.avsi-vc { display:flex; align-items:center; gap:9px; }
.avsi-avatar { width:32px; height:32px; border-radius:50%; background:#dbeafe; color:#1e3a8a; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0; overflow:hidden; }
.avsi-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.avsi-vname { font-size:12.5px; font-weight:700; color:#0f172a; display:block; }
.avsi-vsub  { font-size:11px; color:#94a3b8; }
.avsi-cell-sm { font-size:12.5px; color:#475569; }
.avsi-purpose { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; background:#f1f5f9; color:#475569; }
.avsi-time { font-size:12px; color:#475569; display:block; }
.avsi-time-s { font-size:11px; color:#94a3b8; display:block; }
.avsi-appr-yes { color:#16a34a; font-size:14px; }
.avsi-appr-no  { color:#94a3b8; font-size:13px; }
.avsi-status { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.avsi-status-active    { background:#dcfce7; color:#16a34a; }
.avsi-status-completed { background:#f1f5f9; color:#64748b; }
.avsi-status-pending   { background:#fef9c3; color:#92400e; }
.avsi-status-rejected  { background:#fee2e2; color:#dc2626; }
.avsi-empty { text-align:center; padding:64px 20px; }
.avsi-empty-icon { width:72px; height:72px; background:#eff6ff; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:28px; color:#93c5fd; margin:0 auto 16px; border:2px solid #bfdbfe; }
.avsi-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.avsi-empty p  { font-size:13px; color:#94a3b8; margin:0; }
.avsi-pag { padding:14px 22px; border-top:1px solid #f1f5f9; }
.dark-mode .avsi-toolbar,.dark-mode .avsi-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .avsi-inp,.dark-mode .avsi-sel { background:#0f172a; border-color:rgba(255,255,255,.1); color:#e2e8f0; }
.dark-mode .avsi-col-hdr { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .avsi-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .avsi-panel-title,.dark-mode .avsi-vname { color:#f1f5f9; }
.dark-mode .avsi-row { border-color:rgba(255,255,255,.04); }
.dark-mode .avsi-row:hover { background:#243044; }
.dark-mode .avsi-empty h5 { color:#f1f5f9; }
@media(max-width:1100px){ .avsi-col-hdr,.avsi-row { grid-template-columns:36px 1fr 120px 130px 120px 100px; } .avsi-col-hdr span:nth-child(n+7),.avsi-row>div:nth-child(n+7) { display:none; } }
</style>
@endpush

@section('content')

@php
    $purposeIcons = ['Family visit'=>'fa-house-user','Delivery'=>'fa-box','Business meeting'=>'fa-briefcase','Maintenance'=>'fa-screwdriver-wrench','Social visit'=>'fa-people-group'];
    $statusLabels = ['active'=>'Inside','completed'=>'Checked Out','pending'=>'Pending','rejected'=>'Rejected'];
    $hasFilters   = array_filter(request()->only(['search','status','date_from','date_to']));
@endphp

{{-- HEADER --}}
<div class="avsi-header">
    <div>
        <h2><i class="fas fa-clipboard-list me-2" style="color:#93c5fd;font-size:15px;"></i>All Visits</h2>
        <p>Complete visit log for the entire complex</p>
    </div>
    <div class="avsi-count-chip"><div><span class="cn">{{ $visits->total() }}</span><span class="cl">Total Records</span></div></div>
</div>

{{-- FILTER --}}
<div class="avsi-toolbar">
    <form method="GET" style="display:contents;">
        <div class="avsi-fg">
            <span class="avsi-lbl">Search Visitor</span>
            <div class="avsi-sw">
                <i class="fas fa-magnifying-glass"></i>
                <input type="text" name="search" class="avsi-inp" placeholder="Name or national ID…" value="{{ request('search') }}">
            </div>
        </div>
        <div class="avsi-fg">
            <span class="avsi-lbl">Status</span>
            <select name="status" class="avsi-sel" style="min-width:140px;">
                <option value="">All Statuses</option>
                <option value="pending"   {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="active"    {{ request('status')=='active'?'selected':'' }}>Inside</option>
                <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Checked Out</option>
                <option value="rejected"  {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
            </select>
        </div>
        <div class="avsi-fg">
            <span class="avsi-lbl">From</span>
            <input type="date" name="date_from" class="avsi-inp" value="{{ request('date_from') }}">
        </div>
        <div class="avsi-fg">
            <span class="avsi-lbl">To</span>
            <input type="date" name="date_to" class="avsi-inp" value="{{ request('date_to') }}">
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;">
            <button type="submit" class="avsi-fbtn"><i class="fas fa-filter" style="font-size:11px;"></i> Filter</button>
            @if($hasFilters)
            <a href="{{ route('admin.visits.index') }}" class="avsi-rbtn"><i class="fas fa-xmark"></i> Clear</a>
            @endif
        </div>
    </form>
</div>

{{-- PANEL --}}
<div class="avsi-panel">
    <div class="avsi-panel-head">
        <span class="avsi-panel-title">
            <i class="fas fa-clipboard-list" style="color:#1e3a8a;font-size:13px;"></i>
            Visit Log
            <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $visits->total() }}</span>
        </span>
        <span style="font-size:12.5px;color:#94a3b8;">Showing {{ $visits->firstItem() ?? 0 }}–{{ $visits->lastItem() ?? 0 }} of {{ $visits->total() }}</span>
    </div>

    <div class="avsi-col-hdr">
        <span class="avsi-col-h">#</span>
        <span class="avsi-col-h">Visitor</span>
        <span class="avsi-col-h">Tenant</span>
        <span class="avsi-col-h">Apt.</span>
        <span class="avsi-col-h">Purpose</span>
        <span class="avsi-col-h">Check In</span>
        <span class="avsi-col-h">Check Out</span>
        <span class="avsi-col-h">Appr.</span>
        <span class="avsi-col-h">Status</span>
    </div>

    @forelse($visits as $visit)
    @php
        $parts    = explode(' ', trim($visit->visitor->full_name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
        $purIcon  = $purposeIcons[$visit->purpose] ?? 'fa-tag';
        $sLabel   = $statusLabels[$visit->status] ?? ucfirst($visit->status);
        $sCls     = 'avsi-status-'.$visit->status;
    @endphp
    <div class="avsi-row">
        <span class="avsi-num">{{ str_pad($visits->firstItem()+$loop->index,2,'0',STR_PAD_LEFT) }}</span>
        <div class="avsi-vc">
            <div class="avsi-avatar">
                @if($visit->visitor->photo)<img src="{{ asset('storage/'.$visit->visitor->photo) }}" alt="">@else{{ $initials }}@endif
            </div>
            <div>
                <span class="avsi-vname">{{ $visit->visitor->full_name }}</span>
                <span class="avsi-vsub">{{ $visit->visitor->national_id ?? '' }}</span>
            </div>
        </div>
        <div class="avsi-cell-sm">{{ $visit->tenant->user->name ?? '—' }}</div>
        <div style="font-size:13px;font-weight:700;color:#1e3a8a;">{{ $visit->tenant->apartment->apartment_number ?? '—' }}</div>
        <div><span class="avsi-purpose"><i class="fas {{ $purIcon }}" style="font-size:9px;"></i> {{ Str::limit($visit->purpose,14) }}</span></div>
        <div>
            @if($visit->check_in_time)
                <span class="avsi-time">{{ $visit->check_in_time->format('H:i') }}</span>
                <span class="avsi-time-s">{{ $visit->check_in_time->format('M d') }}</span>
            @else<span style="color:#94a3b8;">—</span>@endif
        </div>
        <div>
            @if($visit->check_out_time)
                <span class="avsi-time">{{ $visit->check_out_time->format('H:i') }}</span>
                <span class="avsi-time-s">{{ $visit->check_out_time->format('M d') }}</span>
            @else<span style="color:#94a3b8;">—</span>@endif
        </div>
        <div>
            @if($visit->approved_by_tenant)
                <i class="fas fa-check-circle avsi-appr-yes" title="Approved"></i>
            @else
                <i class="fas fa-clock avsi-appr-no" title="Pending"></i>
            @endif
        </div>
        <div><span class="avsi-status {{ $sCls }}">{{ $sLabel }}</span></div>
    </div>
    @empty
    <div class="avsi-empty">
        <div class="avsi-empty-icon"><i class="fas fa-clipboard-list"></i></div>
        <h5>No visits found</h5>
        <p>Try adjusting your filters.</p>
    </div>
    @endforelse

    @if($visits->hasPages())
    <div class="avsi-pag">{{ $visits->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
