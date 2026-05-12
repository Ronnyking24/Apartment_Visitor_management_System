@extends('layouts.dashboard')
@section('title','Visitors')
@section('page-title','Visitors')

@push('styles')
<style>
.avi-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.avi-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.avi-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.avi-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.avi-count-chip { display:inline-flex; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); padding:7px 16px; border-radius:10px; color:#fff; white-space:nowrap; }
.avi-count-chip .cn { font-size:20px; font-weight:800; line-height:1; }
.avi-count-chip .cl { font-size:10px; color:rgba(255,255,255,.5); display:block; margin-top:1px; }
.avi-toolbar { background:#fff; border-radius:14px; border:1px solid rgba(0,0,0,.06); box-shadow:0 1px 4px rgba(0,0,0,.05); padding:16px 20px; display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; margin-bottom:18px; }
.avi-fg { display:flex; flex-direction:column; gap:5px; }
.avi-lbl { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.6px; }
.avi-inp { padding:9px 13px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; outline:none; font-family:inherit; transition:border-color .2s,box-shadow .2s; background:#fff; }
.avi-inp:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.avi-sw { position:relative; }
.avi-sw i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.avi-sw .avi-inp { padding-left:34px; min-width:280px; }
.avi-fbtn { padding:9px 20px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; font-size:13px; font-weight:700; border:none; border-radius:10px; cursor:pointer; font-family:inherit; display:inline-flex; align-items:center; gap:6px; }
.avi-rbtn { padding:9px 16px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .2s; }
.avi-rbtn:hover { background:#e2e8f0; color:#0f172a; }
.avi-panel { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 1px 4px rgba(0,0,0,.05); overflow:hidden; }
.avi-panel-head { display:flex; align-items:center; justify-content:space-between; padding:15px 22px; border-bottom:1px solid #f1f5f9; }
.avi-panel-title { font-size:14px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
.avi-col-hdr { display:grid; grid-template-columns:44px 1fr 180px 160px 120px 100px; padding:9px 22px; background:#fafbfc; border-bottom:1px solid #f1f5f9; }
.avi-col-h { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; }
.avi-row { display:grid; grid-template-columns:44px 1fr 180px 160px 120px 100px; align-items:center; padding:13px 22px; border-bottom:1px solid #f3f4f6; transition:background .15s; }
.avi-row:last-child { border-bottom:none; }
.avi-row:hover { background:#f8faff; }
.avi-num { font-size:12.5px; font-weight:700; color:#94a3b8; }
.avi-cell { display:flex; align-items:center; gap:10px; }
.avi-avatar { width:38px; height:38px; border-radius:50%; background:#dbeafe; color:#1e3a8a; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; flex-shrink:0; overflow:hidden; border:2px solid #bfdbfe; }
.avi-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.avi-name { font-size:13px; font-weight:700; color:#0f172a; display:block; margin-bottom:1px; }
.avi-nid  { font-size:11.5px; color:#94a3b8; font-family:monospace; }
.avi-phone { font-size:13px; color:#475569; }
.avi-vc { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; background:#eff6ff; color:#1e3a8a; font-size:12px; font-weight:700; }
.avi-act { display:flex; gap:6px; justify-content:flex-end; }
.avi-btn-v,.avi-btn-d { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:8px; font-size:12px; border:1.5px solid; cursor:pointer; transition:all .18s; text-decoration:none; }
.avi-btn-v { background:#f1f5f9; color:#64748b; border-color:#e2e8f0; }
.avi-btn-v:hover { background:#e2e8f0; color:#0f172a; }
.avi-btn-d { background:#fee2e2; color:#dc2626; border-color:#fecaca; }
.avi-btn-d:hover { background:#dc2626; color:#fff; }
.avi-empty { text-align:center; padding:64px 20px; }
.avi-empty-icon { width:72px; height:72px; background:#eff6ff; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:28px; color:#93c5fd; margin:0 auto 16px; border:2px solid #bfdbfe; }
.avi-empty h5 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:6px; }
.avi-empty p  { font-size:13px; color:#94a3b8; margin:0; }
.avi-pag { padding:14px 22px; border-top:1px solid #f1f5f9; }
.dark-mode .avi-toolbar,.dark-mode .avi-panel { background:#1e293b; border-color:rgba(255,255,255,.07); }
.dark-mode .avi-inp { background:#0f172a; border-color:rgba(255,255,255,.1); color:#e2e8f0; }
.dark-mode .avi-col-hdr { background:#162032; border-color:rgba(255,255,255,.06); }
.dark-mode .avi-panel-head { border-color:rgba(255,255,255,.07); }
.dark-mode .avi-panel-title,.dark-mode .avi-name { color:#f1f5f9; }
.dark-mode .avi-row { border-color:rgba(255,255,255,.04); }
.dark-mode .avi-row:hover { background:#243044; }
.dark-mode .avi-empty h5 { color:#f1f5f9; }
@media(max-width:900px){ .avi-col-hdr,.avi-row { grid-template-columns:36px 1fr 160px 130px auto; } .avi-col-hdr span:nth-child(n+5),.avi-row>div:nth-child(n+5) { display:none; } }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<div class="avi-header">
    <div>
        <h2><i class="fas fa-person-walking-arrow-right me-2" style="color:#93c5fd;font-size:15px;"></i>Visitors</h2>
        <p>All registered visitors across the complex</p>
    </div>
    <div class="avi-count-chip"><div><span class="cn">{{ $visitors->total() }}</span><span class="cl">Total Visitors</span></div></div>
</div>

{{-- FILTER --}}
<div class="avi-toolbar">
    <form method="GET" style="display:contents;">
        <div class="avi-fg">
            <span class="avi-lbl">Search Visitor</span>
            <div class="avi-sw">
                <i class="fas fa-magnifying-glass"></i>
                <input type="text" name="search" class="avi-inp" placeholder="Name, national ID, phone…" value="{{ request('search') }}">
            </div>
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;">
            <button type="submit" class="avi-fbtn"><i class="fas fa-magnifying-glass" style="font-size:11px;"></i> Search</button>
            @if(request('search'))
            <a href="{{ route('admin.visitors.index') }}" class="avi-rbtn"><i class="fas fa-xmark"></i> Clear</a>
            @endif
        </div>
    </form>
</div>

{{-- PANEL --}}
<div class="avi-panel">
    <div class="avi-panel-head">
        <span class="avi-panel-title">
            <i class="fas fa-person-walking-arrow-right" style="color:#1e3a8a;font-size:13px;"></i>
            Visitor Records
            <span style="background:#eff6ff;color:#1e3a8a;font-size:11.5px;font-weight:700;padding:2px 10px;border-radius:20px;">{{ $visitors->total() }}</span>
        </span>
        <span style="font-size:12.5px;color:#94a3b8;">Showing {{ $visitors->firstItem() ?? 0 }}–{{ $visitors->lastItem() ?? 0 }} of {{ $visitors->total() }}</span>
    </div>

    <div class="avi-col-hdr">
        <span class="avi-col-h">#</span>
        <span class="avi-col-h">Visitor</span>
        <span class="avi-col-h">National ID</span>
        <span class="avi-col-h">Phone</span>
        <span class="avi-col-h">Visits</span>
        <span class="avi-col-h" style="text-align:right;">Actions</span>
    </div>

    @forelse($visitors as $visitor)
    @php
        $parts    = explode(' ', trim($visitor->full_name));
        $initials = strtoupper(substr($parts[0],0,1)).(isset($parts[1]) ? strtoupper(substr($parts[1],0,1)) : '');
    @endphp
    <div class="avi-row">
        <span class="avi-num">{{ str_pad($visitors->firstItem()+$loop->index,2,'0',STR_PAD_LEFT) }}</span>
        <div class="avi-cell">
            <div class="avi-avatar">
                @if($visitor->photo)<img src="{{ asset('storage/'.$visitor->photo) }}" alt="">@else{{ $initials }}@endif
            </div>
            <div>
                <span class="avi-name">{{ $visitor->full_name }}</span>
                <span class="avi-nid">{{ $visitor->national_id ?? '—' }}</span>
            </div>
        </div>
        <div style="font-size:12.5px;color:#475569;font-family:monospace;">{{ $visitor->national_id ?? '—' }}</div>
        <div style="font-size:13px;color:#475569;">{{ $visitor->phone_number ?? '—' }}</div>
        <div><span class="avi-vc"><i class="fas fa-clock-rotate-left" style="font-size:9px;"></i>{{ $visitor->visits_count }}</span></div>
        <div class="avi-act">
            <a href="{{ route('admin.visitors.show', $visitor) }}" class="avi-btn-v" title="View"><i class="fas fa-eye"></i></a>
            <form method="POST" action="{{ route('admin.visitors.destroy', $visitor) }}" style="margin:0;" onsubmit="return confirm('Delete this visitor and all their visits?')">
                @csrf @method('DELETE')
                <button class="avi-btn-d" title="Delete"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="avi-empty">
        <div class="avi-empty-icon"><i class="fas fa-person-walking-arrow-right"></i></div>
        <h5>No visitors found</h5>
        <p>Try a different search term.</p>
    </div>
    @endforelse

    @if($visitors->hasPages())
    <div class="avi-pag">{{ $visitors->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
