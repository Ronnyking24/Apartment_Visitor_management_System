@extends('layouts.dashboard')
@section('title','Residents')
@section('page-title','Residents')

@push('styles')
<style>
.ati-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.ati-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.ati-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.ati-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.ati-count-chip { display:inline-flex; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); padding:7px 16px; border-radius:10px; color:#fff; white-space:nowrap; }
.ati-count-chip .cn { font-size:20px; font-weight:800; line-height:1; }
.ati-count-chip .cl { font-size:10px; color:rgba(255,255,255,.5); display:block; margin-top:1px; }
.ati-add-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; background:#fff; color:#1e3a8a; border:none; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s; }
.ati-add-btn:hover { background:#dbeafe; color:#1d4ed8; }
.ati-toolbar { background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,.06); box-shadow:0 1px 4px rgba(0,0,0,.05); padding:16px 20px; display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; margin-bottom:18px; }
.ati-fg { display:flex; flex-direction:column; gap:5px; }
.ati-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; }
.ati-inp { padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; outline:none; font-family:inherit; transition:border-color .2s,box-shadow .2s; background:#fff; }
.ati-inp:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.ati-sw { position:relative; }
.ati-sw i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.ati-sw .ati-inp { padding-left:34px; min-width:260px; }
.ati-fbtn { padding:9px 20px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; font-size:13px; font-weight:700; border:none; border-radius:10px; cursor:pointer; font-family:inherit; display:inline-flex; align-items:center; gap:6px; }
.ati-rbtn { padding:9px 16px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .2s; }
.ati-rbtn:hover { background:#e2e8f0; color:#0f172a; }
.ati-panel { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow-x:auto; overflow-y:hidden; }
.ati-panel-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.ati-panel-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.ati-col-hdr { display:grid; grid-template-columns:44px minmax(220px,1.25fr) minmax(220px,1fr) minmax(180px,1fr) 140px 100px 110px; column-gap:14px; padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9; }
.ati-col-hdr > *, .ati-row > * { min-width:0; }
.ati-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.ati-row { display:grid; grid-template-columns:44px minmax(220px,1.25fr) minmax(220px,1fr) minmax(180px,1fr) 140px 100px 110px; column-gap:14px; align-items:center; padding:13px 22px; border-bottom:1px solid #f3f4f6; transition:background .15s; }
.ati-row:last-child { border-bottom:none; }
.ati-row:hover { background:#f8faff; }
.ati-num { font-size:12.5px; font-weight:700; color:#94a3b8; }
.ati-cell { display:flex; align-items:center; gap:10px; min-width:0; }
.ati-avatar { width:36px; height:36px; border-radius:50%; background:#dbeafe; color:#1e3a8a; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; flex-shrink:0; }
.ati-name { font-size:13px; font-weight:700; color:#0f172a; display:block; margin-bottom:1px; }
.ati-sub  { font-size:11.5px; color:#94a3b8; font-family:monospace; }
.ati-email { font-size:12.5px; color:#475569; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.ati-apt-num { font-size:13px; font-weight:700; color:#1e3a8a; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.ati-apt-block { font-size:11.5px; color:#94a3b8; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.ati-unassigned { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; background:#fef3c7; color:#92400e; font-size:11.5px; font-weight:700; }
.ati-row-pending { background:#fffbeb !important; }
.ati-row-pending:hover { background:#fef9c3 !important; }
.ati-phone { font-size:13px; color:#475569; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.ati-gender { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; background:#f1f5f9; color:#475569; font-size:12px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.ati-act { display:flex; gap:6px; justify-content:flex-end; }
.ati-btn-v,.ati-btn-e,.ati-btn-d { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:8px; font-size:12px; border:1.5px solid; cursor:pointer; transition:all .18s; text-decoration:none; }
.ati-btn-v { background:#f1f5f9; color:#64748b; border-color:#e2e8f0; }
.ati-btn-v:hover { background:#e2e8f0; color:#0f172a; }
.ati-btn-e { background:#eff6ff; color:#1e3a8a; border-color:#bfdbfe; }
.ati-btn-e:hover { background:#1e3a8a; color:#fff; }
.ati-btn-d { background:#fee2e2; color:#dc2626; border-color:#fecaca; }
.ati-btn-d:hover { background:#dc2626; color:#fff; }
.ati-empty { text-align:center; padding:64px 20px; }
.ati-empty-icon { width:72px; height:72px; background:#eff6ff; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:28px; color:#93c5fd; margin:0 auto 16px; border:2px solid #bfdbfe; }
.ati-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.ati-empty p  { font-size:13px; color:#94a3b8; margin:0; }
.ati-pag { padding:14px 22px; border-top:1px solid #f1f5f9; }
.dark-mode .ati-toolbar,.dark-mode .ati-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .ati-inp { background:#0f172a; border-color:rgba(255,255,255,.1); color:#e2e8f0; }
.dark-mode .ati-col-hdr { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .ati-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .ati-panel-title,.dark-mode .ati-name { color:#f1f5f9; }
.dark-mode .ati-row { border-color:rgba(255,255,255,.04); }
.dark-mode .ati-row:hover { background:#243044; }
.dark-mode .ati-empty h5 { color:#f1f5f9; }
@media(max-width:900px){ .ati-col-hdr,.ati-row { grid-template-columns:36px minmax(220px,1.25fr) minmax(220px,1fr) minmax(180px,1fr) 140px 100px 110px; column-gap:12px; } }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="ati-header">
    <div>
        <h2><i class="fas fa-users me-2" style="color:#93c5fd;font-size:15px;"></i>Residents</h2>
        <p>Manage all registered residents and their apartments</p>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        <div class="ati-count-chip"><div><span class="cn">{{ $tenants->total() }}</span><span class="cl">Total Residents</span></div></div>
        <a href="{{ route('admin.tenants.create') }}" class="ati-add-btn"><i class="fas fa-plus" style="font-size:11px;"></i> Add Resident</a>
    </div>
</div>

{{-- FILTER --}}
<div class="ati-toolbar">
    <form method="GET" style="display:contents;">
        <div class="ati-fg">
            <span class="ati-lbl">Search Resident</span>
            <div class="ati-sw">
                <i class="fas fa-magnifying-glass"></i>
                <input type="text" name="search" class="ati-inp" placeholder="Name, email, phone, ID…" value="{{ request('search') }}">
            </div>
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;">
            <button type="submit" class="ati-fbtn"><i class="fas fa-magnifying-glass" style="font-size:11px;"></i> Search</button>
            @if(request('search'))
            <a href="{{ route('admin.tenants.index') }}" class="ati-rbtn"><i class="fas fa-xmark"></i> Clear</a>
            @endif
        </div>
    </form>
</div>

{{-- PANEL --}}
<div class="ati-panel">
    <div class="ati-panel-head">
        <span class="ati-panel-title">
            <i class="fas fa-users" style="color:#1e3a8a;font-size:13px;"></i>
                Resident List
            <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $tenants->total() }}</span>
        </span>
        <span style="font-size:12.5px;color:#94a3b8;">Showing {{ $tenants->firstItem() ?? 0 }}–{{ $tenants->lastItem() ?? 0 }} of {{ $tenants->total() }}</span>
    </div>

    <div class="ati-col-hdr">
        <span class="ati-col-h">#</span>
        <span class="ati-col-h">Name</span>
        <span class="ati-col-h">Email</span>
        <span class="ati-col-h">Apartment</span>
        <span class="ati-col-h">Phone</span>
        <span class="ati-col-h">Gender</span>
        <span class="ati-col-h" style="text-align:right;">Actions</span>
    </div>

    @forelse($tenants as $tenant)
    @php
        $parts    = explode(' ', trim($tenant->user->name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
        $noApt    = is_null($tenant->apartment_id);
    @endphp
    <div class="ati-row {{ $noApt ? 'ati-row-pending' : '' }}">
        <span class="ati-num">{{ str_pad($tenants->firstItem()+$loop->index,2,'0',STR_PAD_LEFT) }}</span>
        <div class="ati-cell">
            <div class="ati-avatar">{{ $initials }}</div>
            <div>
                <span class="ati-name">{{ $tenant->user->name }}</span>
                <span class="ati-sub">{{ $tenant->national_id ?? '—' }}</span>
            </div>
        </div>
        <div class="ati-email">{{ $tenant->user->email }}</div>
        <div>
            @php $apartmentLabel = $tenant->apartment_display; @endphp
            @if($apartmentLabel)
                <span class="ati-apt-num">{{ $apartmentLabel }}</span>
                @if($tenant->apartment?->block_name)
                    <span class="ati-apt-block">{{ $tenant->apartment->block_name }}</span>
                @endif
            @else
                <a href="{{ route('admin.tenants.edit', $tenant) }}" style="text-decoration:none;">
                    <span class="ati-unassigned"><i class="fas fa-clock" style="font-size:9px;"></i> Assign</span>
                </a>
            @endif
        </div>
        <div class="ati-phone">{{ $tenant->phone ?? '—' }}</div>
        <div>
            <span class="ati-gender">
                @if(($tenant->gender ?? '') === 'male')<i class="fas fa-mars" style="font-size:10px;"></i>@elseif(($tenant->gender ?? '') === 'female')<i class="fas fa-venus" style="font-size:10px;"></i>@endif
                {{ ucfirst($tenant->gender ?? '—') }}
            </span>
        </div>
        <div class="ati-act">
            <a href="{{ route('admin.tenants.show', $tenant) }}" class="ati-btn-v" title="View"><i class="fas fa-eye"></i></a>
            <a href="{{ route('admin.tenants.edit', $tenant) }}" class="ati-btn-e" title="Edit"><i class="fas fa-pen"></i></a>
            <form method="POST" action="{{ route('admin.tenants.destroy', $tenant) }}" style="margin:0;" onsubmit="return confirm('Delete this resident and their account?')">
                @csrf @method('DELETE')
                <button class="ati-btn-d" title="Delete"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="ati-empty">
        <div class="ati-empty-icon"><i class="fas fa-users"></i></div>
        <h5>No residents found</h5>
        <p>Try a different search term or add a new resident.</p>
    </div>
    @endforelse

    @if($tenants->hasPages())
    <div class="ati-pag">{{ $tenants->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
