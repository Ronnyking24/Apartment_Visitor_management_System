@extends('layouts.dashboard')
@section('title','Visit Details')
@section('page-title','Visit Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        {{-- Success banner for fresh check-in or pending approval --}}
        @if(session('success'))
            @if($visit->status === 'pending')
            <div style="background:linear-gradient(135deg,#0f1623,#1a2a4a);border-radius:14px;padding:28px;text-align:center;color:#fff;margin-bottom:24px;">
                <div style="width:60px;height:60px;background:#f59e0b;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto 14px;">
                    <i class="fas fa-clock"></i>
                </div>
                <h4 style="font-weight:800;margin-bottom:6px;">Visitor Registration Submitted</h4>
                <p style="opacity:.7;font-size:13.5px;margin:0;">Waiting for resident approval.</p>
            </div>
            @else
            <div style="background:linear-gradient(135deg,#0f1623,#1a2a4a);border-radius:14px;padding:28px;text-align:center;color:#fff;margin-bottom:24px;">
                <div style="width:60px;height:60px;background:#22c55e;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto 14px;">
                    <i class="fas fa-check"></i>
                </div>
                <h4 style="font-weight:800;margin-bottom:6px;">Visitor Checked In!</h4>
                <p style="opacity:.7;font-size:13.5px;margin:0;">Checked in successfully.</p>
            </div>
            @endif
        @endif

        <div class="card-panel mb-3">
            <div class="card-header-custom">
                <h6 class="card-title-custom"><i class="fas fa-clipboard-check me-2 text-primary"></i>Visit Pass</h6>
                <span class="badge-status badge-{{ $visit->status }}">{{ ucfirst($visit->status) }}</span>
            </div>
            <div style="padding:24px;">
                <div class="d-flex align-items-center gap-3 mb-4 p-3" style="background:#f8fafc;border-radius:12px;">
                    @if($visit->visitor->photo)
                        <img src="{{ asset('storage/'.$visit->visitor->photo) }}" style="width:64px;height:64px;border-radius:14px;object-fit:cover;" alt="">
                    @else
                        <div style="width:64px;height:64px;background:#e2e8f0;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;color:#94a3b8;">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                    <div>
                        <h5 style="font-weight:800;margin:0 0 4px;">{{ $visit->visitor->full_name }}</h5>
                        <div style="font-size:13px;color:#64748b;">{{ $visit->visitor->phone_number ?? 'No phone' }}</div>
                        <div style="font-size:12px;color:#94a3b8;">ID: {{ $visit->visitor->national_id ?? '—' }}</div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;">Visiting</div>
                        <div style="font-weight:700;font-size:14px;">{{ $visit->tenant->user->name ?? '—' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;">Apartment</div>
                        <div style="font-weight:700;font-size:14px;">{{ $visit->tenant->apartment_display ?? '—' }}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;">Purpose</div>
                        <div style="font-weight:600;font-size:13.5px;">{{ $visit->purpose }}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;">Check In</div>
                        <div style="font-weight:600;font-size:13.5px;">{{ $visit->check_in_time?->format('M d, Y H:i') ?? '—' }}</div>
                    </div>
                    @if($visit->check_out_time)
                    <div class="col-6">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;">Check Out</div>
                        <div style="font-weight:600;font-size:13.5px;">{{ $visit->check_out_time->format('M d, Y H:i') }}</div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;">Duration</div>
                        <div style="font-weight:600;font-size:13.5px;">{{ $visit->duration ?? '—' }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            @if($visit->status === 'active')
            <form method="POST" action="{{ route('guard.visits.checkout', $visit) }}"
                  onsubmit="return confirm('Check out this visitor?')" class="flex-fill">
                @csrf @method('PATCH')
                <button class="btn btn-danger w-100 btn-lg"><i class="fas fa-sign-out-alt me-2"></i>Check Out Now</button>
            </form>
            @endif
            <a href="{{ route('guard.dashboard') }}" class="btn btn-outline-secondary flex-fill btn-lg"><i class="fas fa-home me-1"></i>Dashboard</a>
        </div>
    </div>
</div>
@endsection
