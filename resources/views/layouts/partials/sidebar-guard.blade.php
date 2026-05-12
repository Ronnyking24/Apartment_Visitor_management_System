<div class="nav-section-title">Main</div>
<a href="{{ route('guard.dashboard') }}" class="nav-link {{ request()->routeIs('guard.dashboard') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-th-large"></i></span> Dashboard
</a>

<div class="nav-section-title">Visitors</div>
<a href="{{ route('guard.visitors.create') }}" class="nav-link {{ request()->routeIs('guard.visitors.create') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-user-plus"></i></span> Register Visitor
</a>
<a href="{{ route('guard.visitors.active') }}" class="nav-link {{ request()->routeIs('guard.visitors.active') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-circle-dot"></i></span> Active Visitors
    @php $active = \App\Models\Visit::where('status','active')->count(); @endphp
    @if($active > 0)<span class="nav-badge">{{ $active }}</span>@endif
</a>
<a href="{{ route('guard.visitors.logs') }}" class="nav-link {{ request()->routeIs('guard.visitors.logs') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-clipboard-list"></i></span> Today's Logs
</a>
<a href="{{ route('guard.visitors.index') }}" class="nav-link {{ request()->routeIs('guard.visitors.index') ? 'active' : '' }}">
    <span class="nav-icon"><i class="fas fa-magnifying-glass"></i></span> Search Visitors
</a>
