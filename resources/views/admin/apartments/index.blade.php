@extends('layouts.dashboard')
@section('title','Apartments')
@section('page-title','Apartments')

@push('styles')
<style>
.ai-header {
    background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius:14px; padding:20px 26px;
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; flex-wrap:wrap; margin-bottom:22px;
    position:relative; overflow:hidden;
}
.ai-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.ai-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.ai-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.ai-header-right { display:flex; align-items:center; gap:10px; }
.ai-count-chip { display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); padding:7px 16px; border-radius:10px; color:#fff; white-space:nowrap; }
.ai-count-chip .cn { font-size:20px; font-weight:800; line-height:1; }
.ai-count-chip .cl { font-size:10px; color:rgba(255,255,255,.5); display:block; margin-top:1px; }
.ai-add-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; background:#fff; color:#1e3a8a; border:none; border-radius:10px; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s; white-space:nowrap; }
.ai-add-btn:hover { background:#dbeafe; color:#1d4ed8; }
.ai-toolbar { background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,.06); box-shadow:0 1px 4px rgba(0,0,0,.05); padding:16px 20px; display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; margin-bottom:18px; }
.ai-fg { display:flex; flex-direction:column; gap:5px; }
.ai-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; }
.ai-inp,.ai-sel { padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; outline:none; font-family:inherit; transition:border-color .2s,box-shadow .2s; background:#fff; }
.ai-inp:focus,.ai-sel:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.ai-sw { position:relative; }
.ai-sw i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.ai-sw .ai-inp { padding-left:34px; min-width:200px; }
.ai-fbtn { padding:9px 20px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; font-size:13px; font-weight:700; border:none; border-radius:10px; cursor:pointer; font-family:inherit; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; }
.ai-rbtn { padding:9px 16px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; transition:all .2s; }
.ai-rbtn:hover { background:#e2e8f0; color:#0f172a; }
.ai-panel { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden; }
.ai-panel-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.ai-panel-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.ai-meta { font-size:12.5px; color:#94a3b8; }
.ai-col-hdr { display:grid; grid-template-columns:44px 130px 130px 100px 220px 130px 130px; padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9; }
.ai-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.ai-row { display:grid; grid-template-columns:44px 130px 130px 100px 220px 130px 130px; align-items:center; padding:13px 22px; border-bottom:1px solid #f3f4f6; transition:background .15s; }
.ai-row:last-child { border-bottom:none; }
.ai-row:hover { background:#f8faff; }
.ai-num { font-size:12.5px; font-weight:700; color:#94a3b8; }
.ai-apt-num { font-size:14px; font-weight:800; color:#1e3a8a; }
.ai-block { font-size:13px; color:#475569; }
.ai-floor { font-size:12.5px; color:#64748b; }
.ai-tc { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; background:#eff6ff; color:#1e3a8a; font-size:12px; font-weight:700; }
.ai-status-occupied { background:#dcfce7; color:#16a34a; display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:700; }
.ai-status-vacant    { background:#f1f5f9; color:#64748b; display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:700; }
.ai-act { display:flex; gap:6px; justify-content:flex-end; }
.ai-btn-v,.ai-btn-e,.ai-btn-d { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:8px; font-size:12px; border:1.5px solid; cursor:pointer; transition:all .18s; text-decoration:none; }
.ai-btn-v { background:#f1f5f9; color:#64748b; border-color:#e2e8f0; }
.ai-btn-v:hover { background:#e2e8f0; color:#0f172a; }
.ai-btn-e { background:#eff6ff; color:#1e3a8a; border-color:#bfdbfe; }
.ai-btn-e:hover { background:#1e3a8a; color:#fff; }
.ai-btn-d { background:#fee2e2; color:#dc2626; border-color:#fecaca; }
.ai-btn-d:hover { background:#dc2626; color:#fff; }
.ai-empty { text-align:center; padding:64px 20px; }
.ai-empty-icon { width:72px; height:72px; background:#eff6ff; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:28px; color:#93c5fd; margin:0 auto 16px; border:2px solid #bfdbfe; }
.ai-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.ai-empty p  { font-size:13px; color:#94a3b8; margin:0; }
.ai-pag { padding:14px 22px; border-top:1px solid #f1f5f9; }
.dark-mode .ai-toolbar,.dark-mode .ai-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .ai-inp,.dark-mode .ai-sel { background:#0f172a; border-color:rgba(255,255,255,.1); color:#e2e8f0; }
.dark-mode .ai-col-hdr { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .ai-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .ai-panel-title { color:#f1f5f9; }
.dark-mode .ai-row { border-color:rgba(255,255,255,.04); }
.dark-mode .ai-row:hover { background:#243044; }
.dark-mode .ai-apt-num { color:#93c5fd; }
.dark-mode .ai-empty h5 { color:#f1f5f9; }
@media(max-width:900px){ .ai-col-hdr,.ai-row { grid-template-columns:36px 110px 110px 90px 90px auto; } .ai-col-hdr span:nth-child(7),.ai-row>div:nth-child(7) { display:none; } }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="ai-header">
    <div>
        <h2><i class="fas fa-building me-2" style="color:#93c5fd;font-size:15px;"></i>Apartments</h2>
        <p>Manage all apartment units in the complex</p>
    </div>
    <div class="ai-header-right">
        <div class="ai-count-chip">
            <div><span class="cn">{{ $apartments->total() }}</span><span class="cl">Total Units</span></div>
        </div>
        <a href="{{ route('admin.apartments.create') }}" class="ai-add-btn">
            <i class="fas fa-plus" style="font-size:11px;"></i> Add Apartment
        </a>
    </div>
</div>

{{-- FILTER --}}
<div class="ai-toolbar">
    <form method="GET" style="display:contents;">
        <div class="ai-fg">
            <span class="ai-lbl">Search</span>
            <div class="ai-sw">
                <i class="fas fa-magnifying-glass"></i>
                <input type="text" name="search" class="ai-inp" placeholder="Apt. number or block…" value="{{ request('search') }}">
            </div>
        </div>
        <div class="ai-fg">
            <span class="ai-lbl">Status</span>
            <select name="status" class="ai-sel" style="min-width:140px;">
                <option value="">All Statuses</option>
                <option value="occupied" {{ request('status')=='occupied'?'selected':'' }}>Occupied</option>
                <option value="vacant"   {{ request('status')=='vacant'?'selected':'' }}>Vacant</option>
            </select>
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;">
            <button type="submit" class="ai-fbtn"><i class="fas fa-filter" style="font-size:11px;"></i> Filter</button>
            @if(request()->hasAny(['search','status']) && array_filter(request()->only(['search','status'])))
            <a href="{{ route('admin.apartments.index') }}" class="ai-rbtn"><i class="fas fa-xmark"></i> Clear</a>
            @endif
        </div>
    </form>
</div>

{{-- PANEL --}}
<div class="ai-panel">
    <div class="ai-panel-head">
        <span class="ai-panel-title">
            <i class="fas fa-building" style="color:#1e3a8a;font-size:13px;"></i>
            Apartment Units
            <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $apartments->total() }}</span>
        </span>
        <span class="ai-meta">Showing {{ $apartments->firstItem() ?? 0 }}–{{ $apartments->lastItem() ?? 0 }} of {{ $apartments->total() }}</span>
    </div>

    <div class="ai-col-hdr">
        <span class="ai-col-h">#</span>
        <span class="ai-col-h">Apt. No.</span>
        <span class="ai-col-h">Block</span>
        <span class="ai-col-h">Floor</span>
        <span class="ai-col-h">Resident</span>
        <span class="ai-col-h">Status</span>
        <span class="ai-col-h" style="text-align:right;">Actions</span>
    </div>

    @forelse($apartments as $apt)
    <div class="ai-row">
        <span class="ai-num">{{ str_pad($apartments->firstItem()+$loop->index,2,'0',STR_PAD_LEFT) }}</span>
        <div class="ai-apt-num">{{ $apt->apartment_number }}</div>
        <div class="ai-block">{{ $apt->block_name }}</div>
        <div class="ai-floor"><i class="fas fa-layer-group" style="font-size:10px;color:#94a3b8;margin-right:4px;"></i>Floor {{ $apt->floor_number }}</div>
        <div>
            @if($apt->status === 'occupied')
                {{ $apt->activeResident?->user->name ?? 'Assigned' }}
            @else
                —
            @endif
        </div>
        <div>
            @if($apt->status === 'occupied')
                <span class="ai-status-occupied"><i class="fas fa-check" style="font-size:9px;"></i> Occupied</span>
            @else
                <span class="ai-status-vacant"><i class="fas fa-minus" style="font-size:9px;"></i> Vacant</span>
            @endif
        </div>
        <div class="ai-act">
            <a href="{{ route('admin.apartments.show', $apt) }}" class="ai-btn-v" title="View"><i class="fas fa-eye"></i></a>
            <a href="{{ route('admin.apartments.edit', $apt) }}" class="ai-btn-e" title="Edit"><i class="fas fa-pen"></i></a>
            <form method="POST" action="{{ route('admin.apartments.destroy', $apt) }}" style="margin:0;" onsubmit="return confirm('Delete this apartment?')">
                @csrf @method('DELETE')
                <button class="ai-btn-d" title="Delete"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="ai-empty">
        <div class="ai-empty-icon"><i class="fas fa-building"></i></div>
        <h5>No apartments found</h5>
        <p>Try adjusting your filters or add a new apartment.</p>
    </div>
    @endforelse

    @if($apartments->hasPages())
    <div class="ai-pag">{{ $apartments->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
