@extends('layouts.dashboard')
@section('title','Add Guard')
@section('page-title','Add Guard')

@push('styles')
<style>
.gc-header { background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%); border-radius:14px; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:22px; position:relative; overflow:hidden; }
.gc-header::after { content:''; position:absolute; right:-20px; top:-20px; width:160px; height:160px; background:radial-gradient(circle,rgba(99,102,241,.15) 0%,transparent 70%); pointer-events:none; }
.gc-header h2 { font-size:17px; font-weight:800; color:#fff; margin:0 0 3px; }
.gc-header p  { font-size:12px; color:rgba(255,255,255,.45); margin:0; }
.gc-back { display:inline-flex; align-items:center; gap:7px; padding:8px 16px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); color:#fff; border-radius:10px; font-size:12.5px; font-weight:600; text-decoration:none; transition:all .2s; }
.gc-back:hover { background:rgba(255,255,255,.2); color:#fff; }
.gc-card { background:#fff; border-radius:16px; border:1px solid #e8ecf1; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; }
.gc-sec-title { font-size:10.5px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:.7px; padding:16px 24px 10px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
.gc-sec-title i { color:#1e3a8a; font-size:12px; }
.gc-body { padding:20px 24px 8px; }
.gc-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
.gc-field { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
.gc-lbl { font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.5px; }
.gc-lbl .req { color:#ef4444; }
.gc-wrap { position:relative; }
.gc-ico { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.gc-eye { position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px; cursor:pointer; background:none; border:none; padding:0; }
.gc-in { width:100%; padding:10px 36px 10px 36px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; font-family:inherit; outline:none; background:#fff; transition:border-color .2s,box-shadow .2s; box-sizing:border-box; }
.gc-in.no-eye { padding-right:13px; }
.gc-in:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.gc-in.is-invalid { border-color:#ef4444; }
.gc-err { font-size:11.5px; color:#ef4444; display:flex; align-items:center; gap:5px; margin-top:2px; }
.gc-hint { font-size:11px; color:#94a3b8; display:flex; align-items:center; gap:4px; margin-top:2px; }
.gc-footer { display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 24px; border-top:1px solid #f1f5f9; background:#fafbfc; }
.gc-btn-cancel { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; transition:all .2s; }
.gc-btn-cancel:hover { background:#e2e8f0; color:#0f172a; }
.gc-btn-save { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:all .2s; }
.gc-btn-save:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 4px 14px rgba(30,58,138,.3); }
@media(max-width:640px){ .gc-grid-2 { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div style="max-width:700px;margin:0 auto;">

{{-- HEADER --}}
<div class="gc-header">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:18px;color:#93c5fd;flex-shrink:0;">
            <i class="fas fa-shield-halved"></i>
        </div>
        <div>
            <h2>Add Security Guard</h2>
            <p>Create a new guard account — requires admin approval before login</p>
        </div>
    </div>
    <a href="{{ route('admin.guards.index') }}" class="gc-back">
        <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back
    </a>
</div>

@if($errors->any())
<div style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;padding:12px 18px;margin-bottom:18px;display:flex;align-items:center;gap:10px;font-size:13px;color:#dc2626;">
    <i class="fas fa-circle-exclamation"></i> Please fix the errors below before saving.
</div>
@endif

<form method="POST" action="{{ route('admin.guards.store') }}">
@csrf
<div class="gc-card">

    {{-- SECTION: Account --}}
    <div class="gc-sec-title"><i class="fas fa-circle-user"></i> Account Details</div>
    <div class="gc-body">
        <div class="gc-grid-2">
            <div class="gc-field">
                <label class="gc-lbl" for="name">Full Name <span class="req">*</span></label>
                <div class="gc-wrap">
                    <i class="fas fa-user gc-ico"></i>
                    <input id="name" type="text" name="name"
                        value="{{ old('name') }}"
                        class="gc-in no-eye @error('name') is-invalid @enderror"
                        placeholder="Full name" required autofocus>
                </div>
                @error('name')<div class="gc-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
            <div class="gc-field">
                <label class="gc-lbl" for="email">Email Address <span class="req">*</span></label>
                <div class="gc-wrap">
                    <i class="fas fa-envelope gc-ico"></i>
                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        class="gc-in no-eye @error('email') is-invalid @enderror"
                        placeholder="email@example.com" required>
                </div>
                @error('email')<div class="gc-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- SECTION: Security --}}
    <div class="gc-sec-title"><i class="fas fa-lock"></i> Security</div>
    <div class="gc-body">
        <div class="gc-grid-2">
            <div class="gc-field">
                <label class="gc-lbl" for="password">Password <span class="req">*</span></label>
                <div class="gc-wrap">
                    <i class="fas fa-lock gc-ico"></i>
                    <input id="password" type="password" name="password"
                        class="gc-in @error('password') is-invalid @enderror"
                        placeholder="Min 8 characters" required>
                    <button type="button" class="gc-eye" onclick="togglePwd('password','eyeP')"><i id="eyeP" class="fas fa-eye"></i></button>
                </div>
                @error('password')<div class="gc-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
            <div class="gc-field">
                <label class="gc-lbl" for="password_confirmation">Confirm Password <span class="req">*</span></label>
                <div class="gc-wrap">
                    <i class="fas fa-lock gc-ico"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="gc-in" placeholder="Repeat password" required>
                    <button type="button" class="gc-eye" onclick="togglePwd('password_confirmation','eyePC')"><i id="eyePC" class="fas fa-eye"></i></button>
                </div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:9px;margin-bottom:8px;font-size:12px;color:#1e40af;">
            <i class="fas fa-circle-info" style="font-size:11px;flex-shrink:0;"></i>
            This account will be <strong style="margin:0 2px;">pending</strong> until an administrator approves it.
        </div>
    </div>

    {{-- Footer --}}
    <div class="gc-footer">
        <a href="{{ route('admin.guards.index') }}" class="gc-btn-cancel">
            <i class="fas fa-xmark" style="font-size:11px;"></i> Cancel
        </a>
        <button type="submit" class="gc-btn-save">
            <i class="fas fa-shield-halved" style="font-size:12px;"></i> Create Guard
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
