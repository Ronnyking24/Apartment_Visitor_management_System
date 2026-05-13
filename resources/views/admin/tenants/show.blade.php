@extends('layouts.dashboard')
@section('title','Tenant Details')
@section('page-title','Tenant Details')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card-panel mb-3">
            <div style="padding:24px;text-align:center;border-bottom:1px solid #f1f5f9;">
                <div style="width:72px;height:72px;background:#dbeafe;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#3b82f6;margin:0 auto 12px;">
                    {{ strtoupper(substr($tenant->user->name,0,1)) }}
                </div>
                <h5 style="font-weight:700;margin-bottom:4px;">{{ $tenant->user->name }}</h5>
                <p style="font-size:12.5px;color:#64748b;margin-bottom:8px;">{{ $tenant->user->email }}</p>
                <span class="badge-status badge-active">Tenant</span>
            </div>
            <div style="padding:20px;">
                <dl class="row g-2" style="font-size:13.5px;">
                    <dt class="col-5 text-muted">Apartment</dt>
                    <dd class="col-7 fw-semibold">{{ $tenant->apartment->apartment_number ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Block</dt>
                    <dd class="col-7">{{ $tenant->apartment->block_name ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Phone</dt>
                    <dd class="col-7">{{ $tenant->phone ?? '—' }}</dd>
                    <dt class="col-5 text-muted">National ID</dt>
                    <dd class="col-7">{{ $tenant->national_id ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Gender</dt>
                    <dd class="col-7">{{ ucfirst($tenant->gender ?? '—') }}</dd>
                    <dt class="col-5 text-muted">Total Visits</dt>
                    <dd class="col-7"><span class="badge bg-light text-dark border">{{ $tenant->visits->count() }}</span></dd>
                </dl>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.tenants.edit', $tenant) }}" class="btn btn-primary flex-fill"><i class="fas fa-pen me-1"></i>Edit</a>
            <a href="{{ route('admin.tenants.index') }}" class="btn btn-outline-secondary flex-fill"><i class="fas fa-arrow-left me-1"></i>Back</a>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-panel">
            <div class="card-header-custom">
                <h6 class="card-title-custom"><i class="fas fa-clipboard-list me-2 text-primary"></i>Visit History</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead><tr><th>Visitor</th><th>Purpose</th><th>Check In</th><th>Check Out</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($tenant->visits as $visit)
                        <tr>
                            <td style="font-weight:600;font-size:13px;">{{ $visit->visitor->full_name }}</td>
                            <td style="font-size:13px;">{{ Str::limit($visit->purpose, 30) }}</td>
                            <td style="font-size:12px;color:#64748b;">{{ $visit->check_in_time?->format('M d, H:i') ?? '—' }}</td>
                            <td style="font-size:12px;color:#64748b;">{{ $visit->check_out_time?->format('M d, H:i') ?? '—' }}</td>
                            <td><span class="badge-status badge-{{ $visit->status }}">{{ ucfirst($visit->status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">No visits yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
