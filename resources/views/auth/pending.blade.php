<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending — AVMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #fff; border-radius: 24px; padding: 48px 44px; max-width: 480px; width: 100%; text-align: center; box-shadow: 0 25px 80px rgba(0,0,0,.35); animation: fadeUp .6s ease both; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
        .logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 32px; }
        .logo-icon { width: 44px; height: 44px; background: linear-gradient(135deg,#1e3a8a,#3b82f6); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; box-shadow: 0 4px 16px rgba(37,99,235,.3); }
        .logo-text strong { display: block; font-size: 15px; font-weight: 800; color: #0f172a; }
        .logo-text small { font-size: 11px; color: #94a3b8; }
        .status-ring { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, #fef3c7, #fde68a); display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 38px; border: 4px solid #fbbf24; box-shadow: 0 0 0 8px rgba(251,191,36,.12); }
        h1 { font-family: 'Manrope', sans-serif; font-size: 26px; font-weight: 900; color: #0f172a; margin-bottom: 10px; letter-spacing: -.4px; }
        .sub { font-size: 14px; color: #64748b; line-height: 1.7; margin-bottom: 28px; }
        .info-box { background: #f8faff; border: 1.5px solid #bfdbfe; border-radius: 14px; padding: 18px 20px; margin-bottom: 28px; text-align: left; }
        .info-row { display: flex; align-items: flex-start; gap: 12px; font-size: 13px; color: #334155; line-height: 1.5; margin-bottom: 12px; }
        .info-row:last-child { margin-bottom: 0; }
        .info-row i { color: #3b82f6; font-size: 14px; margin-top: 1px; flex-shrink: 0; }
        .user-chip { display: inline-flex; align-items: center; gap: 8px; background: #f1f5f9; border: 1.5px solid #e2e8f0; border-radius: 30px; padding: 6px 14px; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 28px; }
        .user-chip i { color: #1e3a8a; }
        .btn-logout { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 13px; background: linear-gradient(135deg,#1e3a8a,#2563eb); color: #fff; border: none; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; transition: all .2s; box-shadow: 0 4px 18px rgba(37,99,235,.3); font-family: 'Inter', sans-serif; }
        .btn-logout:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(37,99,235,.45); }
        .footer { margin-top: 20px; font-size: 12px; color: #94a3b8; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
        .dot { display: inline-block; width: 7px; height: 7px; border-radius: 50%; background: #f59e0b; animation: pulse 1.6s ease-in-out infinite; margin-right: 6px; }
        .dot:nth-child(2) { animation-delay: .3s; }
        .dot:nth-child(3) { animation-delay: .6s; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <div class="logo-icon"><i class="fas fa-building"></i></div>
        <div class="logo-text">
            <strong>AVMS</strong>
            <small>Apartment Visitors Management System</small>
        </div>
    </div>

    <div class="status-ring">⏳</div>

    <h1>Account Pending Approval</h1>
    <p class="sub">Your account has been submitted and is currently under review by our administrators.</p>

    <div class="user-chip">
        <i class="fas fa-shield-halved"></i>
        {{ auth()->user()->name }}
        &nbsp;·&nbsp;
        <span style="color:#f59e0b;font-weight:700;">
            <span class="dot"></span><span class="dot"></span><span class="dot"></span>
            Awaiting Approval
        </span>
    </div>

    <div class="info-box">
        <div class="info-row">
            <i class="fas fa-clock"></i>
            <span>Your guard account is being reviewed. This typically takes a short time during business hours.</span>
        </div>
        <div class="info-row">
            <i class="fas fa-envelope"></i>
            <span>You'll be able to sign in and access your dashboard once an administrator activates your account.</span>
        </div>
        <div class="info-row">
            <i class="fas fa-circle-info"></i>
            <span>If you believe this is taking too long, please contact your complex administrator directly.</span>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="fas fa-arrow-right-from-bracket"></i>
            Sign Out
        </button>
    </form>

    <p class="footer">&copy; {{ date('Y') }} AVMS &mdash; All rights reserved</p>
</div>
</body>
</html>
