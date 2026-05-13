<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — AVMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy:#0d1b2e; --indigo:#1e3a8a; --blue:#2563eb; --blue-lt:#3b82f6;
            --white:#ffffff; --slate-100:#f1f5f9; --slate-200:#e2e8f0;
            --slate-400:#94a3b8; --slate-500:#64748b; --slate-700:#334155; --slate-900:#0f172a;
        }
        html { height: 100%; }
        body { font-family:'Inter',sans-serif; display:flex; min-height:100vh; background:#0d1b2e; overflow-x:hidden; }

        /* ── HERO LEFT ── */
        .hero-panel { flex:0 0 58%; position:relative; display:flex; flex-direction:column; overflow:hidden; }
        .slides-wrap { position:absolute; inset:0; z-index:0; }
        .slide { position:absolute; inset:0; background-size:cover; background-position:center; opacity:0; transition:opacity 1.2s ease; transform:scale(1.04); }
        .slide.active { opacity:1; animation:kenBurns 8s ease-in-out forwards; }
        @keyframes kenBurns { from{transform:scale(1.04) translate(0,0)} to{transform:scale(1.10) translate(-1.5%,.5%)} }
        .slide-overlay { position:absolute; inset:0; z-index:1;
            background: linear-gradient(to right, rgba(12,7,45,.94) 0%, rgba(22,13,78,.82) 20%, rgba(36,22,108,.62) 42%, rgba(52,36,145,.38) 65%, rgba(76,60,178,.06) 100%),
                        linear-gradient(to bottom, rgba(14,9,52,.18) 0%, rgba(6,3,22,.62) 100%); }
        .hero-topbar { position:relative; z-index:10; display:flex; align-items:center; gap:11px; padding:28px 40px; }
        .hero-logo-icon { width:40px; height:40px; background:linear-gradient(135deg,#5b21b6,#7c3aed); border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:17px; color:#fff; box-shadow:0 4px 16px rgba(124,58,237,.5); flex-shrink:0; }
        .hero-logo-text strong { display:block; font-size:14px; font-weight:800; color:#fff; letter-spacing:-.3px; }
        .hero-logo-text small { font-size:10.5px; color:rgba(255,255,255,.45); }
        .hero-body { position:relative; z-index:10; flex:1; display:flex; flex-direction:column; justify-content:flex-end; padding:0 40px 32px; }
        .hero-headline { font-family:'Manrope',sans-serif; font-size:clamp(26px,3.2vw,44px); font-weight:900; color:#fff; line-height:1.14; letter-spacing:-.5px; margin-bottom:16px; }
        .hero-headline .accent { background:linear-gradient(90deg,#38bdf8,#818cf8); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; display:block; }
        .hero-desc { font-size:14px; color:rgba(255,255,255,.65); line-height:1.72; max-width:400px; margin-bottom:28px; }

        /* Role info cards on hero */
        .role-info { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .ri-card { background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); border-radius:14px; padding:16px; }
        .ri-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:14px; margin-bottom:10px; }
        .ri-tenant .ri-icon { background:rgba(16,185,129,.25); color:#34d399; }
        .ri-guard  .ri-icon { background:rgba(59,130,246,.25); color:#60a5fa; }
        .ri-card strong { display:block; font-size:12.5px; font-weight:700; color:#fff; margin-bottom:4px; }
        .ri-card p { font-size:11.5px; color:rgba(255,255,255,.5); line-height:1.5; margin:0; }
        .ri-badge { display:inline-flex; align-items:center; gap:4px; margin-top:8px; padding:3px 9px; border-radius:20px; font-size:10.5px; font-weight:700; }
        .ri-tenant .ri-badge { background:rgba(16,185,129,.2); color:#34d399; }
        .ri-guard  .ri-badge  { background:rgba(251,191,36,.2); color:#fbbf24; }

        /* ── AUTH RIGHT ── */
        .auth-panel { flex:1; background:#fff; display:flex; align-items:center; justify-content:center; padding:32px 32px; position:relative; overflow-y:auto; }
        .auth-panel::before { content:''; position:absolute; left:0; top:10%; bottom:10%; width:1px; background:linear-gradient(to bottom,transparent,rgba(37,99,235,.15) 50%,transparent); }
        .auth-card { width:100%; max-width:380px; animation:fadeUp .6s ease both; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

        .card-logo { display:flex; align-items:center; gap:10px; margin-bottom:22px; justify-content:center; }
        .card-logo-icon { width:40px; height:40px; background:linear-gradient(135deg,#1e3a8a,#3b82f6); border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:17px; color:#fff; box-shadow:0 4px 16px rgba(37,99,235,.3); }
        .card-logo-text strong { display:block; font-size:14px; font-weight:800; color:var(--slate-900); }
        .card-logo-text small { font-size:10.5px; color:var(--slate-400); }
        .card-title { font-family:'Manrope',sans-serif; font-size:24px; font-weight:900; color:var(--slate-900); letter-spacing:-.5px; margin-bottom:4px; text-align:center; }
        .card-sub { font-size:13px; color:var(--slate-400); text-align:center; margin-bottom:22px; }

        /* ── ROLE CARDS ── */
        .role-lbl { font-size:10.5px; font-weight:700; color:var(--slate-400); text-transform:uppercase; letter-spacing:.6px; margin-bottom:8px; display:block; }
        .role-cards { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:18px; }
        .role-card { position:relative; border:2px solid var(--slate-200); border-radius:14px; padding:14px 14px 12px; cursor:pointer; transition:all .2s; text-align:center; background:#fff; }
        .role-card:hover { border-color:#bfdbfe; background:#f8faff; }
        .role-card input[type=radio] { position:absolute; opacity:0; width:0; height:0; }
        .role-card.selected { border-color:var(--blue); background:#eff6ff; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
        .rc-icon { width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:18px; margin:0 auto 10px; transition:all .2s; }
        .rc-tenant-ico { background:#d1fae5; color:#059669; }
        .rc-guard-ico  { background:#dbeafe; color:#1e40af; }
        .role-card.selected .rc-tenant-ico { background:#059669; color:#fff; }
        .role-card.selected .rc-guard-ico  { background:#1e40af; color:#fff; }
        .rc-title { font-size:13px; font-weight:700; color:var(--slate-700); display:block; margin-bottom:2px; }
        .rc-sub   { font-size:11px; color:var(--slate-400); line-height:1.4; }
        .rc-check { position:absolute; top:8px; right:8px; width:18px; height:18px; border-radius:50%; background:var(--blue); color:#fff; display:flex; align-items:center; justify-content:center; font-size:9px; opacity:0; transition:all .2s; }
        .role-card.selected .rc-check { opacity:1; }
        .rc-pending-note { display:none; align-items:center; gap:5px; margin-top:8px; padding:4px 9px; background:#fef9c3; border-radius:8px; font-size:10.5px; color:#92400e; font-weight:600; }
        .role-card.selected .rc-pending-note { display:flex; }

        /* ── FIELDS ── */
        .field-block { margin-bottom:14px; }
        .field-lbl { display:block; font-size:12px; font-weight:600; color:var(--slate-700); margin-bottom:5px; letter-spacing:.2px; }
        .field-wrap { position:relative; }
        .field-ico { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:var(--slate-400); font-size:13px; pointer-events:none; transition:color .2s; }
        .field-in { width:100%; background:var(--slate-100); border:1.5px solid var(--slate-200); border-radius:10px; padding:11px 40px 11px 38px; font-size:13.5px; font-family:'Inter',sans-serif; color:var(--slate-900); outline:none; transition:border-color .2s,box-shadow .2s,background .2s; }
        .field-in::placeholder { color:var(--slate-400); }
        .field-in:focus { border-color:var(--blue); background:#fff; box-shadow:0 0 0 3px rgba(37,99,235,.12); }
        .field-in:focus ~ .field-ico,
        .field-wrap:focus-within .field-ico { color:var(--blue); }
        .field-in.is-invalid { border-color:#ef4444; background:#fff5f5; }
        .err-msg { font-size:11.5px; color:#ef4444; margin-top:4px; display:flex; align-items:center; gap:5px; }
        .eye-btn { position:absolute; right:11px; top:50%; transform:translateY(-50%); background:none; border:none; color:var(--slate-400); cursor:pointer; padding:3px 5px; border-radius:5px; font-size:13px; transition:color .2s; }
        .eye-btn:hover { color:var(--blue); }

        /* Row for two fields side by side */
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:10px; }

        /* ── SUBMIT ── */
        .btn-submit { width:100%; padding:13px; background:linear-gradient(135deg,#2563eb,#4f46e5); border:none; border-radius:10px; font-size:14px; font-weight:700; color:#fff; cursor:pointer; letter-spacing:.2px; transition:box-shadow .3s,transform .15s,filter .2s; box-shadow:0 4px 18px rgba(37,99,235,.35); position:relative; overflow:hidden; margin-top:4px; font-family:'Inter',sans-serif; }
        .btn-submit::after { content:''; position:absolute; inset:0; background:linear-gradient(to right,transparent 0%,rgba(255,255,255,.12) 50%,transparent 100%); transform:translateX(-100%); transition:transform .5s ease; }
        .btn-submit:hover { box-shadow:0 6px 26px rgba(37,99,235,.5); transform:translateY(-1px); filter:brightness(1.05); }
        .btn-submit:hover::after { transform:translateX(100%); }
        .btn-submit:active { transform:translateY(0); }

        .signin-row { display:flex; align-items:center; justify-content:center; gap:6px; margin-top:14px; font-size:13px; color:var(--slate-500); }
        .signin-row a { color:var(--blue); font-weight:700; text-decoration:none; }
        .signin-row a:hover { text-decoration:underline; }

        .auth-footer { margin-top:14px; padding-top:12px; border-top:1px solid var(--slate-200); display:flex; align-items:center; justify-content:center; gap:7px; font-size:11px; color:var(--slate-400); }
        .auth-footer i { color:var(--blue-lt); }

        /* ── ALERT ── */
        .alert { padding:11px 14px; border-radius:10px; font-size:13px; margin-bottom:16px; display:flex; align-items:flex-start; gap:9px; }
        .alert-err { background:#fff5f5; border:1px solid #fecaca; color:#991b1b; }
        .alert-err i { color:#ef4444; flex-shrink:0; margin-top:1px; }

        /* ── RESPONSIVE ── */
        @media(max-width:1100px){ .hero-panel{flex:0 0 52%;} .role-info{grid-template-columns:1fr;} }
        @media(max-width:860px){
            body{flex-direction:column;height:auto;min-height:100vh;overflow-y:auto;}
            .hero-panel{flex:none;width:100%;height:42vw;min-height:200px;max-height:320px;}
            .hero-desc,.role-info{display:none;}
            .auth-panel{flex:1;width:100%;height:auto;overflow-y:visible;padding:28px 24px 48px;align-items:flex-start;}
            .auth-card{max-width:520px;margin:0 auto;width:100%;}
            .auth-panel::before{display:none;}
        }
        @media(max-width:580px){
            .hero-panel{height:46vw;min-height:180px;}
            .hero-topbar{padding:18px 20px;} .hero-body{padding:0 20px 20px;}
            .hero-headline{font-size:18px;}
            .auth-panel{padding:24px 18px 44px;}
            .field-row{grid-template-columns:1fr;}
        }
    </style>
</head>
<body>

<!-- ── HERO ── -->
<section class="hero-panel" id="heroPanel">
    <div class="slides-wrap" id="slidesWrap">
        <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide"        style="background-image:url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide"        style="background-image:url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide"        style="background-image:url('https://images.unsplash.com/photo-1560185008-b033106af5c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
    </div>
    <div class="slide-overlay"></div>

    <div class="hero-topbar">
        <div class="hero-logo-icon"><i class="fas fa-building"></i></div>
        <div class="hero-logo-text">
            <strong>AVMS</strong>
            <small>Apartment Visitors Management System</small>
        </div>
    </div>

    <div class="hero-body">
        <h1 class="hero-headline">
            Join the<br>
            Community<br>
            <span class="accent">Securely &amp; Easily</span>
        </h1>
        <p class="hero-desc">
            Create your account and become part of the AVMS platform. Tenants manage their visitors; security guards control access — all from one secure system.
        </p>

        <div class="role-info">
            <div class="ri-card ri-tenant">
                <div class="ri-icon"><i class="fas fa-house-user"></i></div>
                <strong>Tenant Account</strong>
                <p>Register visitors, approve arrivals, and track all activity at your apartment.</p>
                <span class="ri-badge"><i class="fas fa-check-circle"></i> Activated instantly</span>
            </div>
            <div class="ri-card ri-guard">
                <div class="ri-icon"><i class="fas fa-shield-halved"></i></div>
                <strong>Security Guard</strong>
                <p>Manage entry/exit, check in visitors, and monitor active visits at the gate.</p>
                <span class="ri-badge"><i class="fas fa-clock"></i> Requires admin approval</span>
            </div>
        </div>
    </div>
</section>

<!-- ── FORM ── -->
<aside class="auth-panel">
    <div class="auth-card">

        <div class="card-logo">
            <div class="card-logo-icon"><i class="fas fa-building"></i></div>
            <div class="card-logo-text">
                <strong>AVMS</strong>
                <small>Apartment Visitors Management System</small>
            </div>
        </div>

        <h1 class="card-title">Create Account</h1>
        <p class="card-sub">Choose your role and fill in your details below.</p>

        @if($errors->any())
        <div class="alert alert-err">
            <i class="fas fa-circle-exclamation"></i>
            <ul style="list-style:none;padding:0;margin:0;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="regForm">
            @csrf

            {{-- ── ROLE SELECTION ── --}}
            <span class="role-lbl">Select Your Role</span>
            <div class="role-cards" id="roleCards">

                <label class="role-card ri-tenant {{ old('role','tenant') === 'tenant' ? 'selected' : '' }}" id="cardTenant">
                    <input type="radio" name="role" value="tenant" {{ old('role','tenant') === 'tenant' ? 'checked' : '' }}>
                    <div class="rc-icon rc-tenant-ico"><i class="fas fa-house-user"></i></div>
                    <span class="rc-title">Tenant</span>
                    <span class="rc-sub">Apartment resident managing visitors</span>
                    <div class="rc-check"><i class="fas fa-check"></i></div>
                </label>

                <label class="role-card ri-guard {{ old('role') === 'guard' ? 'selected' : '' }}" id="cardGuard">
                    <input type="radio" name="role" value="guard" {{ old('role') === 'guard' ? 'checked' : '' }}>
                    <div class="rc-icon rc-guard-ico"><i class="fas fa-shield-halved"></i></div>
                    <span class="rc-title">Security Guard</span>
                    <span class="rc-sub">Gate officer managing access</span>
                    <div class="rc-check"><i class="fas fa-check"></i></div>
                    <div class="rc-pending-note"><i class="fas fa-clock"></i> Requires approval</div>
                </label>

            </div>

            {{-- ── NAME ── --}}
            <div class="field-block">
                <label class="field-lbl" for="name">Full Name</label>
                <div class="field-wrap">
                    <i class="fas fa-user field-ico"></i>
                    <input id="name" type="text" name="name"
                        value="{{ old('name') }}"
                        class="field-in @error('name') is-invalid @enderror"
                        placeholder="John Doe"
                        required autofocus autocomplete="name">
                </div>
                @error('name')<div class="err-msg"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
            </div>

            {{-- ── EMAIL ── --}}
            <div class="field-block">
                <label class="field-lbl" for="email">Email Address</label>
                <div class="field-wrap">
                    <i class="fas fa-envelope field-ico"></i>
                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        class="field-in @error('email') is-invalid @enderror"
                        placeholder="you@example.com"
                        required autocomplete="username">
                </div>
                @error('email')<div class="err-msg"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
            </div>

            {{-- ── PHONE + NATIONAL ID ── --}}
            <div class="field-row" id="tenantFields">
                <div class="field-block" style="margin-bottom:0;">
                    <label class="field-lbl" for="phone">Phone Number <span style="color:#ef4444;">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-phone field-ico"></i>
                        <input id="phone" type="tel" name="phone"
                            value="{{ old('phone') }}"
                            class="field-in @error('phone') is-invalid @enderror"
                            placeholder="+1 234 567 8901" required>
                    </div>
                    @error('phone')<div class="err-msg"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>
                <div class="field-block" style="margin-bottom:0;">
                    <label class="field-lbl" for="national_id">National ID <span style="color:#ef4444;">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-id-card field-ico"></i>
                        <input id="national_id" type="text" name="national_id"
                            value="{{ old('national_id') }}"
                            class="field-in @error('national_id') is-invalid @enderror"
                            placeholder="ID / Passport number" required>
                    </div>
                    @error('national_id')<div class="err-msg"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- ── GENDER (tenant only) ── --}}
            <div class="field-block" id="genderField">
                <label class="field-lbl" for="gender">Gender <span style="color:#ef4444;">*</span></label>
                <div class="field-wrap">
                    <i class="fas fa-venus-mars field-ico"></i>
                    <select id="gender" name="gender"
                        class="field-in @error('gender') is-invalid @enderror"
                        style="padding-left:38px;cursor:pointer;" required>
                        <option value="">Select…</option>
                        <option value="male"   {{ old('gender')==='male'   ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender')==='female' ? 'selected' : '' }}>Female</option>
                        <option value="other"  {{ old('gender')==='other'  ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                @error('gender')<div class="err-msg"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
            </div>

            {{-- ── PASSWORDS ── --}}
            <div class="field-row">
                <div class="field-block" style="margin-bottom:0;">
                    <label class="field-lbl" for="password">Password</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock field-ico"></i>
                        <input id="password" type="password" name="password"
                            class="field-in @error('password') is-invalid @enderror"
                            placeholder="Min 8 characters"
                            required autocomplete="new-password"
                            style="padding-right:38px;">
                        <button type="button" class="eye-btn" onclick="togglePwd('password','eye1')">
                            <i class="fas fa-eye" id="eye1"></i>
                        </button>
                    </div>
                    @error('password')<div class="err-msg"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>

                <div class="field-block" style="margin-bottom:0;">
                    <label class="field-lbl" for="password_confirmation">Confirm Password</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock field-ico"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="field-in"
                            placeholder="Repeat password"
                            required autocomplete="new-password"
                            style="padding-right:38px;">
                        <button type="button" class="eye-btn" onclick="togglePwd('password_confirmation','eye2')">
                            <i class="fas fa-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div style="margin-top:18px;">
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-user-plus" style="margin-right:8px;"></i>
                    Create Account
                </button>
            </div>
        </form>

        <div class="signin-row">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}">Sign In</a>
        </div>

        <div class="auth-footer">
            <i class="fas fa-lock"></i>
            &copy; {{ date('Y') }} AVMS &mdash; All rights reserved
        </div>

    </div>
</aside>

<script>
/* ── Slideshow ── */
const slides = document.querySelectorAll('.slide');
let current = 0;
setInterval(() => {
    slides[current].classList.remove('active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
}, 5000);

/* ── Role card selection + show/hide tenant fields ── */
function syncTenantFields(role) {
    const show = role === 'tenant';
    document.getElementById('tenantFields').style.display = show ? '' : 'none';
    document.getElementById('genderField').style.display  = show ? '' : 'none';
    ['phone','national_id','gender'].forEach(id => {
        const el = document.getElementById(id);
        if (el) show ? el.setAttribute('required','') : el.removeAttribute('required');
    });
}
document.querySelectorAll('.role-card input[type=radio]').forEach(radio => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        this.closest('.role-card').classList.add('selected');
        syncTenantFields(this.value);
    });
});
document.querySelectorAll('.role-card').forEach(card => {
    card.addEventListener('click', function () {
        const radio = this.querySelector('input[type=radio]');
        radio.checked = true;
        radio.dispatchEvent(new Event('change'));
    });
});
// Run on page load to respect old() value after validation failure
syncTenantFields(document.querySelector('.role-card input[type=radio]:checked')?.value ?? 'tenant');

/* ── Password toggle ── */
function togglePwd(inputId, iconId) {
    const inp = document.getElementById(inputId);
    const ico = document.getElementById(iconId);
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    ico.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
}

/* ── Submit loading state ── */
document.getElementById('regForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin" style="margin-right:8px"></i>Creating Account…';
    btn.disabled = true;
});
</script>
</body>
</html>
