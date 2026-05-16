<div class="nav-section-title">Main</div>
<a href="{{ route('resident.dashboard') }}" class="nav-link {{ request()->routeIs('resident.dashboard') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-th-large"></i></span> Dashboard
</a>

<div class="nav-section-title">Visitors</div>
<a href="{{ route('resident.visits.active') }}" class="nav-link {{ request()->routeIs('resident.visits.active') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-circle-dot"></i></span> Active Visitors
    @php
        $residentModel = auth()->user()->resident;
        $activeCount = $residentModel ? \App\Models\Visit::where('resident_id', $residentModel->id)->where('status','active')->count() : 0;
    @endphp
    @if($activeCount > 0)<span class="nav-badge">{{ $activeCount }}</span>@endif
</a>
<a href="{{ route('resident.visits.index') }}" class="nav-link {{ request()->routeIs('resident.visits.index') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-clock-rotate-left"></i></span> Visit History
    @php
        $residentModel = auth()->user()->resident;
        $pendingCount = $residentModel ? \App\Models\Visit::where('resident_id', $residentModel->id)->where('status','pending')->count() : 0;
    @endphp
    @if($pendingCount > 0)<span class="nav-badge" title="{{ $pendingCount }} pending approval(s)">{{ $pendingCount }}</span>@endif
</a>
