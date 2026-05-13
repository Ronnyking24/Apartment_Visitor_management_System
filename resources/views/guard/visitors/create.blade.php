@extends('layouts.dashboard')
@section('title','Register Visitor')
@section('page-title','Check-In Terminal')

@push('styles')
<style>
/* ── REGISTER PAGE ── */
.ci-wrap {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 22px;
    align-items: start;
}
@media(max-width:991px){ .ci-wrap { grid-template-columns: 1fr; } }

/* Page header bar */
.ci-header {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a8a 100%);
    border-radius: 14px;
    padding: 20px 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
}
.ci-header::after {
    content:'';
    position:absolute;
    right:-30px;top:-30px;
    width:180px;height:180px;
    background:radial-gradient(circle,rgba(99,102,241,.2) 0%,transparent 70%);
    pointer-events:none;
}
.ci-header-title { font-size:18px;font-weight:800;color:#fff;margin:0 0 2px; }
.ci-header-sub   { font-size:12px;color:rgba(255,255,255,.45);margin:0; }
.ci-header-time  { font-size:22px;font-weight:800;color:#fff;text-align:right;font-variant-numeric:tabular-nums;letter-spacing:-0.5px; }
.ci-header-date  { font-size:11px;color:rgba(255,255,255,.4);text-align:right; }

/* Main form card */
.ci-card {
    background:#fff;
    border-radius:16px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    overflow:hidden;
}
.ci-section-head {
    display:flex;
    align-items:center;
    gap:10px;
    padding:18px 24px 14px;
    border-bottom:1px solid #f1f5f9;
}
.ci-section-icon {
    width:34px;height:34px;
    border-radius:9px;
    display:flex;align-items:center;justify-content:center;
    font-size:14px;flex-shrink:0;
}
.ci-section-label { font-size:14px;font-weight:700;color:#0f172a;margin:0; }
.ci-section-sub   { font-size:11.5px;color:#94a3b8;margin:2px 0 0; }
.ci-body { padding:22px 24px; }

/* Photo drop zone */
.ci-photo-zone {
    border:2px dashed #bfdbfe;
    border-radius:14px;
    background:#f8faff;
    padding:28px 20px;
    text-align:center;
    cursor:pointer;
    transition:all .2s;
    position:relative;
    overflow:hidden;
    margin-bottom:20px;
}
.ci-photo-zone:hover { border-color:#3b82f6;background:#eff6ff; }
.ci-photo-zone.has-photo { border-style:solid;border-color:#3b82f6;background:#eff6ff;padding:12px; }
.ci-photo-icon { font-size:32px;color:#93c5fd;margin-bottom:10px; }
.ci-photo-label { font-size:13.5px;font-weight:700;color:#3b82f6;margin-bottom:4px; }
.ci-photo-hint  { font-size:11.5px;color:#94a3b8; }
.ci-photo-preview {
    width:90px;height:90px;
    border-radius:12px;
    object-fit:cover;
    border:3px solid #3b82f6;
    display:none;
    margin:0 auto 8px;
}
.ci-photo-zone.has-photo .ci-photo-preview { display:block; }
.ci-photo-zone.has-photo .ci-photo-placeholder { display:none; }

/* Form fields */
.ci-label {
    font-size:12.5px;font-weight:600;color:#374151;
    display:flex;align-items:center;gap:5px;
    margin-bottom:6px;
}
.ci-label .req { color:#ef4444;font-size:13px; }
.ci-input {
    width:100%;
    padding:11px 14px;
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    font-size:13.5px;color:#0f172a;
    background:#fff;
    transition:border-color .2s,box-shadow .2s;
    outline:none;
    font-family:inherit;
}
.ci-input:focus { border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12); }
.ci-input.is-invalid { border-color:#ef4444; }
.ci-input.is-invalid:focus { box-shadow:0 0 0 3px rgba(239,68,68,.12); }
.ci-feedback { font-size:11.5px;color:#ef4444;margin-top:4px; }

/* Purpose cards */
.purpose-grid {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:8px;
}
@media(max-width:600px){ .purpose-grid { grid-template-columns:repeat(2,1fr); } }
.purpose-card {
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    padding:10px 8px;
    text-align:center;
    cursor:pointer;
    transition:all .18s;
    background:#fff;
    user-select:none;
}
.purpose-card:hover { border-color:#bfdbfe;background:#f0f7ff; }
.purpose-card.selected {
    border-color:#3b82f6;
    background:linear-gradient(135deg,#eff6ff,#dbeafe);
    box-shadow:0 2px 8px rgba(59,130,246,.18);
}
.purpose-card-icon {
    width:36px;height:36px;
    border-radius:9px;
    display:flex;align-items:center;justify-content:center;
    font-size:15px;
    margin:0 auto 6px;
    transition:background .18s;
}
.purpose-card-text {
    font-size:11.5px;font-weight:600;color:#374151;line-height:1.3;
}
.purpose-card.selected .purpose-card-text { color:#1d4ed8; }

/* Tenant select styled */
.ci-tenant-select {
    position:relative;
}
.ci-tenant-select::after {
    content:'\f107';
    font-family:'Font Awesome 6 Free';font-weight:900;
    position:absolute;right:14px;top:50%;transform:translateY(-50%);
    color:#94a3b8;pointer-events:none;font-size:13px;
}
.ci-tenant-select select {
    appearance:none;-webkit-appearance:none;
}

/* Info alert */
.ci-alert {
    display:flex;align-items:flex-start;gap:10px;
    background:#f0f7ff;border:1px solid #bfdbfe;
    border-radius:10px;padding:12px 14px;
    font-size:12.5px;color:#1d4ed8;
    margin-bottom:20px;
}
.ci-alert i { margin-top:1px;flex-shrink:0;font-size:13px; }

/* Right sidebar */
.ci-sidebar { display:flex;flex-direction:column;gap:16px; }

/* Visitor pass preview */
.ci-pass {
    background:#fff;
    border-radius:16px;
    border:1px solid rgba(0,0,0,.06);
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    overflow:hidden;
}
.ci-pass-header {
    background:linear-gradient(135deg,#1e3a8a,#3b82f6);
    padding:16px 18px 14px;
}
.ci-pass-tag { font-size:9px;font-weight:700;letter-spacing:1.5px;color:rgba(255,255,255,.6);text-transform:uppercase; }
.ci-pass-title { font-size:13px;font-weight:800;color:#fff;margin:3px 0 0; }
.ci-pass-body { padding:18px; }
.ci-pass-avatar {
    width:60px;height:60px;
    border-radius:14px;
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    display:flex;align-items:center;justify-content:center;
    font-size:22px;font-weight:800;color:#fff;
    margin-bottom:12px;
    overflow:hidden;
}
.ci-pass-avatar img { width:100%;height:100%;object-fit:cover;border-radius:14px; }
.ci-pass-name  { font-size:16px;font-weight:800;color:#0f172a;margin-bottom:2px;word-break:break-word; }
.ci-pass-sub   { font-size:11.5px;color:#94a3b8;margin-bottom:14px; }
.ci-pass-row {
    display:flex;align-items:center;gap:8px;
    padding:8px 0;
    border-bottom:1px solid #f1f5f9;
    font-size:12.5px;
}
.ci-pass-row:last-child { border-bottom:none; }
.ci-pass-row i { width:16px;text-align:center;color:#94a3b8;font-size:12px;flex-shrink:0; }
.ci-pass-row-val { color:#1e293b;font-weight:600; }
.ci-pass-row-empty { color:#cbd5e1; font-weight:400; font-style:italic; }

/* Action buttons */
.ci-actions {
    display:flex;gap:10px;
    padding:18px 24px;
    border-top:1px solid #f1f5f9;
    background:#fafbfc;
}
.ci-btn-cancel {
    flex:1;
    padding:11px 18px;
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    background:#fff;
    color:#64748b;
    font-size:13.5px;font-weight:600;
    text-decoration:none;
    text-align:center;
    cursor:pointer;
    transition:all .2s;
    font-family:inherit;
}
.ci-btn-cancel:hover { background:#f1f5f9;color:#0f172a;border-color:#cbd5e1; }
.ci-btn-submit {
    flex:2;
    padding:11px 18px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    color:#fff;
    font-size:13.5px;font-weight:700;
    cursor:pointer;
    transition:all .2s;
    display:flex;align-items:center;justify-content:center;gap:8px;
    box-shadow:0 4px 12px rgba(59,130,246,.35);
    font-family:inherit;
}
.ci-btn-submit:hover { background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 6px 18px rgba(59,130,246,.45);transform:translateY(-1px); }
.ci-btn-submit:active { transform:translateY(0); }

/* Dark mode */
.dark-mode .ci-card,
.dark-mode .ci-pass { background:#1e293b;border-color:rgba(255,255,255,.07); }
.dark-mode .ci-section-head,
.dark-mode .ci-actions { border-color:rgba(255,255,255,.07); }
.dark-mode .ci-actions { background:#172032; }
.dark-mode .ci-section-label,
.dark-mode .ci-pass-name { color:#f1f5f9; }
.dark-mode .ci-input { background:#0f172a;border-color:rgba(255,255,255,.1);color:#e2e8f0; }
.dark-mode .ci-input:focus { border-color:#3b82f6;background:#0f172a; }
.dark-mode .ci-photo-zone { background:#1a2644;border-color:#1e3a8a; }
.dark-mode .ci-alert { background:#1e3a5f;border-color:#1e40af;color:#93c5fd; }
.dark-mode .purpose-card { background:#0f172a;border-color:rgba(255,255,255,.08); }
.dark-mode .purpose-card:hover { background:#1e2d4a;border-color:#1e3a8a; }
.dark-mode .purpose-card.selected { background:linear-gradient(135deg,#1e3a8a,#1e40af);border-color:#3b82f6; }
.dark-mode .purpose-card-text { color:#cbd5e1; }
.dark-mode .purpose-card.selected .purpose-card-text { color:#93c5fd; }
.dark-mode .ci-label { color:#cbd5e1; }
.dark-mode .ci-pass-row { border-color:rgba(255,255,255,.07); }
.dark-mode .ci-pass-row-val { color:#e2e8f0; }
.dark-mode .ci-btn-cancel { background:#0f172a;border-color:rgba(255,255,255,.1);color:#94a3b8; }
.dark-mode .ci-btn-cancel:hover { background:#1e3a5f;color:#f1f5f9; }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="ci-header">
    <div>
        <p class="ci-header-title"><i class="fas fa-shield-halved me-2" style="color:#93c5fd;"></i>Visitor Check-In Terminal</p>
        <p class="ci-header-sub">Gate Security &mdash; Apartment Visitors Management</p>
    </div>
    <div>
        <div class="ci-header-time" id="ciClock">--:--</div>
        <div class="ci-header-date" id="ciDate"></div>
    </div>
</div>

<form method="POST" action="{{ route('guard.visitors.store') }}" enctype="multipart/form-data" id="ciForm">
@csrf
<div class="ci-wrap">

    {{-- ── LEFT: MAIN FORM ── --}}
    <div>
        {{-- VISITOR INFORMATION --}}
        <div class="ci-card mb-4">
            <div class="ci-section-head">
                <div class="ci-section-icon" style="background:#dbeafe;">
                    <i class="fas fa-id-card" style="color:#3b82f6;"></i>
                </div>
                <div>
                    <p class="ci-section-label">Visitor Information</p>
                    <p class="ci-section-sub">Personal details of the visitor</p>
                </div>
            </div>
            <div class="ci-body">

                {{-- Info note --}}
                <div class="ci-alert">
                    <i class="fas fa-circle-info"></i>
                    <span>If the visitor's National ID exists in the system, their profile will be reused automatically.</span>
                </div>

                {{-- Photo drop zone --}}
                <div class="ci-photo-zone" id="photoZone" onclick="document.getElementById('photoInput').click()">
                    <img class="ci-photo-preview" id="photoPreview" src="" alt="Preview">
                    <div class="ci-photo-placeholder">
                        <div class="ci-photo-icon"><i class="fas fa-camera"></i></div>
                        <p class="ci-photo-label">Upload Visitor Photo</p>
                        <p class="ci-photo-hint">Click to browse &mdash; JPG / PNG, max 2MB (optional)</p>
                    </div>
                    <div id="photoFileName" style="font-size:12px;color:#3b82f6;font-weight:600;display:none;margin-top:6px;"></div>
                </div>
                <input type="file" name="photo" id="photoInput" accept="image/jpeg,image/png" style="display:none;">
                @error('photo')<p class="ci-feedback">{{ $message }}</p>@enderror

                {{-- Name + Phone --}}
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="ci-label">Full Name <span class="req">*</span></label>
                        <input type="text" name="full_name" id="ciName"
                            class="ci-input @error('full_name') is-invalid @enderror"
                            value="{{ old('full_name') }}" placeholder="e.g. John Kamau" required
                            oninput="updatePreview()">
                        @error('full_name')<p class="ci-feedback">{{ $message }}</p>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="ci-label">Phone Number</label>
                        <input type="text" name="phone_number" id="ciPhone"
                            class="ci-input @error('phone_number') is-invalid @enderror"
                            value="{{ old('phone_number') }}" placeholder="+254 7XX XXX XXX"
                            oninput="updatePreview()">
                        @error('phone_number')<p class="ci-feedback">{{ $message }}</p>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="ci-label">National ID / Passport</label>
                        <input type="text" name="national_id" id="ciNid"
                            class="ci-input @error('national_id') is-invalid @enderror"
                            value="{{ old('national_id') }}" placeholder="e.g. 12345678"
                            oninput="updatePreview()">
                        @error('national_id')<p class="ci-feedback">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- VISIT DETAILS --}}
        <div class="ci-card">
            <div class="ci-section-head">
                <div class="ci-section-icon" style="background:#dcfce7;">
                    <i class="fas fa-clipboard-check" style="color:#16a34a;"></i>
                </div>
                <div>
                    <p class="ci-section-label">Visit Details</p>
                    <p class="ci-section-sub">Who they're visiting and why</p>
                </div>
            </div>
            <div class="ci-body">

                {{-- Tenant select --}}
                <div style="margin-bottom:20px;">
                    <label class="ci-label">Tenant Being Visited <span class="req">*</span></label>
                    <div class="ci-tenant-select">
                        <select name="tenant_id" id="ciTenant"
                            class="ci-input @error('tenant_id') is-invalid @enderror"
                            required onchange="updatePreview()">
                            <option value="">Select tenant…</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}"
                                    data-apt="{{ $tenant->apartment->apartment_number ?? 'N/A' }}"
                                    {{ old('tenant_id')==$tenant->id?'selected':'' }}>
                                    {{ $tenant->user->name }} — Apt {{ $tenant->apartment->apartment_number ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('tenant_id')<p class="ci-feedback">{{ $message }}</p>@enderror
                </div>

                {{-- Purpose cards --}}
                <label class="ci-label" style="margin-bottom:10px;">Purpose of Visit <span class="req">*</span></label>
                <input type="hidden" name="purpose" id="purposeInput" value="{{ old('purpose') }}" required>
                @error('purpose')<p class="ci-feedback" style="margin-bottom:8px;">{{ $message }}</p>@enderror

                <div class="purpose-grid">
                    @php
                    $purposes = [
                        ['value'=>'Family visit',     'icon'=>'fa-house-user',    'color'=>'#3b82f6', 'bg'=>'#dbeafe'],
                        ['value'=>'Delivery',         'icon'=>'fa-box',           'color'=>'#f59e0b', 'bg'=>'#fef9c3'],
                        ['value'=>'Business meeting', 'icon'=>'fa-briefcase',     'color'=>'#8b5cf6', 'bg'=>'#ede9fe'],
                        ['value'=>'Maintenance',      'icon'=>'fa-screwdriver-wrench','color'=>'#10b981','bg'=>'#dcfce7'],
                        ['value'=>'Social visit',     'icon'=>'fa-people-group',  'color'=>'#ec4899', 'bg'=>'#fce7f3'],
                        ['value'=>'Other',            'icon'=>'fa-ellipsis',      'color'=>'#64748b', 'bg'=>'#f1f5f9'],
                    ];
                    @endphp
                    @foreach($purposes as $p)
                    <div class="purpose-card {{ old('purpose')==$p['value'] ? 'selected' : '' }}"
                         data-value="{{ $p['value'] }}"
                         onclick="selectPurpose(this)">
                        <div class="purpose-card-icon" style="background:{{ $p['bg'] }};">
                            <i class="fas {{ $p['icon'] }}" style="color:{{ $p['color'] }};"></i>
                        </div>
                        <div class="purpose-card-text">{{ $p['value'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Actions --}}
            <div class="ci-actions">
                <a href="{{ route('guard.dashboard') }}" class="ci-btn-cancel">
                    <i class="fas fa-arrow-left me-1"></i> Cancel
                </a>
                <button type="submit" class="ci-btn-submit">
                    <i class="fas fa-right-to-bracket"></i>
                    Check In Visitor
                </button>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: SIDEBAR ── --}}
    <div class="ci-sidebar">

        {{-- Live visitor pass preview --}}
        <div class="ci-pass">
            <div class="ci-pass-header">
                <p class="ci-pass-tag">Live Preview</p>
                <p class="ci-pass-title">Visitor Entry Pass</p>
            </div>
            <div class="ci-pass-body">
                <div class="ci-pass-avatar" id="passAvatar">
                    <span id="passInitial">?</span>
                    <img id="passPhoto" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:14px;">
                </div>
                <div class="ci-pass-name" id="passName">Visitor Name</div>
                <div class="ci-pass-sub" id="passPhone">No phone provided</div>

                <div class="ci-pass-row">
                    <i class="fas fa-id-card"></i>
                    <span id="passNid" class="ci-pass-row-empty">National ID not entered</span>
                </div>
                <div class="ci-pass-row">
                    <i class="fas fa-building"></i>
                    <span id="passApt" class="ci-pass-row-empty">Tenant not selected</span>
                </div>
                <div class="ci-pass-row">
                    <i class="fas fa-tag"></i>
                    <span id="passPurpose" class="ci-pass-row-empty">Purpose not selected</span>
                </div>
                <div class="ci-pass-row">
                    <i class="fas fa-clock"></i>
                    <span class="ci-pass-row-val" id="passTime">--:--</span>
                </div>
            </div>
        </div>

        {{-- Quick tips --}}
        <div class="ci-card">
            <div class="ci-body" style="padding:16px 18px;">
                <p style="font-size:12px;font-weight:700;color:#0f172a;margin:0 0 10px;text-transform:uppercase;letter-spacing:.4px;">Quick Tips</p>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;gap:8px;font-size:12px;color:#64748b;">
                        <i class="fas fa-circle-check" style="color:#10b981;margin-top:1px;flex-shrink:0;"></i>
                        <span>Returning visitors are matched by <strong style="color:#374151;">National ID</strong></span>
                    </div>
                    <div style="display:flex;gap:8px;font-size:12px;color:#64748b;">
                        <i class="fas fa-circle-check" style="color:#10b981;margin-top:1px;flex-shrink:0;"></i>
                        <span>Photo is optional but helps with identification</span>
                    </div>
                    <div style="display:flex;gap:8px;font-size:12px;color:#64748b;">
                        <i class="fas fa-circle-check" style="color:#10b981;margin-top:1px;flex-shrink:0;"></i>
                        <span>Status is set to <strong style="color:#374151;">Inside</strong> automatically on check-in</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@endsection

@push('scripts')
<script>
(function () {
    /* Clock */
    function tick() {
        const now = new Date();
        const pad = n => String(n).padStart(2,'0');
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const days   = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        const el = document.getElementById('ciClock');
        const de = document.getElementById('ciDate');
        const pt = document.getElementById('passTime');
        if(el) el.textContent = pad(now.getHours())+':'+pad(now.getMinutes());
        if(de) de.textContent = days[now.getDay()]+' '+months[now.getMonth()]+' '+now.getDate()+', '+now.getFullYear();
        if(pt) pt.textContent = pad(now.getHours())+':'+pad(now.getMinutes())+':'+pad(now.getSeconds());
    }
    tick(); setInterval(tick,1000);

    /* Photo upload */
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            const zone    = document.getElementById('photoZone');
            const preview = document.getElementById('photoPreview');
            const passP   = document.getElementById('passPhoto');
            const passI   = document.getElementById('passInitial');
            const fname   = document.getElementById('photoFileName');

            preview.src = ev.target.result;
            passP.src   = ev.target.result;
            passP.style.display = 'block';
            passI.style.display = 'none';
            zone.classList.add('has-photo');
            fname.textContent = file.name;
            fname.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });

    /* Drag & drop */
    const zone = document.getElementById('photoZone');
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.style.borderColor='#3b82f6'; });
    zone.addEventListener('dragleave', () => { zone.style.borderColor=''; });
    zone.addEventListener('drop', e => {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (file && file.type.match(/image\/(jpeg|png)/)) {
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('photoInput').files = dt.files;
            document.getElementById('photoInput').dispatchEvent(new Event('change'));
        }
    });
})();

/* Purpose selection */
function selectPurpose(card) {
    document.querySelectorAll('.purpose-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    const val = card.dataset.value;
    document.getElementById('purposeInput').value = val;
    const el = document.getElementById('passPurpose');
    el.textContent = val;
    el.className = 'ci-pass-row-val';
}

/* Pre-select old value on page load */
(function() {
    const old = document.getElementById('purposeInput').value;
    if(old) {
        const card = document.querySelector(`.purpose-card[data-value="${old}"]`);
        if(card) card.classList.add('selected');
    }
})();

/* Live preview updater */
function updatePreview() {
    const name  = document.getElementById('ciName').value.trim();
    const phone = document.getElementById('ciPhone').value.trim();
    const nid   = document.getElementById('ciNid').value.trim();
    const sel   = document.getElementById('ciTenant');
    const opt   = sel.options[sel.selectedIndex];

    /* Name & initial */
    const nameEl = document.getElementById('passName');
    const initEl = document.getElementById('passInitial');
    nameEl.textContent = name || 'Visitor Name';
    initEl.textContent = name ? name.charAt(0).toUpperCase() : '?';

    /* Phone */
    const phEl = document.getElementById('passPhone');
    phEl.textContent = phone || 'No phone provided';

    /* NID */
    const nidEl = document.getElementById('passNid');
    if(nid) { nidEl.textContent = nid; nidEl.className='ci-pass-row-val'; }
    else     { nidEl.textContent='National ID not entered'; nidEl.className='ci-pass-row-empty'; }

    /* Tenant / Apt */
    const aptEl = document.getElementById('passApt');
    if(opt && opt.value) { aptEl.textContent = opt.text; aptEl.className='ci-pass-row-val'; }
    else                 { aptEl.textContent='Tenant not selected'; aptEl.className='ci-pass-row-empty'; }
}
</script>
@endpush
