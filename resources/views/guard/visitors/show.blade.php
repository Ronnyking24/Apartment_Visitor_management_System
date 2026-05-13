@extends('layouts.dashboard')
@section('title','Visitor Profile')
@section('page-title','Visitor Profile')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card-panel mb-3">
            <div style="padding:24px;text-align:center;border-bottom:1px solid #f1f5f9;">
                @if($visitor->photo)
                    <img src="{{ asset('storage/'.$visitor->photo) }}" style="width:88px;height:88px;border-radius:18px;object-fit:cover;margin-bottom:14px;" alt="">
                @else
                    <div style="width:88px;height:88px;background:#f1f5f9;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:34px;color:#94a3b8;margin:0 auto 14px;">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
                <h5 style="font-weight:700;margin-bottom:4px;">{{ $visitor->full_name }}</h5>
                <p style="font-size:12.5px;color:#64748b;margin:0;">{{ $visitor->phone_number ?? 'No phone' }}</p>
            </div>
            <div style="padding:20px;">
                <dl class="row g-2" style="font-size:13.5px;">
                    <dt class="col-5 text-muted">National ID</dt>
                    <dd class="col-7 fw-semibold">{{ $visitor->national_id ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Total Visits</dt>
                    <dd class="col-7"><span class="badge bg-light text-dark border">{{ $visitor->visits->count() }}</span></dd>
                    <dt class="col-5 text-muted">First Visit</dt>
                    <dd class="col-7" style="font-size:12px;">{{ $visitor->created_at->format('M d, Y') }}</dd>
                </dl>
            </div>
        </div>
        <a href="{{ route('guard.visitors.create') }}" class="btn btn-primary w-100 mb-2">
            <i class="fas fa-sign-in-alt me-1"></i>New Check-In
        </a>
        <a href="{{ route('guard.visitors.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
    <div class="col-lg-8">
        <div class="card-panel">
            <div class="card-header-custom">
                <h6 class="card-title-custom"><i class="fas fa-clipboard-list me-2 text-primary"></i>Visit History</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr><th>Tenant</th><th>Apt.</th><th>Purpose</th><th>Check In</th><th>Check Out</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        @forelse($visitor->visits as $visit)
                        <tr>
                            <td style="font-size:13px;font-weight:600;">{{ $visit->tenant->user->name ?? '—' }}</td>
                            <td style="font-size:13px;">{{ $visit->tenant->apartment->apartment_number ?? '—' }}</td>
                            <td style="font-size:13px;">{{ Str::limit($visit->purpose, 25) }}</td>
                            <td style="font-size:12px;color:#64748b;">{{ $visit->check_in_time?->format('M d, H:i') ?? '—' }}</td>
                            <td style="font-size:12px;color:#64748b;">{{ $visit->check_out_time?->format('M d, H:i') ?? '—' }}</td>
                            <td><span class="badge-status badge-{{ $visit->status }}">{{ ucfirst($visit->status) }}</span></td>
                            <td>
                                @if($visit->status === 'active')
                                <form method="POST" action="{{ route('guard.visits.checkout', $visit) }}"
                                      onsubmit="return confirm('Check out?')">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-sign-out-alt"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">No visit history.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
