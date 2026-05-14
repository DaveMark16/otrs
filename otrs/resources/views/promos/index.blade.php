<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>OTRS — Promo Codes</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<style>
:root {
  --sand:    #f5ede0;
  --cream:   #faf6f0;
  --brown:   #3b2a1a;
  --tan:     #c49a6c;
  --gold:    #d4a254;
  --teal:    #2d6e6e;
  --teal-lt: #3d8f8f;
  --white:   #ffffff;
  --radius:  18px;
  --ff-head: 'Playfair Display', Georgia, serif;
  --ff-body: 'DM Sans', sans-serif;
  --sidebar-w: 260px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { font-family: var(--ff-body); background: var(--cream); color: var(--brown); min-height: 100vh; display: flex; }
a { text-decoration: none; color: inherit; }

/* ── Sidebar ── */
.sidebar { width: var(--sidebar-w); min-width: var(--sidebar-w); background: var(--brown); min-height: 100vh; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; overflow-y: auto; z-index: 100; }
.sb-brand { padding: 28px 24px 22px; border-bottom: 1px solid rgba(245,237,224,.1); flex-shrink: 0; }
.sb-logo { font-family: var(--ff-head); font-size: 1.7rem; font-weight: 900; color: var(--sand); letter-spacing: -.5px; }
.sb-logo span { color: var(--gold); }
.sb-tagline { font-size: .72rem; color: rgba(245,237,224,.38); margin-top: 3px; letter-spacing: .04em; }
.sb-user { display: flex; align-items: center; gap: 12px; padding: 18px 24px; border-bottom: 1px solid rgba(245,237,224,.1); }
.sb-avatar { width: 40px; height: 40px; background: linear-gradient(135deg, var(--gold), var(--tan)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: var(--brown); flex-shrink: 0; }
.sb-user-name { font-size: .88rem; font-weight: 600; color: var(--sand); }
.sb-user-role { font-size: .73rem; color: rgba(245,237,224,.4); margin-top: 1px; }
.sb-nav { flex: 1; padding: 18px 14px; }
.sb-section { font-size: .68rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: rgba(245,237,224,.3); padding: 10px 10px 6px; margin-top: 8px; }
.sb-item { display: flex; align-items: center; gap: 11px; padding: 10px 12px; border-radius: 10px; color: rgba(245,237,224,.6); font-size: .88rem; font-weight: 500; margin-bottom: 2px; transition: all .18s; }
.sb-item svg { width: 16px; height: 16px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.sb-item:hover { background: rgba(245,237,224,.08); color: var(--sand); }
.sb-item.active { background: rgba(212,162,84,.15); color: var(--gold); font-weight: 600; }
.sb-item.active svg { stroke: var(--gold); }
.sb-footer { padding: 16px 14px; border-top: 1px solid rgba(245,237,224,.1); }
.sb-logout { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; color: rgba(245,237,224,.4); font-size: .85rem; cursor: pointer; transition: all .18s; background: none; border: none; font-family: var(--ff-body); width: 100%; }
.sb-logout svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; flex-shrink: 0; }
.sb-logout:hover { background: rgba(220,60,60,.12); color: #e07070; }

/* ── Main ── */
.main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
.topbar { background: var(--white); border-bottom: 1px solid rgba(59,42,26,.08); padding: 0 36px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
.topbar-left { display: flex; align-items: center; gap: 12px; }
.topbar-title { font-family: var(--ff-head); font-size: 1.25rem; font-weight: 700; color: var(--brown); }
.topbar-badge { font-size: .72rem; font-weight: 700; background: rgba(212,162,84,.12); color: var(--gold); padding: 3px 12px; border-radius: 20px; letter-spacing: .04em; text-transform: uppercase; border: 1px solid rgba(212,162,84,.25); }
.topbar-right { display: flex; align-items: center; gap: 14px; }
.topbar-date { font-size: .8rem; color: rgba(59,42,26,.45); }
.topbar-book { background: var(--teal); color: var(--white); padding: .5rem 1.2rem; border-radius: 50px; font-size: .82rem; font-weight: 600; display: inline-flex; align-items: center; gap: .4rem; transition: background .18s, transform .15s; }
.topbar-book:hover { background: var(--teal-lt); transform: translateY(-1px); }
.topbar-book svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }
.content { padding: 32px 36px 48px; flex: 1; }

/* ── Greeting ── */
.greeting { margin-bottom: 28px; }
.greeting-eyebrow { display: flex; align-items: center; gap: .6rem; margin-bottom: .5rem; }
.greeting-eyebrow::before { content: ''; display: block; width: 28px; height: 2px; background: var(--gold); }
.greeting-eyebrow span { font-size: .75rem; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--gold); }
.greeting h1 { font-family: var(--ff-head); font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 900; color: var(--brown); line-height: 1.15; }
.greeting h1 em { font-style: italic; color: var(--teal); }
.greeting-sub { font-size: .9rem; color: rgba(59,42,26,.55); margin-top: .4rem; }
.greeting-icon { display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; margin-left: 8px; width: 34px; height: 34px; background: rgba(212,162,84,.12); border-radius: 9px; padding: 6px; color: var(--gold); position: relative; top: -3px; }
.greeting-icon svg { width: 100%; height: 100%; }

/* ── Stats grid ── */
.stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px; }
.stat-card { background: var(--white); border-radius: var(--radius); padding: 22px 22px 20px; box-shadow: 0 2px 16px rgba(59,42,26,.06); border: 1px solid rgba(59,42,26,.07); transition: transform .2s, box-shadow .2s; position: relative; overflow: hidden; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.stat-card.teal::before  { background: var(--teal); }
.stat-card.gold::before  { background: var(--gold); }
.stat-card.tan::before   { background: var(--tan); }
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(59,42,26,.11); }
.stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
.stat-icon.teal  { background: rgba(45,110,110,.1);  color: var(--teal); }
.stat-icon.gold  { background: rgba(212,162,84,.12); color: var(--gold); }
.stat-icon.tan   { background: rgba(196,154,108,.12); color: var(--tan); }
.stat-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.stat-label { font-size: .74rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: rgba(59,42,26,.45); margin-bottom: 6px; }
.stat-value { font-family: var(--ff-head); font-size: 2rem; font-weight: 900; color: var(--brown); line-height: 1; }
.stat-sub { font-size: .75rem; color: rgba(59,42,26,.38); margin-top: 5px; }

/* ── Section header ── */
.section-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
.section-title { font-family: var(--ff-head); font-size: 1.15rem; font-weight: 700; color: var(--brown); display: flex; align-items: center; gap: 8px; }
.section-title-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
.section-sub { font-size: .83rem; color: rgba(59,42,26,.5); margin-top: 3px; }

/* ── Promo grid ── */
.promo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }

