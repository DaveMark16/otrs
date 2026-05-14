<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>OTRS — Payments & Refunds</title>
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
.topbar-badge { font-size: .72rem; font-weight: 700; background: rgba(45,110,110,.1); color: var(--teal); padding: 3px 12px; border-radius: 20px; letter-spacing: .04em; text-transform: uppercase; border: 1px solid rgba(45,110,110,.15); }
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
.greeting-icon { display: inline-flex; align-items: center; justify-content: center; vertical-align: middle; margin-left: 8px; width: 34px; height: 34px; background: rgba(45,110,110,.1); border-radius: 9px; padding: 6px; color: var(--teal); position: relative; top: -3px; }
.greeting-icon svg { width: 100%; height: 100%; }

/* ── Stats grid ── */
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
.stat-card { background: var(--white); border-radius: var(--radius); padding: 22px 22px 20px; box-shadow: 0 2px 16px rgba(59,42,26,.06); border: 1px solid rgba(59,42,26,.07); transition: transform .2s, box-shadow .2s; position: relative; overflow: hidden; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.stat-card.teal::before  { background: var(--teal); }
.stat-card.gold::before  { background: var(--gold); }
.stat-card.tan::before   { background: var(--tan); }
.stat-card.red::before   { background: #c0392b; }
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(59,42,26,.11); }
.stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
.stat-icon.teal  { background: rgba(45,110,110,.1);  color: var(--teal); }
.stat-icon.gold  { background: rgba(212,162,84,.12); color: var(--gold); }
.stat-icon.tan   { background: rgba(196,154,108,.12); color: var(--tan); }
.stat-icon.red   { background: rgba(192,57,43,.08);  color: #c0392b; }
.stat-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.stat-label { font-size: .74rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: rgba(59,42,26,.45); margin-bottom: 6px; }
.stat-value { font-family: var(--ff-head); font-size: 1.7rem; font-weight: 900; color: var(--brown); line-height: 1; }
.stat-sub { font-size: .75rem; color: rgba(59,42,26,.38); margin-top: 5px; }

/* ── Panel ── */
.panel { background: var(--white); border-radius: var(--radius); box-shadow: 0 2px 16px rgba(59,42,26,.06); border: 1px solid rgba(59,42,26,.07); overflow: hidden; }
.panel-head { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px 0; margin-bottom: 16px; }
.panel-title { font-family: var(--ff-head); font-size: 1.05rem; font-weight: 700; color: var(--brown); display: flex; align-items: center; gap: 8px; }
.panel-title-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
.panel-sub { font-size: .78rem; color: rgba(59,42,26,.4); margin-top: 2px; padding: 0 24px; margin-bottom: 16px; }

/* ── Table ── */
.tbl-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; min-width: 860px; }
thead tr { border-bottom: 2px solid rgba(59,42,26,.08); }
thead th { padding: 10px 16px; font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(59,42,26,.4); text-align: left; white-space: nowrap; }
tbody tr { border-bottom: 1px solid rgba(59,42,26,.06); transition: background .15s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: rgba(245,237,224,.4); }
tbody td { padding: 14px 16px; font-size: .86rem; color: var(--brown); vertical-align: middle; }

/* ref numbers */
.ref-no { font-family: monospace; font-size: .76rem; font-weight: 700; color: var(--teal); letter-spacing: .3px; }
.ref-no.booking { color: rgba(59,42,26,.5); }

/* route */
.route-wrap { }
.route-main { font-size: .86rem; font-weight: 600; color: var(--brown); }
.route-country { font-size: .72rem; color: rgba(59,42,26,.4); margin-top: 2px; }

/* amount */
.amount-cell { font-family: var(--ff-head); font-size: .95rem; font-weight: 700; color: var(--brown); white-space: nowrap; }
.amount-cell.refunded { color: #c0392b; }

/* method */
.method-pill { display: inline-flex; align-items: center; gap: 5px; font-size: .78rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; background: rgba(45,110,110,.07); color: var(--teal); border: 1px solid rgba(45,110,110,.12); white-space: nowrap; }
.method-pill svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

/* status badge */
.status-badge { font-size: .72rem; font-weight: 700; padding: 4px 11px; border-radius: 20px; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; letter-spacing: .02em; }
.status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.status-paid      { background: rgba(45,110,110,.1);  color: var(--teal); }
.status-paid::before      { background: var(--teal); }
.status-pending   { background: rgba(212,162,84,.12); color: #a07830; }
.status-pending::before   { background: var(--gold); }
.status-refunded  { background: rgba(192,57,43,.08);  color: #c0392b; }
.status-refunded::before  { background: #c0392b; }
.status-failed    { background: rgba(180,60,60,.08);  color: #b44444; }
.status-failed::before    { background: #b44444; }

/* date cell */
.date-main { font-size: .83rem; font-weight: 600; color: var(--brown); }
.date-time { font-size: .72rem; color: rgba(59,42,26,.4); margin-top: 2px; }
.date-empty { color: rgba(59,42,26,.25); font-size: .82rem; }

/* action buttons */
.action-btns { display: flex; align-items: center; gap: 6px; }
.btn-view { font-size: .78rem; font-weight: 600; color: var(--teal); padding: 5px 13px; border-radius: 50px; border: 1.5px solid rgba(45,110,110,.25); background: transparent; cursor: pointer; font-family: var(--ff-body); transition: all .15s; white-space: nowrap; text-decoration: none; display: inline-block; }
.btn-view:hover { background: var(--teal); color: var(--white); border-color: var(--teal); }
.btn-refund { font-size: .78rem; font-weight: 600; color: #c0392b; padding: 5px 13px; border-radius: 50px; border: 1.5px solid rgba(192,57,43,.25); background: transparent; cursor: pointer; font-family: var(--ff-body); transition: all .15s; white-space: nowrap; display: inline-flex; align-items: center; gap: 4px; }
.btn-refund:hover { background: rgba(192,57,43,.08); border-color: rgba(192,57,43,.4); }
.btn-refund svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }
.btn-refunded-label { font-size: .78rem; color: rgba(59,42,26,.3); font-style: italic; }

/* empty */
.empty { text-align: center; padding: 48px 16px; color: rgba(59,42,26,.35); font-size: .88rem; }
.empty-icon { display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; width: 52px; height: 52px; background: rgba(59,42,26,.05); border-radius: 14px; opacity: .45; color: var(--brown); }
.empty-icon svg { width: 26px; height: 26px; stroke: currentColor; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }

/* pagination */
.pagination { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; padding: 20px 24px; border-top: 1px solid rgba(59,42,26,.07); }
.pag-info { font-size: .8rem; color: rgba(59,42,26,.45); }
.pag-links { display: flex; gap: 4px; }
.pag-btn { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: .82rem; font-weight: 600; border: 1.5px solid rgba(59,42,26,.1); color: rgba(59,42,26,.55); background: var(--white); cursor: pointer; transition: all .15s; text-decoration: none; }
.pag-btn:hover { border-color: rgba(45,110,110,.3); color: var(--teal); }
.pag-btn.active { background: var(--teal); color: var(--white); border-color: var(--teal); }
.pag-btn.disabled { opacity: .35; pointer-events: none; }

/* flash */
.flash { margin-bottom: 22px; padding: 12px 18px; border-radius: 12px; font-size: .88rem; font-weight: 500; }
.flash-success { background: rgba(45,110,110,.08); border: 1px solid rgba(45,110,110,.2); color: var(--teal); }
.flash-error   { background: rgba(180,60,60,.07);  border: 1px solid rgba(180,60,60,.2); color: #b44444; }

/* mobile */
.mobile-bar { display: none; background: var(--brown); padding: 14px 20px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 200; }
.hamburger { display: flex; flex-direction: column; gap: 5px; cursor: pointer; }
.hamburger span { width: 22px; height: 2px; background: var(--sand); border-radius: 2px; }
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(59,42,26,.5); z-index: 150; backdrop-filter: blur(2px); }

@media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
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
      <div class="topbar-title">Payments &amp; Refunds</div>
      <span class="topbar-badge">Transaction History</span>
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
      <div class="greeting-eyebrow"><span>Finance</span></div>
      <h1>Payments &amp; <em>Refunds</em> <span class="greeting-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="3"/><line x1="1" y1="10" x2="23" y2="10"/><line x1="6" y1="15" x2="10" y2="15"/><line x1="13" y1="15" x2="15" y2="15"/></svg></span></h1>
      <div class="greeting-sub">Your complete transaction history, all in one place.</div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
      <div class="stat-card teal">
        <div class="stat-icon teal">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="stat-label">Total Paid</div>
        <div class="stat-value">₱{{ number_format($totalPaid ?? 0, 2) }}</div>
        <div class="stat-sub">Successful payments</div>
      </div>
      <div class="stat-card gold">
        <div class="stat-icon gold">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-label">Pending</div>
        <div class="stat-value">{{ $pendingCount ?? 0 }}</div>
        <div class="stat-sub">Awaiting confirmation</div>
      </div>
      <div class="stat-card red">
        <div class="stat-icon red">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        </div>
        <div class="stat-label">Failed</div>
        <div class="stat-value">{{ $failedCount ?? 0 }}</div>
        <div class="stat-sub">Payment attempts</div>
      </div>
      <div class="stat-card tan">
        <div class="stat-icon tan">
          <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.71"/></svg>
        </div>
        <div class="stat-label">Refunded</div>
        <div class="stat-value">₱{{ number_format($totalRefunded ?? 0, 2) }}</div>
        <div class="stat-sub">Refunded amount</div>
      </div>
    </div>

    {{-- Transactions table --}}
    <div class="panel">
      <div class="panel-head">
        <div class="panel-title">
          <span class="panel-title-dot"></span>
          Transaction History
        </div>
      </div>
      <div class="panel-sub">All payment and refund records for your account.</div>

      <div class="tbl-wrap">
        <table>
          <thead>
            <tr>
              <th>Transaction Ref</th>
              <th>Booking Ref</th>
              <th>Route</th>
              <th>Amount</th>
              <th>Method</th>
              <th>Status</th>
              <th>Paid At</th>
              <th>Refund Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($payments as $payment)
              @php
                $booking = $payment->booking;
                $sched   = $booking?->schedule;
                $trip    = $sched?->trip;
                $st      = strtolower($payment->status ?? 'pending');
                $stClass = match($st) {
                  'paid'      => 'status-paid',
                  'refunded'  => 'status-refunded',
                  'failed'    => 'status-failed',
                  default     => 'status-pending',
                };
              @endphp
              <tr>
                {{-- Transaction ref --}}
                <td><span class="ref-no">{{ $payment->transaction_ref ?? $payment->id }}</span></td>

                {{-- Booking ref --}}
                <td><span class="ref-no booking">{{ $booking?->booking_ref ?? ($booking?->id ?? '—') }}</span></td>

                {{-- Route --}}
                <td>
                  @if($trip)
                    <div class="route-main">{{ $trip->origin ?? '?' }} → {{ $trip->destination ?? '?' }}</div>
                    @if($trip->origin_country ?? null)
                      <div class="route-country">{{ $trip->origin_country }} → {{ $trip->destination_country ?? '' }}</div>
                    @endif
                  @else
                    <span style="color:rgba(59,42,26,.3);">—</span>
                  @endif
                </td>

                {{-- Amount --}}
                <td>
                  <span class="amount-cell {{ $st === 'refunded' ? 'refunded' : '' }}">
                    ₱{{ number_format($payment->amount ?? 0, 2) }}
                  </span>
                </td>

                {{-- Method --}}
                <td>
                  <span class="method-pill">
                    <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    {{ $payment->payment_method ?? 'GCash' }}
                  </span>
                </td>

                {{-- Status --}}
                <td><span class="status-badge {{ $stClass }}">{{ ucfirst($st) }}</span></td>

                {{-- Paid at --}}
                <td>
                  @if($payment->paid_at ?? null)
                    <div class="date-main">{{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y') }}</div>
                    <div class="date-time">{{ \Carbon\Carbon::parse($payment->paid_at)->format('h:i A') }}</div>
                  @else
                    <span class="date-empty">—</span>
                  @endif
                </td>

                {{-- Refund date --}}
                <td>
                  @if($payment->refunded_at ?? null)
                    <div class="date-main">{{ \Carbon\Carbon::parse($payment->refunded_at)->format('M d, Y') }}</div>
                    <div class="date-time">{{ \Carbon\Carbon::parse($payment->refunded_at)->format('h:i A') }}</div>
                  @else
                    <span class="date-empty">—</span>
                  @endif
                </td>

                {{-- Actions --}}
                <td>
                  <div class="action-btns">
                    <a href="{{ route('payments.show', $payment) }}" class="btn-view">View</a>
                    @if($st === 'paid')
                      <form method="POST" action="{{ route('payments.refund', $payment) }}" onsubmit="return confirm('Request a refund for this payment?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-refund">
                          <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.71"/></svg>
                          Refund
                        </button>
                      </form>
                    @elseif($st === 'refunded')
                      <span class="btn-refunded-label">Refunded</span>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9">
                  <div class="empty">
                    <div class="empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="3"/><line x1="1" y1="10" x2="23" y2="10"/><line x1="6" y1="15" x2="10" y2="15"/><line x1="13" y1="15" x2="15" y2="15"/></svg></div>
                    No transactions found. <a href="{{ route('bookings.create') }}" style="color:var(--teal);font-weight:600;">Book a trip to get started →</a>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($payments instanceof \Illuminate\Pagination\LengthAwarePaginator && $payments->hasPages())
        <div class="pagination">
          <div class="pag-info">Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }} transactions</div>
          <div class="pag-links">
            <a href="{{ $payments->previousPageUrl() ?? '#' }}" class="pag-btn {{ $payments->onFirstPage() ? 'disabled' : '' }}">‹</a>
            @foreach($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
              <a href="{{ $url }}" class="pag-btn {{ $page === $payments->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
            <a href="{{ $payments->nextPageUrl() ?? '#' }}" class="pag-btn {{ !$payments->hasMorePages() ? 'disabled' : '' }}">›</a>
          </div>
        </div>
      @endif
    </div>

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
</script>
</body>
</html>