<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — AVMS | Apartment Visitors Management System</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Preload slideshow images -->
    <link rel="preload" as="image" href="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1600&q=85">
    <link rel="preload" as="image" href="https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=1600&q=85">
    <link rel="preload" as="image" href="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1600&q=85">
    <link rel="preload" as="image" href="https://images.unsplash.com/photo-1560185008-b033106af5c3?w=1600&q=85">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:     #0d1b2e;
            --indigo:   #1e3a8a;
            --blue:     #2563eb;
            --blue-lt:  #3b82f6;
            --blue-glow:rgba(37,99,235,.45);
            --white:    #ffffff;
            --off-white:#f7f8fc;
            --slate-100:#f1f5f9;
            --slate-200:#e2e8f0;
            --slate-400:#94a3b8;
            --slate-500:#64748b;
            --slate-700:#334155;
            --slate-900:#0f172a;
        }

        html { height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            min-height: 100vh;
            height: 100vh;
            background: #0d1b2e;
            overflow: hidden;
        }

        /* ═══════════════════════════════
           HERO / SLIDESHOW — LEFT PANEL
        ═══════════════════════════════ */
        .hero-panel {
            flex: 0 0 62%;
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Slides */
        .slides-wrap {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.2s ease;
            transform: scale(1.04);
            animation: none;
        }
        .slide.active {
            opacity: 1;
            animation: kenBurns 8s ease-in-out forwards;
        }
        @keyframes kenBurns {
            from { transform: scale(1.04) translate(0, 0); }
            to   { transform: scale(1.10) translate(-1.5%, 0.5%); }
        }
        .slide:nth-child(even).active {
            animation: kenBurns2 8s ease-in-out forwards;
        }
        @keyframes kenBurns2 {
            from { transform: scale(1.04) translate(0, 0); }
            to   { transform: scale(1.10) translate(1.5%, -0.5%); }
        }

        /* Gradient overlay — purple/indigo left-to-right like screenshot */
        .slide-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background:
                linear-gradient(to right,
                    rgba(12,7,45,.94)  0%,
                    rgba(22,13,78,.82) 20%,
                    rgba(36,22,108,.62) 42%,
                    rgba(52,36,145,.38) 65%,
                    rgba(66,50,165,.18) 85%,
                    rgba(76,60,178,.06) 100%),
                linear-gradient(to bottom,
                    rgba(14,9,52,.18) 0%,
                    rgba(6,3,22,.62)  100%);
        }

        /* Hero top bar */
        .hero-topbar {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 28px 40px;
        }
        .hero-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #5b21b6, #7c3aed);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; color: #fff;
            box-shadow: 0 4px 16px rgba(124,58,237,.50);
            flex-shrink: 0;
        }
        .hero-logo-text strong {
            display: block;
            font-size: 14px; font-weight: 800;
            color: #fff; letter-spacing: -.3px;
        }
        .hero-logo-text small {
            font-size: 10.5px;
            color: rgba(255,255,255,.45);
            font-weight: 400;
        }

        /* Hero body content */
        .hero-body {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 0 40px 24px;
        }

        .hero-headline {
            font-family: 'Manrope', sans-serif;
            font-size: clamp(28px, 3.4vw, 46px);
            font-weight: 900;
            color: #fff;
            line-height: 1.14;
            letter-spacing: -.5px;
            margin-bottom: 16px;
        }
        .hero-headline .accent {
            background: linear-gradient(90deg, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
        }
        .hero-desc {
            font-size: 14px;
            color: rgba(255,255,255,.65);
            line-height: 1.72;
            max-width: 400px;
            margin-bottom: 28px;
        }

        /* Feature list */
        .features {
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 18px;
            margin-bottom: 0;
        }
        .features li {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            font-size: 12.5px;
            color: rgba(255,255,255,.75);
            line-height: 1.45;
        }
        .feat-icon {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .fi-blue   { background: rgba(59,130,246,.28);  color: #60a5fa; }
        .fi-green  { background: rgba(16,185,129,.28);  color: #34d399; }
        .fi-purple { background: rgba(139,92,246,.28);  color: #a78bfa; }
        .fi-amber  { background: rgba(245,158,11,.28);  color: #fbbf24; }
        .feat-body strong { display: block; font-weight: 700; font-size: 12.5px; color: rgba(255,255,255,.95); margin-bottom: 2px; }
        .feat-body span   { font-size: 11.5px; color: rgba(255,255,255,.48); }


        /* ═══════════════════════════════
           AUTH PANEL — RIGHT
        ═══════════════════════════════ */
        .auth-panel {
            flex: 1;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 36px;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Subtle left border */
        .auth-panel::before {
            content: '';
            position: absolute;
            left: 0; top: 10%; bottom: 10%;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(37,99,235,.15) 50%, transparent);
        }

        .auth-card {
            width: 100%;
            max-width: 360px;
            animation: fadeUp .6s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Logo */
        .card-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
            justify-content: center;
        }
        .card-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; color: #fff;
            box-shadow: 0 4px 16px rgba(37,99,235,.3);
        }
        .card-logo-text strong {
            display: block;
            font-size: 14px; font-weight: 800;
            color: var(--slate-900);
        }
        .card-logo-text small {
            font-size: 10.5px;
            color: var(--slate-400);
        }

        /* Headings */
        .card-title {
            font-family: 'Manrope', sans-serif;
            font-size: 27px;
            font-weight: 900;
            color: var(--slate-900);
            letter-spacing: -.5px;
            margin-bottom: 5px;
            text-align: center;
        }
        .card-sub {
            font-size: 13px;
            color: var(--slate-400);
            text-align: center;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        /* Status alert */
        .status-alert {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 11px 15px;
            font-size: 13px;
            color: #15803d;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Form fields */
        .field-block { margin-bottom: 16px; }
        .field-lbl {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--slate-700);
            margin-bottom: 6px;
            letter-spacing: .2px;
        }
        .field-wrap { position: relative; }
        .field-ico {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--slate-400);
            font-size: 13px;
            pointer-events: none;
            transition: color .2s;
        }
        .field-in {
            width: 100%;
            background: var(--slate-100);
            border: 1.5px solid var(--slate-200);
            border-radius: 10px;
            padding: 12px 40px 12px 38px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--slate-900);
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .field-in::placeholder { color: var(--slate-400); }
        .field-in:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }
        .field-in:focus ~ .field-ico,
        .field-wrap:focus-within .field-ico { color: var(--blue); }
        .field-in.is-invalid { border-color: #ef4444; background: #fff5f5; }
        .field-in.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,.12); }
        .err-msg {
            font-size: 11.5px;
            color: #ef4444;
            margin-top: 5px;
            display: flex; align-items: center; gap: 5px;
        }

        .eye-btn {
            position: absolute;
            right: 11px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--slate-400);
            cursor: pointer;
            padding: 3px 5px;
            border-radius: 5px;
            font-size: 13px;
            transition: color .2s;
        }
        .eye-btn:hover { color: var(--blue); }

        /* Meta row */
        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .check-lbl {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12.5px;
            color: var(--slate-500);
            cursor: pointer;
            user-select: none;
        }
        .check-lbl input { accent-color: var(--blue); width: 14px; height: 14px; cursor: pointer; }
        .forgot-link {
            font-size: 12.5px;
            color: var(--blue);
            text-decoration: none;
            font-weight: 500;
            transition: color .2s;
        }
        .forgot-link:hover { color: #1d4ed8; text-decoration: underline; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            letter-spacing: .2px;
            transition: box-shadow .3s, transform .15s, filter .2s;
            box-shadow: 0 4px 18px rgba(37,99,235,.35);
            position: relative;
            overflow: hidden;
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, transparent 0%, rgba(255,255,255,.12) 50%, transparent 100%);
            transform: translateX(-100%);
            transition: transform .5s ease;
        }
        .btn-submit:hover { box-shadow: 0 6px 26px rgba(37,99,235,.5); transform: translateY(-1px); filter: brightness(1.05); }
        .btn-submit:hover::after { transform: translateX(100%); }
        .btn-submit:active { transform: translateY(0); }

        /* OR divider */
        .or-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 18px 0;
        }
        .or-divider::before, .or-divider::after {
            content: ''; flex: 1;
            height: 1px; background: var(--slate-200);
        }
        .or-divider span {
            font-size: 11.5px;
            color: var(--slate-400);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* Create account link */
        .create-account-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 6px;
            font-size: 13px;
            color: var(--slate-500);
        }
        .create-account-row a {
            color: var(--blue);
            font-weight: 700;
            text-decoration: none;
            transition: color .2s;
        }
        .create-account-row a:hover { color: #1d4ed8; text-decoration: underline; }

        /* Footer */
        .auth-footer {
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 11px;
            color: var(--slate-400);
        }
        .auth-footer i { color: var(--blue-lt); }

        /* ═══════════════════════════════
           RESPONSIVE
        ═══════════════════════════════ */
        /* Tablet: ≤1100px */
        @media (max-width: 1100px) {
            .hero-panel { flex: 0 0 52%; }
            .features { grid-template-columns: 1fr; gap: 8px; }
            .auth-panel { padding: 36px 28px; }
        }

        /* Small tablet / landscape phone: ≤860px */
        @media (max-width: 860px) {
            body {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow-y: auto;
                overflow-x: hidden;
            }
            .hero-panel {
                flex: none;
                width: 100%;
                height: 44vw;
                min-height: 220px;
                max-height: 380px;
            }
            .hero-desc { display: none; }
            .hero-body { padding-bottom: 24px; }
            .hero-headline { font-size: clamp(18px, 4.5vw, 28px); }
            .features { grid-template-columns: 1fr 1fr; gap: 8px; }
            .auth-panel {
                flex: 1;
                width: 100%;
                height: auto;
                overflow-y: visible;
                padding: 32px 28px 48px;
                align-items: flex-start;
            }
            .auth-card { max-width: 520px; margin: 0 auto; width: 100%; }
            .auth-panel::before { display: none; }
        }

        /* Portrait phone: ≤580px */
        @media (max-width: 580px) {
            .hero-panel { height: 48vw; min-height: 190px; }
            .hero-topbar { padding: 18px 20px; }
            .hero-body { padding: 0 20px 20px; }
            .hero-headline { font-size: 19px; }
            .features { display: none; }
            .auth-panel { padding: 28px 20px 44px; }
            .auth-card { max-width: 100%; }
            .card-logo { justify-content: flex-start; }
            .card-title, .card-sub { text-align: left; }
        }

        /* Small phones: ≤400px */
        @media (max-width: 400px) {
            .hero-panel { height: 46vw; min-height: 170px; }
            .auth-panel { padding: 22px 16px 40px; }
            .card-title { font-size: 22px; }
        }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════
     HERO — LEFT SLIDESHOW PANEL
══════════════════════════════════════ -->
<section class="hero-panel" id="heroPanel">

    <!-- Background slides -->
    <div class="slides-wrap" id="slidesWrap">
        <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide"        style="background-image:url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide"        style="background-image:url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide"        style="background-image:url('https://images.unsplash.com/photo-1560185008-b033106af5c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
    </div>
    <div class="slide-overlay"></div>

    <!-- Top logo -->
    <div class="hero-topbar">
        <div class="hero-logo-icon"><i class="fas fa-building"></i></div>
        <div class="hero-logo-text">
            <strong>AVMS</strong>
            <small>Apartment Visitors Management System</small>
        </div>
    </div>

    <!-- Hero content -->
    <div class="hero-body">
        <h1 class="hero-headline">
            Smart Visitor<br>
            Management<br>
            <span class="accent">for Modern Living</span>
        </h1>
        <p class="hero-desc">
            A secure and efficient platform to manage visitor access, monitor real-time activity, and ensure the safety of your apartment community.
        </p>

        <ul class="features">
            <li>
                <div class="feat-icon fi-blue"><i class="fas fa-shield-halved"></i></div>
                <div class="feat-body">
                    <strong>Secure &amp; Role-Based Access</strong>
                    <span>Ensure only authorised personnel can access the system</span>
                </div>
            </li>
            <li>
                <div class="feat-icon fi-green"><i class="fas fa-person-walking"></i></div>
                <div class="feat-body">
                    <strong>Real-Time Visitor Tracking</strong>
                    <span>Monitor check-ins, check-outs and active visitors instantly</span>
                </div>
            </li>
            <li>
                <div class="feat-icon fi-purple"><i class="fas fa-chart-line"></i></div>
                <div class="feat-body">
                    <strong>Powerful Analytics &amp; Reports</strong>
                    <span>Generate insightful reports and track visitor trends</span>
                </div>
            </li>
            <li>
                <div class="feat-icon fi-amber"><i class="fas fa-bell"></i></div>
                <div class="feat-body">
                    <strong>Instant Tenant Notifications</strong>
                    <span>Notify residents for visitor arrivals and approvals in real-time</span>
                </div>
            </li>
        </ul>
    </div>

</section>

<!-- ══════════════════════════════════════
     AUTH — RIGHT PANEL
══════════════════════════════════════ -->
<aside class="auth-panel">
    <div class="auth-card">

        <!-- Logo -->
        <div class="card-logo">
            <div class="card-logo-icon"><i class="fas fa-building"></i></div>
            <div class="card-logo-text">
                <strong>AVMS</strong>
                <small>Apartment Visitors Management System</small>
            </div>
        </div>

        <!-- Status -->
        @if(session('status'))
        <div class="status-alert">
            <i class="fas fa-check-circle"></i>{{ session('status') }}
        </div>
        @endif

        <h1 class="card-title">Welcome back!</h1>
        <p class="card-sub">Sign in to continue to your dashboard.</p>

        <!-- Form -->
        <form method="POST" action="/login" id="loginForm">
            @csrf

            <!-- Email -->
            <div class="field-block">
                <label class="field-lbl" for="email">Email Address</label>
                <div class="field-wrap">
                    <i class="fas fa-envelope field-ico"></i>
                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        class="field-in @error('email') is-invalid @enderror"
                        placeholder="you@example.com"
                        required autofocus autocomplete="username">
                </div>
                @error('email')
                <div class="err-msg"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="field-block">
                <label class="field-lbl" for="password">Password</label>
                <div class="field-wrap">
                    <i class="fas fa-lock field-ico"></i>
                    <input id="password" type="password" name="password"
                        class="field-in @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required autocomplete="current-password"
                        style="padding-right:42px">
                    <button type="button" class="eye-btn" onclick="togglePwd()" title="Show password">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                <div class="err-msg"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>
                @enderror
            </div>

            <!-- Meta row -->
            <div class="meta-row">
                <label class="check-lbl">
                    <input type="checkbox" name="remember" id="remember_me">
                    Remember me
                </label>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-arrow-right-to-bracket" style="margin-right:8px"></i>
                Sign In to Dashboard
            </button>
        </form>

        <!-- Create Account -->
        <div class="or-divider"><span>or</span></div>

        <div class="create-account-row">
            <span>Don't have an account?</span>
            <a href="{{ route('register') }}"><i class="fas fa-user-plus" style="font-size:11px;margin-right:3px;"></i>Create Account</a>
        </div>

        <!-- Footer -->
        <div class="auth-footer">
            <i class="fas fa-lock"></i>
            &copy; {{ date('Y') }} AVMS &mdash; All rights reserved
        </div>
    </div>
</aside>

<script>
/* ── Slideshow (auto-advancing) ── */
const slides   = document.querySelectorAll('.slide');
let   current  = 0;
const INTERVAL = 5000;

function goTo(index) {
    slides[current].classList.remove('active');
    current = (index + slides.length) % slides.length;
    slides[current].classList.add('active');
}

setInterval(() => goTo(current + 1), INTERVAL);

/* ── Password toggle ── */
function togglePwd() {
    const inp  = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    const show = inp.type === 'password';
    inp.type   = show ? 'text' : 'password';
    icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
}

/* ── Submit loading state ── */
document.getElementById('loginForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin" style="margin-right:8px"></i>Signing In…';
    btn.disabled  = true;
});
</script>
</body>
</html>
