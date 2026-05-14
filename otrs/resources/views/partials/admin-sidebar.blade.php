<nav>
    <a href="{{ route('admin.dashboard') }}"
       class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        Admin Dashboard
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        Users
    </a>

    <a href="{{ route('admin.bookings.index') }}"
       class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
        Bookings
    </a>

    <a href="{{ route('admin.trips.index') }}"
       class="{{ request()->routeIs('admin.trips.*') ? 'active' : '' }}">
        Trips
    </a>

    <a href="{{ route('admin.payments.index') }}"
       class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
        Payments
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</nav>