/* ── Promo card ── */
.promo-card {
  background: var(--white);
  border-radius: var(--radius);
  border: 1px solid rgba(59,42,26,.08);
  box-shadow: 0 2px 16px rgba(59,42,26,.06);
  overflow: hidden;
  transition: transform .2s, box-shadow .2s;
  display: flex;
  flex-direction: column;
}
.promo-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(59,42,26,.12); }

/* card top strip */
.promo-card-top {
  background: var(--brown);
  padding: 22px 22px 18px;
  position: relative;
  overflow: hidden;
}
.promo-card-top::before {
  content: '';
  position: absolute;
  top: -30px; right: -30px;
  width: 120px; height: 120px;
  border-radius: 50%;
  background: rgba(212,162,84,.08);
}
.promo-card-top::after {
  content: '';
  position: absolute;
  bottom: -20px; left: 40px;
  width: 80px; height: 80px;
  border-radius: 50%;
  background: rgba(245,237,224,.04);
}
.promo-card-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 18px; position: relative; z-index: 1; }
.promo-card-info {}
.promo-card-title { font-family: var(--ff-head); font-size: 1.1rem; font-weight: 700; color: var(--sand); line-height: 1.2; }
.promo-card-desc { font-size: .78rem; color: rgba(245,237,224,.45); margin-top: 4px; }
.promo-discount-badge {
  background: var(--gold);
  color: var(--brown);
  font-family: var(--ff-head);
  font-size: 1.1rem;
  font-weight: 900;
  padding: 6px 14px;
  border-radius: 10px;
  white-space: nowrap;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(212,162,84,.3);
}

