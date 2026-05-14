<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OTRS — @yield('page-title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sand:      #f5ede0;
            --cream:     #faf6f0;
            --brown:     #3b2a1a;
            --tan:       #c49a6c;
            --gold:      #d4a254;
            --gold-lt:   #e2b46a;
            --teal:      #2d6e6e;
            --teal-lt:   #3d8f8f;
            --white:     #ffffff;
            --radius:    16px;
            --radius-sm: 10px;
            --ff-head:   'Playfair Display', Georgia, serif;
            --ff-body:   'DM Sans', sans-serif;
            --sidebar-w: 256px;
            --topbar-h:  64px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--ff-body); background: var(--cream); color: var(--brown); min-height: 100vh; display: flex; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }

        /* Sidebar */
        .sidebar { width: var(--sidebar-w); min-width: var(--sidebar-w); background: var(--brown); min-height: 100vh; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; overflow-y: auto; z-index: 200; scrollbar-width: none; transition: transform .28s ease; }
        .sidebar::-webkit-scrollbar { display: none; }
        .sb-brand { padding: 26px 22px 20px; border-bottom: 1px solid rgba(245,237,224,.1); flex-shrink: 0; }
        .sb-logo { font-family: var(--ff-head); font-size: 1.75rem; font-weight: 900; color: var(--sand); letter-spacing: -.5px; line-height: 1; }
        .sb-logo span { color: var(--gold); }
        .sb-tagline { font-size: .68rem; color: rgba(245,237,224,.35); margin-top: 4px; letter-spacing: .04em; }
        .sb-user { display: flex; align-items: center; gap: 12px; padding: 16px 22px; border-bottom: 1px solid rgba(245,237,224,.1); }
        .sb-avatar { width: 38px; height: 38px; background: linear-gradient(135deg, var(--gold), var(--tan)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--ff-head); font-size: .95rem; font-weight: 700; color: var(--brown); flex-shrink: 0; }
        .sb-user-name { font-size: .86rem; font-weight: 600; color: var(--sand); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb-user-role { font-size: .71rem; color: var(--gold); margin-top: 1px; opacity: .85; }
        .sb-nav { flex: 1; padding: 16px 12px; }
        .sb-section { font-size: .67rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: rgba(245,237,224,.28); padding: 12px 10px 6px; margin-top: 4px; }
        .sb-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); color: rgba(245,237,224,.55); font-size: .86rem; font-weight: 500; margin-bottom: 2px; transition: background .15s, color .15s; }
        .sb-item svg { width: 15px; height: 15px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .sb-item:hover { background: rgba(245,237,224,.08); color: var(--sand); }
        .sb-item.active { background: rgba(212,162,84,.14); color: var(--gold); font-weight: 600; }
        .sb-item.active svg { stroke: var(--gold); }
        .sb-footer { padding: 14px 12px; border-top: 1px solid rgba(245,237,224,.1); flex-shrink: 0; }
        .sb-logout { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); color: rgba(245,237,224,.38); font-size: .84rem; font-family: var(--ff-body); cursor: pointer; transition: background .15s, color .15s; background: none; border: none; width: 100%; }
        .sb-logout svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; flex-shrink: 0; }
        .sb-logout:hover { background: rgba(212,60,60,.12); color: #e07070; }

        /* Main */
        .main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .topbar { background: var(--white); border-bottom: 1px solid rgba(59,42,26,.08); padding: 0 32px; height: var(--topbar-h); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-title { font-family: var(--ff-head); font-size: 1.15rem; font-weight: 700; color: var(--brown); }
        .topbar-pill { font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; background: rgba(45,110,110,.08); color: var(--teal); border: 1px solid rgba(45,110,110,.18); border-radius: 20px; padding: 3px 10px; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .topbar-date { font-size: .78rem; color: rgba(59,42,26,.4); }
        .topbar-btn { background: var(--teal); color: var(--white); padding: .48rem 1.15rem; border-radius: 50px; font-size: .8rem; font-weight: 600; display: inline-flex; align-items: center; gap: .4rem; transition: background .18s, transform .15s; box-shadow: 0 3px 12px rgba(45,110,110,.22); }
        .topbar-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }
        .topbar-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }
        .content { padding: 30px 32px 48px; flex: 1; background: var(--cream); }
        .flash { margin-bottom: 20px; padding: 12px 16px; border-radius: var(--radius-sm); font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: 8px; }
        .flash-success { background: rgba(45,110,110,.07); border: 1px solid rgba(45,110,110,.2); color: var(--teal); }
        .flash-error { background: rgba(180,60,60,.07); border: 1px solid rgba(180,60,60,.2); color: #b44444; }

        /* Mobile */
        .mobile-bar { display: none; background: var(--brown); padding: 0 20px; height: 58px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 200; }
        .mobile-logo { font-family: var(--ff-head); font-size: 1.3rem; font-weight: 900; color: var(--sand); }
        .mobile-logo span { color: var(--gold); }
        .hamburger { display: flex; flex-direction: column; gap: 5px; cursor: pointer; padding: 4px; }
        .hamburger span { width: 22px; height: 2px; background: var(--sand); border-radius: 2px; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(59,42,26,.5); z-index: 150; backdrop-filter: blur(3px); }
        .sidebar-overlay.open { display: block; }
        .sb-close { display: none; position: absolute; top: 14px; right: 14px; background: rgba(245,237,224,.1); border: none; color: rgba(245,237,224,.6); cursor: pointer; padding: 5px; border-radius: 6px; }
        .sb-close:hover { background: rgba(245,237,224,.18); color: var(--sand); }
        .sb-close svg { width: 16px; height: 16px; display: block; stroke: currentColor; fill: none; stroke-width: 2; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { position: fixed; left: -100%; top: 0; height: 100vh; transition: left .28s ease; }
            .sidebar.open { left: 0; }
            .sb-close { display: flex; align-items: center; justify-content: center; }
            .mobile-bar { display: flex; }
            .topbar { display: none; }
            .content { padding: 20px 16px 36px; }
        }
        @media (max-width: 480px) { .content { padding: 16px 14px 32px; } }
    </style>
</head>
<body>

<div class="mobile-bar">
    <div class="mobile-logo">OTR<span>S</span></div>
    <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
</div>
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <button class="sb-close" onclick="closeSidebar()" aria-label="Close menu">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="sb-brand">
        <div class="sb-logo">OTR<span>S</span></div>
        <div class="sb-tagline">Online Tour Reservation System</div>
    </div>
    <div class="sb-user">
        <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
        <div style="min-width:0;">
            <div class="sb-user-name">{{ auth()->user()->name ?? 'User' }}</div>
            <div class="sb-user-role">Traveler</div>
        </div>
    </div>
    <nav class="sb-nav">
        <div class="sb-section">Main</div>
        <a href="{{ route('dashboard') }}" class="sb-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <a href="{{ route('bookings.index') }}" class="sb-item {{ request()->routeIs('bookings.*') && !request()->routeIs('bookings.create') ? 'active' : '' }}" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            My Bookings
        </a>
        <a href="{{ route('tickets.index') }}" class="sb-item {{ request()->routeIs('tickets.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
            My Tickets
        </a>
        <a href="{{ route('bookings.create') }}" class="sb-item {{ request()->routeIs('bookings.create') || request()->routeIs('schedules.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
            Trips &amp; Schedules
        </a>
        <a href="{{ route('promos.index') }}" class="sb-item {{ request()->routeIs('promos.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg>
            Promo Codes
        </a>
        <div class="sb-section">Finance</div>
        <a href="{{ route('payments.index') }}" class="sb-item {{ request()->routeIs('payments.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Payments &amp; Refunds
        </a>
        <div class="sb-section">Account</div>
        <a href="{{ route('profile.edit') }}" class="sb-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            My Profile
        </a>
    </nav>
    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div class="topbar-left">
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <span class="topbar-pill">User Portal</span>
        </div>
        <div class="topbar-right">
            <div class="topbar-date">{{ now()->format('l, F j, Y') }}</div>
            <a href="{{ route('bookings.create') }}" class="topbar-btn">
                <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
                Book a Trip
            </a>
        </div>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="flash flash-success">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script>
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('overlay');
    const hamburger = document.getElementById('hamburger');
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        });
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
</script>
</body>
</html>