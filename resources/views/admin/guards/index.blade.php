@extends('layouts.dashboard')
@section('title','Security Guards')
@section('page-title','Security Guards')

@push('styles')
<style>
.agi-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.agi-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.agi-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.agi-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.agi-count-chip { display:inline-flex; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); padding:7px 16px; border-radius:10px; color:#fff; white-space:nowrap; }
.agi-count-chip .cn { font-size:20px; font-weight:800; line-height:1; }
.agi-count-chip .cl { font-size:10px; color:rgba(255,255,255,.5); display:block; margin-top:1px; }
.agi-add-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; background:#fff; color:#1e3a8a; border:none; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s; }
.agi-add-btn:hover { background:#dbeafe; color:#1d4ed8; }
.agi-toolbar { background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,.06); box-shadow:0 1px 4px rgba(0,0,0,.05); padding:16px 20px; display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; margin-bottom:18px; }
.agi-fg { display:flex; flex-direction:column; gap:5px; }
.agi-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; }
.agi-inp { padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; outline:none; font-family:inherit; transition:border-color .2s,box-shadow .2s; background:#fff; }
.agi-inp:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.agi-sw { position:relative; }
.agi-sw i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.agi-sw .agi-inp { padding-left:34px; min-width:260px; }
.agi-fbtn { padding:9px 20px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; font-size:13px; font-weight:700; border:none; border-radius:10px; cursor:pointer; font-family:inherit; display:inline-flex; align-items:center; gap:6px; }
.agi-rbtn { padding:9px 16px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .2s; }
.agi-rbtn:hover { background:#e2e8f0; color:#0f172a; }
.agi-panel { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden; }
.agi-panel-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.agi-panel-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.agi-col-hdr { display:grid; grid-template-columns:44px 1fr 220px 140px 120px 120px; padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9; }
.agi-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.agi-row { display:grid; grid-template-columns:44px 1fr 220px 140px 120px 120px; align-items:center; padding:14px 22px; border-bottom:1px solid #f3f4f6; transition:background .15s; }
.agi-row:last-child { border-bottom:none; }
.agi-row:hover { background:#f8faff; }
.agi-num { font-size:12.5px; font-weight:700; color:#94a3b8; }
.agi-cell { display:flex; align-items:center; gap:10px; }
.agi-avatar { width:38px; height:38px; border-radius:50%; background:#dbeafe; color:#1e3a8a; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; flex-shrink:0; border:2px solid #bfdbfe; }
.agi-name { font-size:13px; font-weight:700; color:#0f172a; display:block; margin-bottom:2px; }
.agi-badge { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:20px; background:#eff6ff; color:#1e3a8a; font-size:10.5px; font-weight:700; }
.agi-email { font-size:12.5px; color:#475569; }
.agi-joined { font-size:12px; color:#64748b; display:block; }
.agi-joined-rel { font-size:11px; color:#94a3b8; display:block; }
.agi-status { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:11.5px; font-weight:700; }
.agi-st-active    { background:#dcfce7; color:#16a34a; }
.agi-st-pending   { background:#fef9c3; color:#92400e; }
.agi-st-suspended { background:#fee2e2; color:#dc2626; }
.agi-act { display:flex; gap:5px; justify-content:flex-end; flex-wrap:wrap; }
.agi-btn-e,.agi-btn-d,.agi-btn-ok,.agi-btn-ban,.agi-btn-on { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:8px; font-size:12px; border:1.5px solid; cursor:pointer; transition:all .18s; text-decoration:none; background:none; }
.agi-btn-e { background:#eff6ff; color:#1e3a8a; border-color:#bfdbfe; }
.agi-btn-e:hover { background:#1e3a8a; color:#fff; }
.agi-btn-d { background:#fee2e2; color:#dc2626; border-color:#fecaca; }
.agi-btn-d:hover { background:#dc2626; color:#fff; }
.agi-btn-ok  { background:#dcfce7; color:#16a34a; border-color:#bbf7d0; }
.agi-btn-ok:hover  { background:#16a34a; color:#fff; }
.agi-btn-ban { background:#fef9c3; color:#92400e; border-color:#fde68a; }
.agi-btn-ban:hover { background:#d97706; color:#fff; }
.agi-btn-on  { background:#dbeafe; color:#1e3a8a; border-color:#bfdbfe; }
.agi-btn-on:hover  { background:#1e3a8a; color:#fff; }
.agi-pending-banner { background:linear-gradient(135deg,#fef3c7,#fde68a); border:1.5px solid #fbbf24; border-radius:12px; padding:12px 16px; display:flex; align-items:center; gap:10px; margin-bottom:16px; font-size:13px; color:#92400e; font-weight:600; }
.agi-pending-banner i { font-size:16px; color:#d97706; }
.agi-empty { text-align:center; padding:64px 20px; }
.agi-empty-icon { width:72px; height:72px; background:#eff6ff; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:28px; color:#93c5fd; margin:0 auto 16px; border:2px solid #bfdbfe; }
.agi-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.agi-empty p  { font-size:13px; color:#94a3b8; margin:0; }
.agi-pag { padding:14px 22px; border-top:1px solid #f1f5f9; }
.dark-mode .agi-toolbar,.dark-mode .agi-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .agi-inp { background:#0f172a; border-color:rgba(255,255,255,.1); color:#e2e8f0; }
.dark-mode .agi-col-hdr { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .agi-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .agi-panel-title,.dark-mode .agi-name { color:#f1f5f9; }
.dark-mode .agi-row { border-color:rgba(255,255,255,.04); }
.dark-mode .agi-row:hover { background:#243044; }
.dark-mode .agi-empty h5 { color:#f1f5f9; }
</style>
@endpush

@section('content')

@php $pendingCount = \App\Models\User::where('role','guard')->where('status','pending')->count(); @endphp

{{-- HEADER --}}
<div class="agi-header">
    <div>
        <h2><i class="fas fa-shield-halved me-2" style="color:#93c5fd;font-size:15px;"></i>Security Guards</h2>
        <p>Manage security guard accounts and access</p>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        @if($pendingCount > 0)
        <div style="background:rgba(251,191,36,.2);border:1px solid rgba(251,191,36,.4);padding:7px 14px;border-radius:10px;display:flex;align-items:center;gap:7px;">
            <i class="fas fa-clock" style="color:#fbbf24;font-size:13px;"></i>
            <span style="font-size:13px;font-weight:700;color:#fff;">{{ $pendingCount }} Pending</span>
        </div>
        @endif
        <div class="agi-count-chip"><div><span class="cn">{{ $guards->total() }}</span><span class="cl">Total Guards</span></div></div>
        <a href="{{ route('admin.guards.create') }}" class="agi-add-btn"><i class="fas fa-plus" style="font-size:11px;"></i> Add Guard</a>
    </div>
</div>

{{-- FILTER --}}
<div class="agi-toolbar">
    <form method="GET" style="display:contents;">
        <div class="agi-fg">
            <span class="agi-lbl">Search Guard</span>
            <div class="agi-sw">
                <i class="fas fa-magnifying-glass"></i>
                <input type="text" name="search" class="agi-inp" placeholder="Name or email…" value="{{ request('search') }}">
            </div>
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;">
            <button type="submit" class="agi-fbtn"><i class="fas fa-magnifying-glass" style="font-size:11px;"></i> Search</button>
            @if(request('search'))
            <a href="{{ route('admin.guards.index') }}" class="agi-rbtn"><i class="fas fa-xmark"></i> Clear</a>
            @endif
        </div>
    </form>
</div>

@if(session('success'))
<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;margin-bottom:14px;display:flex;align-items:center;gap:9px;font-size:13px;color:#15803d;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if($pendingCount > 0)
<div class="agi-pending-banner">
    <i class="fas fa-clock"></i>
    <span>{{ $pendingCount }} guard {{ Str::plural('account', $pendingCount) }} awaiting approval — review and activate below.</span>
</div>
@endif

{{-- PANEL --}}
<div class="agi-panel">
    <div class="agi-panel-head">
        <span class="agi-panel-title">
            <i class="fas fa-shield-halved" style="color:#1e3a8a;font-size:13px;"></i>
            Guard List
            <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $guards->total() }}</span>
        </span>
        <span style="font-size:12.5px;color:#94a3b8;">Showing {{ $guards->firstItem() ?? 0 }}–{{ $guards->lastItem() ?? 0 }} of {{ $guards->total() }}</span>
    </div>

    <div class="agi-col-hdr">
        <span class="agi-col-h">#</span>
        <span class="agi-col-h">Name</span>
        <span class="agi-col-h">Email</span>
        <span class="agi-col-h">Joined</span>
        <span class="agi-col-h">Status</span>
        <span class="agi-col-h" style="text-align:right;">Actions</span>
    </div>

    @forelse($guards as $guard)
    @php
        $parts    = explode(' ', trim($guard->name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
        $stCls    = ['active'=>'agi-st-active','pending'=>'agi-st-pending','suspended'=>'agi-st-suspended'][$guard->status] ?? 'agi-st-pending';
        $stIcon   = ['active'=>'fa-check-circle','pending'=>'fa-clock','suspended'=>'fa-ban'][$guard->status] ?? 'fa-clock';
        $stLabel  = ucfirst($guard->status);
    @endphp
    <div class="agi-row" style="{{ $guard->status === 'pending' ? 'background:#fffbeb;' : '' }}">
        <span class="agi-num">{{ str_pad($guards->firstItem()+$loop->index,2,'0',STR_PAD_LEFT) }}</span>
        <div class="agi-cell">
            <div class="agi-avatar" style="{{ $guard->status === 'pending' ? 'background:#fef3c7;color:#d97706;border-color:#fde68a;' : '' }}">{{ $initials }}</div>
            <div>
                <span class="agi-name">{{ $guard->name }}</span>
                <span class="agi-badge"><i class="fas fa-shield-halved" style="font-size:9px;"></i> Guard</span>
            </div>
        </div>
        <div class="agi-email">{{ $guard->email }}</div>
        <div>
            <span class="agi-joined">{{ $guard->created_at->format('M d, Y') }}</span>
            <span class="agi-joined-rel">{{ $guard->created_at->diffForHumans() }}</span>
        </div>
        <div>
            <span class="agi-status {{ $stCls }}">
                <i class="fas {{ $stIcon }}" style="font-size:9px;"></i> {{ $stLabel }}
            </span>
        </div>
        <div class="agi-act">
            @if($guard->status === 'pending')
            <form method="POST" action="{{ route('admin.guards.approve', $guard) }}" style="margin:0;">
                @csrf @method('PATCH')
                <button class="agi-btn-ok" title="Approve &amp; Activate"><i class="fas fa-check"></i></button>
            </form>
            @elseif($guard->status === 'active')
            <form method="POST" action="{{ route('admin.guards.suspend', $guard) }}" style="margin:0;" onsubmit="return confirm('Suspend this guard?')">
                @csrf @method('PATCH')
                <button class="agi-btn-ban" title="Suspend"><i class="fas fa-ban"></i></button>
            </form>
            @elseif($guard->status === 'suspended')
            <form method="POST" action="{{ route('admin.guards.activate', $guard) }}" style="margin:0;">
                @csrf @method('PATCH')
                <button class="agi-btn-on" title="Reactivate"><i class="fas fa-rotate-right"></i></button>
            </form>
            @endif
            <a href="{{ route('admin.guards.edit', $guard) }}" class="agi-btn-e" title="Edit"><i class="fas fa-pen"></i></a>
            <form method="POST" action="{{ route('admin.guards.destroy', $guard) }}" style="margin:0;" onsubmit="return confirm('Delete this guard?')">
                @csrf @method('DELETE')
                <button class="agi-btn-d" title="Delete"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="agi-empty">
        <div class="agi-empty-icon"><i class="fas fa-shield-halved"></i></div>
        <h5>No guards found</h5>
        <p>Try a different search term or add a new guard.</p>
    </div>
    @endforelse

    @if($guards->hasPages())
    <div class="agi-pag">{{ $guards->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
