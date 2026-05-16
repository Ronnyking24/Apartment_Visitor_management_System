@extends('layouts.dashboard')
@section('title','Account Setup')
@section('page-title','Account Setup')

@section('content')
<div style="max-width:560px;margin:60px auto;text-align:center;padding:0 20px;">

    <div style="width:88px;height:88px;border-radius:24px;background:linear-gradient(135deg,#eff6ff,#dbeafe);border:2px solid #bfdbfe;display:flex;align-items:center;justify-content:center;font-size:36px;margin:0 auto 24px;box-shadow:0 4px 20px rgba(37,99,235,.1);">
        🏠
    </div>

    <h2 style="font-size:22px;font-weight:800;color:#0f172a;margin-bottom:8px;letter-spacing:-.3px;">Welcome to AVMS, {{ Auth::user()->name }}!</h2>
    <p style="font-size:14px;color:#64748b;line-height:1.7;margin-bottom:28px;">
        Your resident account has been created successfully. An administrator will assign your apartment shortly. Once assigned, you'll have full access to manage your visitors here.
    </p>

    <div style="background:#f8faff;border:1.5px solid #bfdbfe;border-radius:16px;padding:22px 24px;text-align:left;margin-bottom:24px;">
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:32px;height:32px;border-radius:8px;background:#dbeafe;color:#1e3a8a;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">
                <i class="fas fa-check"></i>
            </div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:2px;">Account Created</div>
                <div style="font-size:12px;color:#64748b;">Your credentials are saved and ready to use.</div>
            </div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
            <div style="width:32px;height:32px;border-radius:8px;background:#fef3c7;color:#d97706;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:2px;">Apartment Assignment Pending</div>
                <div style="font-size:12px;color:#64748b;">The admin will assign your apartment. This usually happens quickly.</div>
            </div>
        </div>
        <div style="display:flex;align-items:flex-start;gap:12px;">
            <div style="width:32px;height:32px;border-radius:8px;background:#d1fae5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">
                <i class="fas fa-door-open"></i>
            </div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#0f172a;margin-bottom:2px;">Full Access Unlocked</div>
                <div style="font-size:12px;color:#64748b;">Once assigned, your visitor management dashboard becomes active.</div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" style="display:inline-flex;align-items:center;gap:7px;padding:11px 22px;background:#f1f5f9;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;font-weight:600;color:#475569;cursor:pointer;font-family:inherit;transition:all .2s;">
            <i class="fas fa-arrow-right-from-bracket"></i> Sign Out
        </button>
    </form>

</div>
@endsection
