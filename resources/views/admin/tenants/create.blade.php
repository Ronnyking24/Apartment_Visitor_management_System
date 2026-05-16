@extends('layouts.dashboard')
@section('title','Add Resident')
@section('page-title','Add Resident')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-panel">
                <div class="card-header-custom">
                <h6 class="card-title-custom"><i class="fas fa-user-plus me-2 text-primary"></i>New Resident</h6>
                <a href="{{ route('admin.tenants.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
            </div>
            <div style="padding:24px;">
                <form method="POST" action="{{ route('admin.tenants.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12"><h6 style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Account Details</h6><hr style="margin-top:0;border-color:#f1f5f9;"></div>
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-12 mt-2"><h6 style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Resident Profile</h6><hr style="margin-top:0;border-color:#f1f5f9;"></div>
                        <div class="col-md-6">
                            <label class="form-label">Apartment <span class="text-danger">*</span></label>
                            <select name="apartment_id" class="form-select @error('apartment_id') is-invalid @enderror" required>
                                <option value="">Select room…</option>
                                @foreach($apartments as $apt)
                                    <option value="{{ $apt->id }}" {{ old('apartment_id')==$apt->id?'selected':'' }}>
                                        {{ $apt->apartment_number }} — {{ $apt->block_name }} ({{ ucfirst($apt->status) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('apartment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+254…">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">National ID</label>
                            <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select…</option>
                                <option value="male"   {{ old('gender')=='male'?'selected':'' }}>Male</option>
                                <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                                <option value="other"  {{ old('gender')=='other'?'selected':'' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex gap-2 justify-content-end pt-2">
                            <a href="{{ route('admin.tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Create Resident</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
