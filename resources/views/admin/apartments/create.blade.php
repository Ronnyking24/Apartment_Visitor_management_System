@extends('layouts.dashboard')
@section('title','Add Apartment')
@section('page-title','Add Apartment')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card-panel">
            <div class="card-header-custom">
                <h6 class="card-title-custom"><i class="fas fa-building me-2 text-primary"></i>New Apartment</h6>
                <a href="{{ route('admin.apartments.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back</a>
            </div>
            <div style="padding:24px;">
                <form method="POST" action="{{ route('admin.apartments.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Apartment Number <span class="text-danger">*</span></label>
                            <input type="text" name="apartment_number" class="form-control @error('apartment_number') is-invalid @enderror"
                                value="{{ old('apartment_number') }}" placeholder="e.g. A101" required>
                            @error('apartment_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Block Name <span class="text-danger">*</span></label>
                            <input type="text" name="block_name" class="form-control @error('block_name') is-invalid @enderror"
                                value="{{ old('block_name') }}" placeholder="e.g. Block A" required>
                            @error('block_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Floor Number <span class="text-danger">*</span></label>
                            <input type="number" name="floor_number" class="form-control @error('floor_number') is-invalid @enderror"
                                value="{{ old('floor_number', 1) }}" min="0" required>
                            @error('floor_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="vacant"   {{ old('status','vacant')=='vacant'?'selected':'' }}>Vacant</option>
                                <option value="occupied" {{ old('status')=='occupied'?'selected':'' }}>Occupied</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 d-flex gap-2 justify-content-end pt-2">
                            <a href="{{ route('admin.apartments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Save Apartment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