/* dashed code box */
.promo-code-box {
  background: rgba(245,237,224,.06);
  border: 1.5px dashed rgba(212,162,84,.4);
  border-radius: 10px;
  padding: 12px 14px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  position: relative;
  z-index: 1;
}
.promo-code-label { font-size: .65rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(212,162,84,.6); margin-bottom: 4px; }
.promo-code-value { font-family: monospace; font-size: 1.1rem; font-weight: 700; color: var(--gold); letter-spacing: 2px; }
.promo-copy-btn {
  background: rgba(212,162,84,.15);
  border: 1px solid rgba(212,162,84,.25);
  border-radius: 8px;
  width: 34px; height: 34px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  color: var(--gold);
  transition: all .15s;
  flex-shrink: 0;
}
.promo-copy-btn:hover { background: var(--gold); color: var(--brown); }
.promo-copy-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }

/* card bottom */
.promo-card-bottom { padding: 16px 22px 20px; display: flex; flex-direction: column; gap: 14px; flex: 1; }
.promo-meta { display: flex; flex-wrap: wrap; gap: 8px; }
.promo-tag {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: .74rem; font-weight: 600;
  padding: 4px 10px; border-radius: 20px;
  background: rgba(45,110,110,.08);
  color: var(--teal);
  border: 1px solid rgba(45,110,110,.12);
}
.promo-tag svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.promo-expiry-row { display: flex; align-items: center; justify-content: space-between; }
.promo-expiry { font-size: .78rem; color: rgba(59,42,26,.45); display: flex; align-items: center; gap: 5px; }
.promo-expiry svg { width: 13px; height: 13px; stroke: rgba(59,42,26,.4); fill: none; stroke-width: 1.8; flex-shrink: 0; }
.promo-expiry strong { color: var(--gold); font-weight: 700; }
.promo-type-pill { font-size: .7rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; background: rgba(212,162,84,.1); color: var(--tan); letter-spacing: .04em; }

.promo-book-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  background: var(--teal);
  color: var(--white);
  padding: 12px;
  border-radius: 12px;
  font-size: .86rem;
  font-weight: 600;
  font-family: var(--ff-body);
  border: none;
  cursor: pointer;
  text-decoration: none;
  transition: background .18s, transform .15s;
  margin-top: auto;
}
.promo-book-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }
.promo-book-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }

