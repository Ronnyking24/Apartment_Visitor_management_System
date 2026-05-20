@extends('layouts.dashboard')
@section('title','Edit Apartment')
@section('page-title','Edit Apartment')

@push('styles')
<style>
.ef-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.ef-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.ef-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.ef-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.ef-back { display:inline-flex; align-items:center; gap:7px; padding:8px 16px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); color:#fff; border-radius:10px; font-size:12.5px; font-weight:600; text-decoration:none; transition:all .2s; }
.ef-back:hover { background:rgba(255,255,255,.2); color:#fff; }
.ef-card { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; }
.ef-sec-title { font-size:10.5px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; padding:16px 24px 10px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
.ef-sec-title i { color:#1e3a8a; font-size:12px; }
.ef-body { padding:20px 24px 8px; }
.ef-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:12px; }
.ef-field { display:flex; flex-direction:column; gap:6px; margin-bottom:12px; }
.ef-lbl { font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.5px; }
.ef-lbl .req { color:#ef4444; }
.ef-wrap { position:relative; }
.ef-ico { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.ef-in { width:100%; padding:10px 13px 10px 36px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; font-family:inherit; outline:none; background:#fff; transition:border-color .2s,box-shadow .2s; box-sizing:border-box; }
.ef-in.no-ico { padding-left:13px; }
.ef-in:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.ef-in.is-invalid { border-color:#ef4444; }
.ef-err { font-size:11.5px; color:#ef4444; display:flex; align-items:center; gap:5px; margin-top:2px; }
select.ef-in,textarea.ef-in { cursor:pointer; }
textarea.ef-in { resize:vertical; min-height:88px; padding-top:10px; line-height:1.6; }
.ef-footer { display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 24px; border-top:1px solid #f1f5f9; background:#fafbfc; }
.ef-btn-cancel { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; transition:all .2s; }
.ef-btn-cancel:hover { background:#e2e8f0; color:#0f172a; }
.ef-btn-save { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:all .2s; }
.ef-btn-save:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 4px 14px rgba(30,58,138,.3); }
.ef-status-vacant  { color:#16a34a; } .ef-status-occupied { color:#dc2626; }
@media(max-width:640px){ .ef-grid-2 { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div style="max-width:700px;margin:0 auto;">

{{-- HEADER --}}
<div class="ef-header">
    <div>
        <h2><i class="fas fa-building me-2" style="color:#93c5fd;font-size:15px;"></i>Edit Apartment</h2>
        <p>
            <span style="background:rgba(255,255,255,.12);padding:2px 10px;border-radius:6px;font-size:11.5px;font-weight:700;color:#fff;">{{ $apartment->apartment_number }}</span>
            &nbsp;{{ $apartment->block_name }} &mdash; Floor {{ $apartment->floor_number }}
            &mdash; <span class="ef-status-{{ $apartment->status }}" style="font-weight:700;">{{ ucfirst($apartment->status) }}</span>
        </p>
    </div>
    <a href="{{ route('admin.apartments.index') }}" class="ef-back">
        <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back
    </a>
</div>

@if($errors->any())
<div style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;padding:12px 18px;margin-bottom:18px;display:flex;align-items:center;gap:10px;font-size:13px;color:#dc2626;">
    <i class="fas fa-circle-exclamation"></i>
    <span>Please fix the errors below before saving.</span>
</div>
@endif

<form method="POST" action="{{ route('admin.apartments.update', $apartment) }}">
@csrf @method('PUT')
<div class="ef-card">

    {{-- Section: Details --}}
    <div class="ef-sec-title"><i class="fas fa-building"></i> Apartment Details</div>
    <div class="ef-body">
        <div class="ef-grid-2">
            <div class="ef-field">
                <label class="ef-lbl" for="apartment_number">Apartment No. <span class="req">*</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-hashtag ef-ico"></i>
                    <input id="apartment_number" type="text" name="apartment_number"
                        value="{{ old('apartment_number', $apartment->apartment_number) }}"
                        class="ef-in @error('apartment_number') is-invalid @enderror"
                        placeholder="e.g. A-101" required>
                </div>
                @error('apartment_number')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="block_name">Block Name <span class="req">*</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-layer-group ef-ico"></i>
                    <input id="block_name" type="text" name="block_name"
                        value="{{ old('block_name', $apartment->block_name) }}"
                        class="ef-in @error('block_name') is-invalid @enderror"
                        placeholder="e.g. Block A" required>
                </div>
                @error('block_name')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="floor_number">Floor Number <span class="req">*</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-stairs ef-ico"></i>
                    <input id="floor_number" type="number" name="floor_number" min="0"
                        value="{{ old('floor_number', $apartment->floor_number) }}"
                        class="ef-in @error('floor_number') is-invalid @enderror"
                        placeholder="0" required>
                </div>
                @error('floor_number')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="status">Status <span class="req">*</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-circle-dot ef-ico"></i>
                    <select id="status" name="status" class="ef-in @error('status') is-invalid @enderror" required>
                        <option value="vacant"   {{ old('status', $apartment->status)==='vacant'  ?'selected':'' }}>Vacant</option>
                        <option value="occupied" {{ old('status', $apartment->status)==='occupied'?'selected':'' }}>Occupied</option>
                    </select>
                </div>
                @error('status')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="ef-footer">
        <a href="{{ route('admin.apartments.index') }}" class="ef-btn-cancel">
            <i class="fas fa-xmark" style="font-size:11px;"></i> Cancel
        </a>
        <button type="submit" class="ef-btn-save">
            <i class="fas fa-floppy-disk" style="font-size:12px;"></i> Save Changes
        </button>
    </div>
</div>
</form>

</div>
@endsection
