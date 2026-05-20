@extends('layouts.dashboard')
@section('title','Edit Resident')
@section('page-title','Edit Resident')

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
.ef-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
.ef-field { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
.ef-lbl { font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.5px; }
.ef-lbl .req { color:#ef4444; }
.ef-lbl .opt { color:#94a3b8; font-weight:400; text-transform:none; letter-spacing:0; font-size:10.5px; }
.ef-wrap { position:relative; }
.ef-ico { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }
.ef-eye { position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px; cursor:pointer; background:none; border:none; padding:0; }
.ef-in { width:100%; padding:10px 36px 10px 36px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; color:#0f172a; font-family:inherit; outline:none; background:#fff; transition:border-color .2s,box-shadow .2s; box-sizing:border-box; }
.ef-in.no-ico { padding-left:13px; }
.ef-in.no-eye { padding-right:13px; }
.ef-in:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); }
.ef-in.is-invalid { border-color:#ef4444; }
.ef-err { font-size:11.5px; color:#ef4444; display:flex; align-items:center; gap:5px; margin-top:2px; }
select.ef-in { cursor:pointer; }
.ef-apt-unassigned { background:#fef3c7; color:#92400e; font-size:11.5px; font-weight:700; padding:6px 12px; border-radius:8px; display:inline-flex; align-items:center; gap:6px; margin-bottom:6px; }
.ef-footer { display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 24px; border-top:1px solid #f1f5f9; background:#fafbfc; }
.ef-btn-cancel { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; background:#f1f5f9; color:#64748b; border:1.5px solid #e2e8f0; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none; transition:all .2s; }
.ef-btn-cancel:hover { background:#e2e8f0; color:#0f172a; }
.ef-btn-save { display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:linear-gradient(135deg,#1e3a8a,#1d4ed8); color:#fff; border:none; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:all .2s; }
.ef-btn-save:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 4px 14px rgba(30,58,138,.3); }
@media(max-width:640px){ .ef-grid-2 { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div style="max-width:820px;margin:0 auto;">

{{-- HEADER --}}
<div class="ef-header">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;color:#fff;flex-shrink:0;">
            @php $parts=explode(' ',trim($tenant->user->name));echo strtoupper(substr($parts[0],0,1)).(isset($parts[1])?strtoupper(substr($parts[1],0,1)):''); @endphp
        </div>
        <div>
            <h2><i class="fas fa-user-pen me-2" style="color:#93c5fd;font-size:14px;"></i>Edit Resident</h2>
            <p>{{ $tenant->user->name }} &mdash; {{ $tenant->user->email }}
                @if($tenant->apartment)
                    &mdash; <span style="color:#86efac;font-weight:700;">{{ $tenant->apartment_display }}</span>
                @else
                    &mdash; <span style="color:#fde68a;font-weight:700;">No apartment assigned</span>
                @endif
            </p>
        </div>
    </div>
    <a href="{{ route('admin.tenants.index') }}" class="ef-back">
        <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back
    </a>
</div>

@if($errors->any())
<div style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;padding:12px 18px;margin-bottom:18px;display:flex;align-items:center;gap:10px;font-size:13px;color:#dc2626;">
    <i class="fas fa-circle-exclamation"></i> Please fix the errors below before saving.
</div>
@endif

<form method="POST" action="{{ route('admin.tenants.update', $tenant) }}">
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
                        value="{{ old('name', $tenant->user->name) }}"
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
                        value="{{ old('email', $tenant->user->email) }}"
                        class="ef-in no-eye @error('email') is-invalid @enderror"
                        placeholder="email@example.com" required>
                </div>
                @error('email')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
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
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="password_confirmation">Confirm Password</label>
                <div class="ef-wrap">
                    <i class="fas fa-lock ef-ico"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="ef-in @error('password_confirmation') is-invalid @enderror"
                        placeholder="Repeat password">
                    <button type="button" class="ef-eye" onclick="togglePwd('password_confirmation','eyePC')"><i id="eyePC" class="fas fa-eye"></i></button>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: Resident Profile --}}
    <div class="ef-sec-title"><i class="fas fa-id-badge"></i> Resident Profile</div>
    <div class="ef-body">
        @if(!$tenant->apartment_id)
        <div class="ef-apt-unassigned"><i class="fas fa-triangle-exclamation" style="font-size:10px;"></i> No apartment currently assigned — select one below to assign.</div>
        @endif
        <div class="ef-grid-2">
            <div class="ef-field">
                <label class="ef-lbl" for="apartment_id">Apartment</label>
                <div class="ef-wrap">
                    <i class="fas fa-building ef-ico"></i>
                    <select id="apartment_id" name="apartment_id" class="ef-in no-eye @error('apartment_id') is-invalid @enderror">
                        <option value="">— Not assigned yet —</option>
                        @foreach($apartments as $apt)
                            <option value="{{ $apt->id }}" {{ old('apartment_id', $tenant->apartment_id)==$apt->id?'selected':'' }}>
                                {{ $apt->apartment_number }} — {{ $apt->block_name }}@if($apt->id === $tenant->apartment_id) (current)@endif
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('apartment_id')<div class="ef-err"><i class="fas fa-circle-exclamation" style="font-size:10px;"></i>{{ $message }}</div>@enderror
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="phone">Phone Number <span class="opt">(optional)</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-phone ef-ico"></i>
                    <input id="phone" type="text" name="phone"
                        value="{{ old('phone', $tenant->phone) }}"
                        class="ef-in no-eye" placeholder="+1 234 567 8901">
                </div>
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="national_id">National ID <span class="opt">(optional)</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-id-card ef-ico"></i>
                    <input id="national_id" type="text" name="national_id"
                        value="{{ old('national_id', $tenant->national_id) }}"
                        class="ef-in no-eye" placeholder="ID / Passport number">
                </div>
            </div>
            <div class="ef-field">
                <label class="ef-lbl" for="gender">Gender <span class="opt">(optional)</span></label>
                <div class="ef-wrap">
                    <i class="fas fa-venus-mars ef-ico"></i>
                    <select id="gender" name="gender" class="ef-in no-eye">
                        <option value="">Select…</option>
                        <option value="male"   {{ old('gender', $tenant->gender)==='male'  ?'selected':'' }}>Male</option>
                        <option value="female" {{ old('gender', $tenant->gender)==='female'?'selected':'' }}>Female</option>
                        <option value="other"  {{ old('gender', $tenant->gender)==='other' ?'selected':'' }}>Other</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="ef-footer">
        <a href="{{ route('admin.tenants.index') }}" class="ef-btn-cancel">
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