/* expired card */
.promo-card.expired .promo-card-top { background: rgba(59,42,26,.65); }
.promo-card.expired .promo-discount-badge { background: rgba(59,42,26,.4); color: rgba(245,237,224,.4); box-shadow: none; }
.promo-card.expired .promo-code-value { color: rgba(212,162,84,.4); }
.promo-card.expired .promo-book-btn { background: rgba(59,42,26,.12); color: rgba(59,42,26,.4); pointer-events: none; }
.expired-overlay { font-size: .72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; background: rgba(180,60,60,.12); color: #b44444; border: 1px solid rgba(180,60,60,.2); }

/* ── Empty ── */
.empty-state { text-align: center; padding: 64px 24px; }
.empty-icon { display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; width: 56px; height: 56px; background: rgba(212,162,84,.08); border-radius: 16px; opacity: .5; color: var(--gold); }
.empty-icon svg { width: 28px; height: 28px; stroke: currentColor; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
.empty-title { font-family: var(--ff-head); font-size: 1.3rem; font-weight: 700; color: var(--brown); margin-bottom: 6px; }
.empty-sub { font-size: .88rem; color: rgba(59,42,26,.45); }

/* ── Flash ── */
.flash { margin-bottom: 22px; padding: 12px 18px; border-radius: 12px; font-size: .88rem; font-weight: 500; }
.flash-success { background: rgba(45,110,110,.08); border: 1px solid rgba(45,110,110,.2); color: var(--teal); }
.flash-error   { background: rgba(180,60,60,.07);  border: 1px solid rgba(180,60,60,.2); color: #b44444; }

/* ── Mobile ── */
.mobile-bar { display: none; background: var(--brown); padding: 14px 20px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 200; }
.hamburger { display: flex; flex-direction: column; gap: 5px; cursor: pointer; }
.hamburger span { width: 22px; height: 2px; background: var(--sand); border-radius: 2px; }
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(59,42,26,.5); z-index: 150; backdrop-filter: blur(2px); }

@media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 900px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } .promo-grid { grid-template-columns: 1fr; } }
@media (max-width: 768px)  {
  body { flex-direction: column; }
  .sidebar { position: fixed; left: -100%; top: 0; height: 100vh; transition: left .28s ease; z-index: 200; }
  .sidebar.open { left: 0; }
  .sidebar-overlay.open { display: block; }
  .mobile-bar { display: flex; }
  .topbar { display: none; }
  .content { padding: 20px 18px 36px; }
  .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
</style>
</head>
<body>

<div class="mobile-bar">
  <div class="sb-logo" style="font-size:1.3rem;font-family:'Playfair Display',serif;color:#f5ede0;">OTR<span style="color:#d4a254;">S</span></div>
  <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
</div>
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
  <div class="sb-brand">
    <div class="sb-logo">OTR<span>S</span></div>
    <div class="sb-tagline">Online Tour Reservation System</div>
  </div>
  <div class="sb-user">
    <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    <div>
      <div class="sb-user-name">{{ auth()->user()->name }}</div>
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
      <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
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
        <svg viewBox="0 0 24 24" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Sign Out
      </button>
    </form>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div class="topbar-title">Promo Codes</div>
      <span class="topbar-badge">User Portal</span>
    </div>
    <div class="topbar-right">
      <div class="topbar-date">{{ now()->format('l, F j, Y') }}</div>
      <a href="{{ route('bookings.create') }}" class="topbar-book">
        <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
        Book a Trip
      </a>
    </div>
  </div>

  <div class="content">

    @if(session('success'))
      <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="flash flash-error">{{ session('error') }}</div>
    @endif

    <div class="greeting">
      <div class="greeting-eyebrow"><span>Savings &amp; Deals</span></div>
      <h1>Promo <em>Codes</em> <span class="greeting-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 14.25l6-6"/><path d="M4.757 2C3.657 2.128 2.85 3.077 2.85 4.185V21.75l3.75-1.5 3.75 1.5 3.75-1.5 3.75 1.5V4.185c0-1.108-.807-2.057-1.907-2.185A48.507 48.507 0 0 0 4.757 2z"/></svg></span></h1>
      <div class="greeting-sub">Copy a code and paste it at checkout to save on your next booking.</div>
    </div>

    {{-- Stats --}}
    @php
      $activePromos  = $promos->where('is_active', true)->filter(fn($p) => \Carbon\Carbon::parse($p->end_date)->isFuture());
      $expiredPromos = $promos->filter(fn($p) => !\Carbon\Carbon::parse($p->end_date)->isFuture() || !$p->is_active);
      $totalSavings  = 0; // populate from your model if available
    @endphp
    <div class="stats-grid">
      <div class="stat-card teal">
        <div class="stat-icon teal">
          <svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg>
        </div>
        <div class="stat-label">Active Promos</div>
        <div class="stat-value">{{ $activePromos->count() }}</div>
        <div class="stat-sub">Available now</div>
      </div>
      <div class="stat-card gold">
        <div class="stat-icon gold">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-label">Expiring Soon</div>
        <div class="stat-value">{{ $activePromos->filter(fn($p) => \Carbon\Carbon::parse($p->end_date)->diffInDays(now()) <= 7)->count() }}</div>
        <div class="stat-sub">Within 7 days</div>
      </div>
      <div class="stat-card tan">
        <div class="stat-icon tan">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="stat-label">Total Promos</div>
        <div class="stat-value">{{ $promos->count() }}</div>
        <div class="stat-sub">All time</div>
      </div>
    </div>

    {{-- Active Promos --}}
    @if($activePromos->isNotEmpty())
    <div class="section-head">
      <div>
        <div class="section-title">
          <span class="section-title-dot"></span>
          Active Promo Codes
        </div>
        <div class="section-sub">These promos are live and ready to use on your next booking.</div>
      </div>
    </div>
    <div class="promo-grid" style="margin-bottom: 36px;">
      @foreach($activePromos as $promo)
      <div class="promo-card">
        <div class="promo-card-top">
          <div class="promo-card-header">
            <div class="promo-card-info">
              <div class="promo-card-title">{{ $promo->title }}</div>
              @if($promo->description)
                <div class="promo-card-desc">{{ $promo->description }}</div>
              @endif
            </div>
            <div class="promo-discount-badge">{{ $promo->formatted_discount ?? ($promo->discount_value . ($promo->discount_type === 'percentage' ? '%' : '₱')) }}</div>
          </div>
          <div class="promo-code-box">
            <div>
              <div class="promo-code-label">Promo Code</div>
              <div class="promo-code-value">{{ $promo->promo_code }}</div>
            </div>
            <button class="promo-copy-btn"
              onclick="copyCode('{{ $promo->promo_code }}', this)"
              title="Copy code">
              <svg viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
            </button>
          </div>
        </div>
        <div class="promo-card-bottom">
          <div class="promo-meta">
            @if($promo->applicable_to ?? null)
              <span class="promo-tag">
                <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
                {{ ucfirst($promo->applicable_to) }}
              </span>
            @else
              <span class="promo-tag">
                <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
                Valid on all trips
              </span>
            @endif
            @if($promo->min_amount ?? null)
              <span class="promo-tag" style="background:rgba(212,162,84,.08);color:var(--tan);border-color:rgba(196,154,108,.15);">
                <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Min ₱{{ number_format($promo->min_amount, 0) }}
              </span>
            @endif
          </div>
          <div class="promo-expiry-row">
            <div class="promo-expiry">
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              Expires <strong>{{ \Carbon\Carbon::parse($promo->end_date)->format('M d, Y') }}</strong>
            </div>
            <span class="promo-type-pill">{{ ucfirst($promo->discount_type ?? 'Percentage') }} off</span>
          </div>
          <a href="{{ route('bookings.create', ['promo' => $promo->promo_code]) }}" class="promo-book-btn">
            <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
            Book &amp; Use This Code →
          </a>
        </div>
      </div>
      @endforeach
    </div>
    @endif

    {{-- Expired / Inactive --}}
    @if($expiredPromos->isNotEmpty())
    <div class="section-head">
      <div>
        <div class="section-title" style="opacity:.6;">
          <span class="section-title-dot" style="background:var(--tan);"></span>
          Expired Promos
        </div>
        <div class="section-sub">These codes are no longer valid.</div>
      </div>
    </div>
    <div class="promo-grid">
      @foreach($expiredPromos as $promo)
      <div class="promo-card expired">
        <div class="promo-card-top">
          <div class="promo-card-header">
            <div class="promo-card-info">
              <div class="promo-card-title" style="opacity:.55;">{{ $promo->title }}</div>
              @if($promo->description)
                <div class="promo-card-desc">{{ $promo->description }}</div>
              @endif
            </div>
            <div class="promo-discount-badge">{{ $promo->formatted_discount ?? ($promo->discount_value . ($promo->discount_type === 'percentage' ? '%' : '₱')) }}</div>
          </div>
          <div class="promo-code-box" style="opacity:.5;">
            <div>
              <div class="promo-code-label">Promo Code</div>
              <div class="promo-code-value">{{ $promo->promo_code }}</div>
            </div>
          </div>
        </div>
        <div class="promo-card-bottom">
          <div class="promo-expiry-row">
            <div class="promo-expiry" style="color:rgba(180,60,60,.6);">
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              Expired <strong style="color:#b44444;">{{ \Carbon\Carbon::parse($promo->end_date)->format('M d, Y') }}</strong>
            </div>
            <span class="expired-overlay">Expired</span>
          </div>
          <div class="promo-book-btn" style="cursor:not-allowed;opacity:.4;">Code No Longer Valid</div>
        </div>
      </div>
      @endforeach
    </div>
    @endif

    {{-- Empty state --}}
    @if($promos->isEmpty())
    <div class="empty-state">
      <div class="empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 14.25l6-6"/><path d="M4.757 2C3.657 2.128 2.85 3.077 2.85 4.185V21.75l3.75-1.5 3.75 1.5 3.75-1.5 3.75 1.5V4.185c0-1.108-.807-2.057-1.907-2.185A48.507 48.507 0 0 0 4.757 2z"/></svg></div>
      <div class="empty-title">No promo codes yet</div>
      <div class="empty-sub">Check back soon — exclusive deals are on the way!</div>
    </div>
    @endif

  </div>
</div>

<script>
  const sidebar   = document.getElementById('sidebar');
  const overlay   = document.getElementById('overlay');
  const hamburger = document.getElementById('hamburger');
  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
  });
  function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
  }
  function copyCode(code, btn) {
    navigator.clipboard.writeText(code).then(() => {
      const orig = btn.innerHTML;
      btn.innerHTML = '<svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round;"><polyline points="20 6 9 17 4 12"/></svg>';
      btn.style.background = 'var(--gold)';
      btn.style.color = 'var(--brown)';
      setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; btn.style.color = ''; }, 1800);
    });
  }
</script>
</body>
</html>