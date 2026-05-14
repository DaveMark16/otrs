<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - OTRS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #121313;
            font-family: system-ui, -apple-system, sans-serif;
            color: #ccc;
        }
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar - matches user dashboard */
        .sidebar {
            width: 210px;
            min-width: 210px;
            background: #1a1b1b;
            border-right: 0.5px solid #2a2b2b;
            display: flex;
            flex-direction: column;
        }
        .sb-brand {
            padding: 18px 16px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 0.5px solid #2a2b2b;
        }
        .sb-logo {
            width: 32px;
            height: 32px;
            background: #FF6044;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sb-logo svg {
            width: 16px;
            height: 16px;
        }
        .sb-title {
            font-size: 15px;
            font-weight: 500;
            color: #fff;
        }
        .sb-nav {
            flex: 1;
            padding: 12px 8px;
            overflow-y: auto;
        }
        .sb-section {
            font-size: 10px;
            color: #555;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 12px 8px 6px;
        }
        .sb-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 7px;
            color: #888;
            cursor: pointer;
            margin-bottom: 2px;
            text-decoration: none;
            transition: all 0.15s;
        }
        .sb-item:hover {
            background: #222;
            color: #ccc;
        }
        .sb-item.active {
            background: rgba(255,96,68,0.12);
            color: #FF6044;
        }
        .sb-item svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }
        .sb-user {
            padding: 12px 14px;
            border-top: 0.5px solid #2a2b2b;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sb-avatar {
            width: 30px;
            height: 30px;
            background: #FF6044;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 500;
            color: #fff;
            flex-shrink: 0;
        }
        .sb-uname {
            font-size: 13px;
            color: #ccc;
        }
        .sb-urole {
            font-size: 11px;
            color: #555;
        }
        .logout-btn {
            width: calc(100% - 28px);
            margin: 0 14px 14px 14px;
            background: rgba(255,96,68,0.1);
            border: 0.5px solid rgba(255,96,68,0.3);
            border-radius: 8px;
            padding: 8px;
            color: #FF6044;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .logout-btn:hover {
            background: rgba(255,96,68,0.2);
            border-color: #FF6044;
        }
        /* Main content area */
        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #121313;
        }
    </style>
</head>
<body>
<div class="admin-container">
    <div class="sidebar">
        <div class="sb-brand">
            <div class="sb-logo">
                <svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 10h16M8 14h8M10 18h4" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
            </div>
            <div class="sb-title">OTRS Admin</div>
        </div>
        <div class="sb-nav">
            <div class="sb-section">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.8"/><rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.8"/><rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.8"/><rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.8"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="sb-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Bookings
            </a>
            <a href="{{ route('admin.users.index') }}" class="sb-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 2a5 5 0 1 0 0 10 5 5 0 0 0 0-10zM4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Users
            </a>
            <div class="sb-section">Admin</div>
            <a href="{{ route('admin.dashboard') }}" class="sb-item">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 2a5 5 0 1 0 0 10 5 5 0 0 0 0-10zM4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Admin Panel
            </a>
            <div class="sb-section">Finance</div>
            <a href="#" class="sb-item">
                <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M2 10h20" stroke="currentColor" stroke-width="1.8"/></svg>
                Payments & Refunds
            </a>
        </div>

        <div class="sb-user">
            <div class="sb-avatar">{{ substr(auth()->user()->name ?? 'AD', 0, 2) }}</div>
            <div>
                <div class="sb-uname">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="sb-urole">{{ ucfirst(auth()->user()->role ?? 'admin') }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg viewBox="0 0 24 24" fill="none" width="14" height="14" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Logout
            </button>
        </form>
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>
</body>
</html>