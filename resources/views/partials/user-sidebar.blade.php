<nav>
    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        Dashboard
    </a>

    <a href="{{ route('bookings.index') }}"
       class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">
        My Bookings
    </a>

    <a href="{{ route('tickets.index') }}"
       class="{{ request()->routeIs('tickets.*') ? 'active' : '' }}">
        My Tickets
    </a>

    <a href="{{ route('profile.edit') }}"
       class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
        Profile
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</nav>