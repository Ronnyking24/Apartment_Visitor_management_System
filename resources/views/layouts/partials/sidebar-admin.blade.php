<div class="nav-section-title">Main</div>
<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-th-large"></i></span> Dashboard
</a>

<div class="nav-section-title">Management</div>
<a href="{{ route('admin.apartments.index') }}" class="nav-link {{ request()->routeIs('admin.apartments.*') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-building"></i></span> Apartments
</a>
<a href="{{ route('admin.tenants.index') }}" class="nav-link {{ request()->routeIs('admin.tenants.*') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-users"></i></span> Tenants
    @php $unassigned = \App\Models\Tenant::whereNull('apartment_id')->count(); @endphp
    @if($unassigned > 0)<span class="nav-badge" title="{{ $unassigned }} tenant(s) need apartment assignment">{{ $unassigned }}</span>@endif
</a>
<a href="{{ route('admin.guards.index') }}" class="nav-link {{ request()->routeIs('admin.guards.*') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-shield-halved"></i></span> Security Guards
    @php $pendingG = \App\Models\User::where('role','guard')->where('status','pending')->count(); @endphp
    @if($pendingG > 0)<span class="nav-badge" title="{{ $pendingG }} guard(s) awaiting approval">{{ $pendingG }}</span>@endif
</a>

<div class="nav-section-title">Visitors</div>
<a href="{{ route('admin.visitors.index') }}" class="nav-link {{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-person-walking-arrow-right"></i></span> Visitors
</a>
<a href="{{ route('admin.visits.index') }}" class="nav-link {{ request()->routeIs('admin.visits.*') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-clipboard-list"></i></span> All Visits
    @php $active = \App\Models\Visit::where('status','active')->count(); @endphp
    @if($active > 0)<span class="nav-badge">{{ $active }}</span>@endif
</a>

<div class="nav-section-title">Reports</div>
<a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-chart-bar"></i></span> Reports
</a>
