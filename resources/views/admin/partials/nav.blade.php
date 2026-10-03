<nav class="admin-nav" aria-label="Staff navigation">
    <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="icon-sm" data-lucide="layout-dashboard" aria-hidden="true"></i> Overview</a>
    <a class="{{ request()->routeIs('admin.posts') ? 'active' : '' }}" href="{{ route('admin.posts') }}"><i class="icon-sm" data-lucide="message-circle" aria-hidden="true"></i> Community posts</a>
    <a class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}"><i class="icon-sm" data-lucide="shield-check" aria-hidden="true"></i> Concern reports</a>
    @if (auth()->user()->role === 'admin')
        <a href="{{ route('admin.content.index', 'news') }}"><i class="icon-sm" data-lucide="newspaper" aria-hidden="true"></i> News & events</a>
        <a href="{{ route('admin.content.index', 'events') }}"><i class="icon-sm" data-lucide="calendar-days" aria-hidden="true"></i> Events</a>
        <a href="{{ route('admin.content.index', 'programs') }}"><i class="icon-sm" data-lucide="graduation-cap" aria-hidden="true"></i> Programs</a>
        <a href="{{ route('admin.content.index', 'faculty') }}"><i class="icon-sm" data-lucide="users" aria-hidden="true"></i> Faculty</a>
        <a href="{{ route('admin.content.index', 'facilities') }}"><i class="icon-sm" data-lucide="map-pin" aria-hidden="true"></i> Campus content</a>
        <a href="{{ route('admin.content.index', 'gallery') }}"><i class="icon-sm" data-lucide="images" aria-hidden="true"></i> Gallery</a>
        <a href="{{ route('admin.users') }}"><i class="icon-sm" data-lucide="user-round-cog" aria-hidden="true"></i> Users & roles</a>
    @endif
</nav>