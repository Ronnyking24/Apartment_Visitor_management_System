@extends('layouts.dashboard')
@section('title','Apartment Details')
@section('page-title','Apartment Details')

@push('styles')
<style>
/* ── APARTMENT SHOW ── */
.ap-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:22px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.ap-header::after { content:''; position:absolute; right:-20px; top:-20px; width:180px; height:180px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.ap-header-left { display:flex; align-items:center; gap:16px; }
.ap-apt-icon { width:52px; height:52px; border-radius:14px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; font-size:22px; color:#93c5fd; flex-shrink:0; }
.ap-header h2 { font-size:18px; font-weight:800; color:#fff; margin:0 0 4px; }
.ap-header p  { font-size:12px; color:rgba(255,255,255,.5); margin:0; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.ap-status-chip { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:700; }
.ap-status-vacant   { background:rgba(134,239,172,.2); color:#86efac; }
.ap-status-occupied { background:rgba(252,165,165,.2); color:#fca5a5; }
.ap-header-actions { display:flex; gap:8px; }
.ap-edit-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); color:#fff; border-radius:10px; font-size:12.5px; font-weight:600; text-decoration:none; transition:all .2s; }
.ap-edit-btn:hover { background:rgba(255,255,255,.2); color:#fff; }
.ap-back-btn { display:inline-flex; align-items:center; gap:7px; padding:9px 16px; background:transparent; border:1px solid rgba(255,255,255,.15); color:rgba(255,255,255,.7); border-radius:10px; font-size:12.5px; font-weight:600; text-decoration:none; transition:all .2s; }
.ap-back-btn:hover { background:rgba(255,255,255,.08); color:#fff; }

/* Layout */
.ap-layout { display:grid; grid-template-columns:300px 1fr; gap:18px; }

/* Info card */
.ap-info-card { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 2px 10px rgba(0,0,0,.05); overflow:hidden; }
.ap-info-hero { background:linear-gradient(135deg,#eff6ff,#dbeafe); padding:24px 20px; text-align:center; border-bottom:1px solid #e0eaff; }
.ap-info-apt-badge { font-size:28px; font-weight:900; color:#1e3a8a; line-height:1; margin-bottom:6px; }
.ap-info-block { font-size:13px; color:#64748b; font-weight:600; margin-bottom:10px; }
.ap-info-status { display:inline-flex; align-items:center; gap:6px; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:700; }
.ap-info-status-vacant   { background:#dcfce7; color:#15803d; }
.ap-info-status-occupied { background:#fee2e2; color:#dc2626; }
.ap-stats-row { display:grid; grid-template-columns:1fr 1fr; border-bottom:1px solid #f1f5f9; }
.ap-stat-cell { padding:14px 16px; text-align:center; border-right:1px solid #f1f5f9; }
.ap-stat-cell:last-child { border-right:none; }
.ap-stat-n { font-size:22px; font-weight:800; color:#0f172a; line-height:1; }
.ap-stat-l { font-size:10px; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:.5px; margin-top:3px; }
.ap-info-body { padding:16px 20px; }
.ap-info-row { display:flex; align-items:flex-start; justify-content:space-between; gap:8px; padding:9px 0; border-bottom:1px solid #f8fafc; }
.ap-info-row:last-child { border-bottom:none; }
.ap-info-key { font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; flex-shrink:0; padding-top:1px; }
.ap-info-val { font-size:13px; color:#0f172a; font-weight:600; text-align:right; }

/* Tenants panel */
.ap-panel { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 2px 10px rgba(0,0,0,.05); overflow:hidden; }
.ap-panel-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.ap-panel-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.ap-col-hdr { display:grid; grid-template-columns:1fr 1.2fr 130px 90px 80px; padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9; }
.ap-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.ap-row { display:grid; grid-template-columns:1fr 1.2fr 130px 90px 80px; align-items:center; padding:13px 22px; border-bottom:1px solid #f3f4f6; transition:background .15s; }
.ap-row:last-child { border-bottom:none; }
.ap-row:hover { background:#f8faff; }
.ap-tenant-cell { display:flex; align-items:center; gap:10px; }
.ap-avatar { width:34px; height:34px; border-radius:50%; background:#dbeafe; color:#1e3a8a; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; flex-shrink:0; }
.ap-tname { font-size:13px; font-weight:700; color:#1e3a8a; text-decoration:none; display:block; margin-bottom:1px; }
.ap-tname:hover { text-decoration:underline; }
.ap-tsub { font-size:11px; color:#94a3b8; }
.ap-email { font-size:12.5px; color:#475569; }
.ap-phone { font-size:13px; color:#475569; }
.ap-gender { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; background:#f1f5f9; color:#475569; font-size:12px; font-weight:600; }
.ap-visit-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; background:#eff6ff; color:#1e3a8a; font-size:12px; font-weight:700; }
.ap-empty { text-align:center; padding:52px 20px; }
.ap-empty i { font-size:30px; color:#e2e8f0; display:block; margin-bottom:12px; }
.ap-empty p { font-size:13px; color:#94a3b8; margin:0; }
@media(max-width:900px){ .ap-layout { grid-template-columns:1fr; } .ap-col-hdr,.ap-row { grid-template-columns:1fr 1.2fr 100px auto; } .ap-col-hdr span:nth-child(n+4),.ap-row>div:nth-child(n+4) { display:none; } }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="ap-header">
    <div class="ap-header-left">
        <div class="ap-apt-icon"><i class="fas fa-building"></i></div>
        <div>
            <h2>{{ $apartment->apartment_number }}</h2>
            <p>
                <i class="fas fa-layer-group" style="font-size:10px;color:rgba(255,255,255,.4);"></i> {{ $apartment->block_name }}
                &nbsp;&middot;&nbsp;
                <i class="fas fa-stairs" style="font-size:10px;color:rgba(255,255,255,.4);"></i> Floor {{ $apartment->floor_number }}
                &nbsp;&middot;&nbsp;
                <span class="ap-status-chip ap-status-{{ $apartment->status }}">
                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                    {{ ucfirst($apartment->status) }}
                </span>
            </p>
        </div>
    </div>
    <div class="ap-header-actions">
        <a href="{{ route('admin.apartments.edit', $apartment) }}" class="ap-edit-btn">
            <i class="fas fa-pen" style="font-size:11px;"></i> Edit
        </a>
        <a href="{{ route('admin.apartments.index') }}" class="ap-back-btn">
            <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back
        </a>
    </div>
</div>

<div class="ap-layout">

    {{-- LEFT: INFO CARD --}}
    <div>
        <div class="ap-info-card">
            <div class="ap-info-hero">
                <div class="ap-info-apt-badge">{{ $apartment->apartment_number }}</div>
                <div class="ap-info-block">{{ $apartment->block_name }}</div>
                <span class="ap-info-status ap-info-status-{{ $apartment->status }}">
                    @if($apartment->status === 'occupied')
                        <i class="fas fa-circle-dot" style="font-size:9px;"></i> Occupied
                    @else
                        <i class="fas fa-circle" style="font-size:9px;"></i> Vacant
                    @endif
                </span>
            </div>

            <div class="ap-stats-row">
                <div class="ap-stat-cell">
                    <div class="ap-stat-n">{{ $apartment->floor_number }}</div>
                    <div class="ap-stat-l">Floor</div>
                </div>
                <div class="ap-stat-cell">
                    <div class="ap-stat-n">{{ $apartment->tenants->count() }}</div>
                    <div class="ap-stat-l">Tenants</div>
                </div>
            </div>

            <div class="ap-info-body">
                <div class="ap-info-row">
                    <span class="ap-info-key">Apt. No.</span>
                    <span class="ap-info-val">{{ $apartment->apartment_number }}</span>
                </div>
                <div class="ap-info-row">
                    <span class="ap-info-key">Block</span>
                    <span class="ap-info-val">{{ $apartment->block_name }}</span>
                </div>
                <div class="ap-info-row">
                    <span class="ap-info-key">Floor</span>
                    <span class="ap-info-val">{{ $apartment->floor_number }}</span>
                </div>
                <div class="ap-info-row">
                    <span class="ap-info-key">Total Visits</span>
                    <span class="ap-info-val">{{ $apartment->tenants->sum(fn($t) => $t->visits->count()) }}</span>
                </div>
                <div class="ap-info-row">
                    <span class="ap-info-key">Added</span>
                    <span class="ap-info-val" style="font-size:12px;">{{ $apartment->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: TENANTS PANEL --}}
    <div>
        <div class="ap-panel">
            <div class="ap-panel-head">
                <span class="ap-panel-title">
                    <i class="fas fa-users" style="color:#1e3a8a;font-size:13px;"></i>
                    Tenants
                    <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $apartment->tenants->count() }}</span>
                </span>
                <a href="{{ route('admin.tenants.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:linear-gradient(135deg,#1e3a8a,#1d4ed8);color:#fff;border-radius:9px;font-size:12px;font-weight:700;text-decoration:none;">
                    <i class="fas fa-plus" style="font-size:10px;"></i> Add Tenant
                </a>
            </div>

            @if($apartment->tenants->count())
            <div class="ap-col-hdr">
                <span class="ap-col-h">Tenant</span>
                <span class="ap-col-h">Email</span>
                <span class="ap-col-h">Phone</span>
                <span class="ap-col-h">Gender</span>
                <span class="ap-col-h">Visits</span>
            </div>
            @foreach($apartment->tenants as $tenant)
            @php
                $tp = explode(' ', trim($tenant->user->name));
                $ti = strtoupper(substr($tp[0],0,1)).(isset($tp[1])?strtoupper(substr($tp[1],0,1)):'');
            @endphp
            <div class="ap-row">
                <div class="ap-tenant-cell">
                    <div class="ap-avatar">{{ $ti }}</div>
                    <div>
                        <a href="{{ route('admin.tenants.show', $tenant) }}" class="ap-tname">{{ $tenant->user->name }}</a>
                        <span class="ap-tsub">{{ $tenant->national_id ?? 'No ID' }}</span>
                    </div>
                </div>
                <div class="ap-email">{{ $tenant->user->email }}</div>
                <div class="ap-phone">{{ $tenant->phone ?? '—' }}</div>
                <div>
                    <span class="ap-gender">
                        @if($tenant->gender === 'male')<i class="fas fa-mars" style="font-size:9px;"></i>
                        @elseif($tenant->gender === 'female')<i class="fas fa-venus" style="font-size:9px;"></i>
                        @endif
                        {{ ucfirst($tenant->gender ?? '—') }}
                    </span>
                </div>
                <div>
                    <span class="ap-visit-badge"><i class="fas fa-door-open" style="font-size:10px;"></i> {{ $tenant->visits->count() }}</span>
                </div>
            </div>
            @endforeach
            @else
            <div class="ap-empty">
                <i class="fas fa-users"></i>
                <p>No tenants assigned to this apartment yet.</p>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
