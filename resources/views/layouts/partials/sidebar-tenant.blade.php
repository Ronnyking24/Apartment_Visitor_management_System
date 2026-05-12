<div class="nav-section-title">Main</div>
<a href="{{ route('tenant.dashboard') }}" class="nav-link {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-th-large"></i></span> Dashboard
</a>

<div class="nav-section-title">Visitors</div>
<a href="{{ route('tenant.visits.active') }}" class="nav-link {{ request()->routeIs('tenant.visits.active') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-circle-dot"></i></span> Active Visitors
    @php
        $tenantModel = auth()->user()->tenant;
        $activeCount = $tenantModel ? \App\Models\Visit::where('tenant_id', $tenantModel->id)->where('status','active')->count() : 0;
    @endphp
    @if($activeCount > 0)<span class="nav-badge">{{ $activeCount }}</span>@endif
</a>
<a href="{{ route('tenant.visits.index') }}" class="nav-link {{ request()->routeIs('tenant.visits.index') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-clock-rotate-left"></i></span> Visit History
</a>
