@extends('layouts.dashboard')
@section('title','Edit Guard')
@section('page-title','Edit Guard')

@push('styles')
<style>
.ef-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.ef-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.ef-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.ef-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.ef-back { display:inline-flex; align-items:center; gap:7px; padding:8px 16px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); color:#fff; border-radius:10px; font-size:12.5px; font-weight:600; text-decoration:none; transition:all .2s; }
.ef-back:hover { background:rgba(255,255,255,.2); color:#fff; }
.ef-status-chip { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:20px; font-size:11.5px; font-weight:700; }
.ef-status-active    { background:rgba(134,239,172,.2); color:#86efac; }
.ef-status-pending   { background:rgba(253,224,71,.2);  color:#fde047; }
.ef-status-suspended { background:rgba(252,165,165,.2); color:#fca5a5; }
.ef-card { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; }
.ef-sec-title { font-size:10.5px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; padding:16px 24px 10px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
.ef-sec-title i { color:#1e3a8a; font-size:12px; }
.ef-body { padding:20px 24px 8px; }
.ef-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
.ef-field { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
.ef-lbl { font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.5px; }
.ef-lbl .req { color:#ef4444; }
.ef-lbl .opt { color:#94a3b8; font-weight:400; text-transform:none; letter-spacing:0; font-size:10.5px; }
.ef-wrap { position:relative; }
.ef-ico { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.ef-eye { position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px; cursor:pointer; background:none; border:none; padding:0; }
.ef-in { width:100%; padding:10px 36px 10px 36px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; font-family:inherit; outline:none; background:#fff; transition:border-color .2s,box-shadow .2s; box-sizing:border-box; }
.ef-in.no-eye { padding-right:13px; }
.ef-in:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.ef-in.is-invalid { border-color:#ef4444; }
.ef-err { font-size:11.5px; color:#ef4444; display:flex; align-items:center; gap:5px; margin-top:2px; }
.ef-hint { font-size:11px; color:#94a3b8; display:flex; align-items:center; gap:4px; margin-top:2px; }
.ef-footer { display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 24px; border-top:1px solid #f1f5f9; background:#fafbfc; }
.ef-btn-cancel { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; transition:all .2s; }
.ef-btn-cancel:hover { background:#e2e8f0; color:#0f172a; }
.ef-btn-save { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:all .2s; }
.ef-btn-save:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 4px 14px rgba(30,58,138,.3); }
@media(max-width:640px){ .ef-grid-2 { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div style="max-width:700px;margin:0 auto;">

{{-- HEADER --}}
<div class="ef-header">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;color:#fff;flex-shrink:0;">
            @php $p=explode(' ',trim($guard->name));echo strtoupper(substr($p[0],0,1)).(isset($p[1])?strtoupper(substr($p[1],0,1)):''); @endphp
        </div>
        <div>
            <h2><i class="fas fa-shield-halved me-2" style="color:#93c5fd;font-size:14px;"></i>Edit Guard</h2>
            <p style="display:flex;align-items:center;gap:8px;">
                {{ $guard->email }}
                <span class="ef-status-chip ef-status-{{ $guard->status ?? 'active' }}">
                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                    {{ ucfirst($guard->status ?? 'active') }}
                </span>
            </p>
        </div>
    </div>
    <a href="{{ route('admin.guards.index') }}" class="ef-back">
        <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back
    </a>
</div>

@if($errors->any())
<div style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;padding:12px 18px;margin-bottom:18px;display:flex;align-items:center;gap:10px;font-size:13px;color:#dc2626;">
    <i class="fas fa-circle-exclamation"></i> Please fix the errors below before saving.
</div>
@endif

<form method="POST" action="{{ route('admin.guards.update', $guard) }}">
@csrf @method('PUT')
<div class="ef-card">

    {{-- SECTION: Account --}}
    <div class="ef-sec-title"><i class="fas fa-circle-user"></i> Account Details</div>
    <div class="ef-body">
        <div class="ef-grid-2">
            <div class="ef-field">
                <label class="ef-lbl" for="name">Full Name <span class="req">*</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-user ef-ico"></i>
                    <input id="name" type="text" name="name"
                        value="{{ old('name', $guard->name) }}"
                        class="ef-in no-eye @error('name') is-invalid @enderror"
                        placeholder="Full name" required>
                </div>
                @error('name')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="email">Email Address <span class="req">*</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-envelope ef-ico"></i>
                    <input id="email" type="email" name="email"
                        value="{{ old('email', $guard->email) }}"
                        class="ef-in no-eye @error('email') is-invalid @enderror"
                        placeholder="email@example.com" required>
                </div>
                @error('email')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- SECTION: Security --}}
    <div class="ef-sec-title"><i class="fas fa-lock"></i> Security</div>
    <div class="ef-body">
        <div class="ef-grid-2">
            <div class="ef-field">
                <label class="ef-lbl" for="password">New Password <span class="opt">(leave blank to keep)</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-lock ef-ico"></i>
                    <input id="password" type="password" name="password"
                        class="ef-in @error('password') is-invalid @enderror"
                        placeholder="Min 8 characters">
                    <button type="button" class="ef-eye" onclick="togglePwd('password','eyeP')"><i id="eyeP" class="fas fa-eye"></i></button>
                </div>
                @error('password')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
                <div class="ef-hint"><i class="fas fa-circle-info" style="font-size:9px;"></i> Only fill in if you want to change the password.</div>
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="password_confirmation">Confirm Password</label>
                <div class="ef-wrap">
                    <i class="fas fa-lock ef-ico"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="ef-in" placeholder="Repeat new password">
                    <button type="button" class="ef-eye" onclick="togglePwd('password_confirmation','eyePC')"><i id="eyePC" class="fas fa-eye"></i></button>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="ef-footer">
        <a href="{{ route('admin.guards.index') }}" class="ef-btn-cancel">
            <i class="fas fa-xmark" style="font-size:11px;"></i> Cancel
        </a>
        <button type="submit" class="ef-btn-save">
            <i class="fas fa-floppy-disk" style="font-size:12px;"></i> Save Changes
        </button>
    </div>
</div>
</form>

</div>

@push('scripts')
<script>
function togglePwd(id, iconId) {
    const inp = document.getElementById(id);
    const ico = document.getElementById(iconId);
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    ico.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
}
</script>
@endpush

@endsection
