<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>OTRS — Payment Details</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<style>
/* ── Design tokens (identical to payments/index) ── */
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

/* ── Sidebar (copy-exact from index) ── */
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

/* ── Main layout ── */
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

/* ── Flash messages ── */
.flash { margin-bottom: 22px; padding: 12px 18px; border-radius: 12px; font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.flash-success { background: rgba(45,110,110,.08); border: 1px solid rgba(45,110,110,.2); color: var(--teal); }
.flash-error   { background: rgba(180,60,60,.07);  border: 1px solid rgba(180,60,60,.2); color: #b44444; }
.flash svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; flex-shrink: 0; }

/* ── Breadcrumb ── */
.breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 24px; font-size: .82rem; color: rgba(59,42,26,.45); }
.breadcrumb a { color: rgba(59,42,26,.45); transition: color .15s; }
.breadcrumb a:hover { color: var(--teal); }
.breadcrumb-sep { opacity: .4; }
.breadcrumb-current { color: var(--teal); font-weight: 600; font-family: monospace; font-size: .78rem; letter-spacing: .3px; }

/* ── Page heading ── */
.page-heading { margin-bottom: 24px; }
.page-heading-eyebrow { display: flex; align-items: center; gap: .6rem; margin-bottom: .45rem; }
.page-heading-eyebrow::before { content: ''; display: block; width: 28px; height: 2px; background: var(--gold); }
.page-heading-eyebrow span { font-size: .75rem; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--gold); }
.page-heading h1 { font-family: var(--ff-head); font-size: clamp(1.4rem, 2.5vw, 1.9rem); font-weight: 900; color: var(--brown); line-height: 1.15; }
.page-heading h1 em { font-style: italic; color: var(--teal); }

/* ── Status banner ── */
.status-banner { display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-radius: 14px; font-size: .9rem; font-weight: 600; margin-bottom: 24px; }
.status-banner svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; flex-shrink: 0; }
.status-banner-label { margin-left: auto; font-size: .75rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; opacity: .8; }
.banner-paid     { background: rgba(45,110,110,.08);  border: 1px solid rgba(45,110,110,.2);  color: var(--teal); }
.banner-refunded { background: rgba(192,57,43,.07);   border: 1px solid rgba(192,57,43,.2);   color: #c0392b; }
.banner-pending  { background: rgba(212,162,84,.1);   border: 1px solid rgba(212,162,84,.25); color: #9a6f20; }
.banner-failed   { background: rgba(180,60,60,.07);   border: 1px solid rgba(180,60,60,.2);   color: #b44444; }

/* ── Two-column grid ── */
.detail-grid { display: grid; grid-template-columns: 1.35fr 1fr; gap: 20px; align-items: start; }
@media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }

/* ── Panel (identical to index) ── */
.panel { background: var(--white); border-radius: var(--radius); box-shadow: 0 2px 16px rgba(59,42,26,.06); border: 1px solid rgba(59,42,26,.07); overflow: hidden; margin-bottom: 18px; }
.panel:last-child { margin-bottom: 0; }
.panel-head { display: flex; align-items: center; gap: 14px; padding: 20px 24px 0; margin-bottom: 0; }
.panel-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.panel-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.panel-icon.teal  { background: rgba(45,110,110,.1);   color: var(--teal); }
.panel-icon.gold  { background: rgba(212,162,84,.12);  color: var(--gold); }
.panel-icon.tan   { background: rgba(196,154,108,.12); color: var(--tan);  }
.panel-icon.red   { background: rgba(192,57,43,.08);   color: #c0392b; }
.panel-title { font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: var(--brown); }
.panel-sub-text { font-size: .78rem; color: rgba(59,42,26,.4); margin-top: 2px; }
.panel-divider { height: 1px; background: rgba(59,42,26,.07); margin: 16px 24px 0; }

/* ── Detail rows ── */
.detail-rows { padding: 4px 24px 20px; }
.detail-row { display: flex; justify-content: space-between; align-items: center; padding: 11px 0; border-bottom: 1px solid rgba(59,42,26,.05); font-size: .875rem; }
.detail-row:last-child { border-bottom: none; }
.d-key { color: rgba(59,42,26,.45); font-size: .78rem; font-weight: 600; letter-spacing: .02em; text-transform: uppercase; min-width: 140px; flex-shrink: 0; }
.d-val { color: var(--brown); font-weight: 500; text-align: right; }
.d-val.mono { font-family: monospace; font-size: .8rem; font-weight: 700; color: var(--teal); letter-spacing: .3px; }
.d-val.mono-tan { font-family: monospace; font-size: .8rem; font-weight: 700; color: rgba(59,42,26,.5); letter-spacing: .3px; }

/* ── Status badges (identical to index) ── */
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
.status-confirmed { background: rgba(45,110,110,.1);  color: var(--teal); }
.status-confirmed::before { background: var(--teal); }
.status-cancelled { background: rgba(192,57,43,.08);  color: #c0392b; }
.status-cancelled::before { background: #c0392b; }
.status-ticketed  { background: rgba(212,162,84,.12); color: #a07830; }
.status-ticketed::before  { background: var(--gold); }

/* ── Amount card ── */
.amount-panel { background: var(--white); border-radius: var(--radius); box-shadow: 0 2px 16px rgba(59,42,26,.06); border: 1px solid rgba(59,42,26,.07); overflow: hidden; margin-bottom: 18px; padding: 28px 24px 24px; text-align: center; }
.amount-eyebrow { font-size: .7rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: rgba(59,42,26,.35); margin-bottom: 12px; }
.amount-value { font-family: var(--ff-head); font-size: 2.4rem; font-weight: 900; color: var(--brown); line-height: 1; }
.amount-value.refunded { color: #c0392b; }
.amount-value.paid     { color: var(--teal); }
.amount-meta { font-size: .78rem; color: rgba(59,42,26,.4); margin-top: 10px; }
.amount-status { margin-top: 16px; }
.amount-status .status-badge { font-size: .8rem; padding: 6px 18px; }

/* ── Ticket rows ── */
.ticket-list { padding: 0 24px 20px; }
.ticket-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: rgba(59,42,26,.025); border: 1px solid rgba(59,42,26,.07); border-radius: 10px; margin-bottom: 10px; }
.ticket-item:last-child { margin-bottom: 0; }
.ticket-no   { font-family: monospace; font-size: .76rem; font-weight: 700; color: var(--teal); letter-spacing: .3px; }
.ticket-name { font-size: .86rem; font-weight: 600; color: var(--brown); margin-top: 3px; }
.ticket-tags { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; justify-content: flex-end; }
.fare-badge  { font-size: .7rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
.fare-eco   { background: rgba(45,110,110,.1);   color: var(--teal); }
.fare-biz   { background: rgba(212,162,84,.12);  color: #9a6f20; }
.fare-first { background: rgba(196,154,108,.12); color: #8b5e30; }

/* ── Refund info panel ── */
.refund-panel-inner { padding: 0 24px 20px; }
.refund-ref { font-family: monospace; font-size: .8rem; font-weight: 700; color: #c0392b; letter-spacing: .3px; }

/* ── Action buttons ── */
.action-row { display: flex; align-items: center; justify-content: flex-end; gap: 10px; flex-wrap: wrap; }
.btn-back { display: inline-flex; align-items: center; gap: 7px; padding: .5rem 1.2rem; border-radius: 50px; border: 1.5px solid rgba(59,42,26,.15); background: transparent; color: rgba(59,42,26,.55); font-size: .82rem; font-weight: 600; font-family: var(--ff-body); cursor: pointer; transition: all .18s; text-decoration: none; }
.btn-back svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }
.btn-back:hover { border-color: rgba(59,42,26,.3); color: var(--brown); background: rgba(59,42,26,.04); }
.btn-booking { display: inline-flex; align-items: center; gap: 7px; padding: .5rem 1.2rem; border-radius: 50px; border: 1.5px solid rgba(45,110,110,.25); color: var(--teal); background: transparent; font-size: .82rem; font-weight: 600; font-family: var(--ff-body); cursor: pointer; transition: all .18s; text-decoration: none; }
.btn-booking svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }
.btn-booking:hover { background: var(--teal); color: var(--white); border-color: var(--teal); }
.btn-refund { display: inline-flex; align-items: center; gap: 7px; padding: .5rem 1.2rem; border-radius: 50px; border: 1.5px solid rgba(192,57,43,.25); color: #c0392b; background: transparent; font-size: .82rem; font-weight: 600; font-family: var(--ff-body); cursor: pointer; transition: all .18s; }
.btn-refund svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }
.btn-refund:hover { background: rgba(192,57,43,.07); border-color: rgba(192,57,43,.4); }

/* ── Refund Modal ── */
.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(59,42,26,.55); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(3px); }
.modal-overlay.open { display: flex; }
.modal { background: var(--white); border-radius: 20px; padding: 32px; width: 100%; max-width: 480px; position: relative; box-shadow: 0 24px 64px rgba(59,42,26,.2); }
.modal-close { position: absolute; top: 16px; right: 16px; background: rgba(59,42,26,.06); border: none; color: rgba(59,42,26,.4); width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: all .15s; }
.modal-close:hover { background: rgba(59,42,26,.1); color: var(--brown); }
.modal-title { font-family: var(--ff-head); font-size: 1.2rem; font-weight: 900; color: var(--brown); margin-bottom: 4px; }
.modal-sub { font-size: .82rem; color: rgba(59,42,26,.45); margin-bottom: 22px; }
.modal-info { background: var(--cream); border: 1px solid rgba(59,42,26,.08); border-radius: 12px; padding: 14px 16px; margin-bottom: 18px; }
.modal-info-row { display: flex; justify-content: space-between; align-items: center; font-size: .83rem; padding: 5px 0; border-bottom: 1px solid rgba(59,42,26,.06); }
.modal-info-row:last-child { border-bottom: none; }
.modal-info-k { color: rgba(59,42,26,.45); font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
.modal-info-v { color: var(--brown); font-weight: 600; }
.modal-info-v.mono { font-family: monospace; font-size: .78rem; color: var(--teal); }
.modal-info-v.amount { font-family: var(--ff-head); font-size: 1rem; font-weight: 900; color: #c0392b; }
.warn-box { background: rgba(212,162,84,.08); border: 1px solid rgba(212,162,84,.25); border-radius: 10px; padding: 12px 14px; font-size: .82rem; color: #9a6f20; line-height: 1.6; margin-bottom: 18px; }
.f-label { font-size: .75rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: rgba(59,42,26,.5); margin-bottom: 7px; display: block; }
.f-textarea { width: 100%; background: var(--cream); border: 1px solid rgba(59,42,26,.15); border-radius: 10px; padding: 12px 14px; font-size: .88rem; color: var(--brown); outline: none; font-family: var(--ff-body); resize: vertical; min-height: 90px; transition: border-color .15s; }
.f-textarea:focus { border-color: var(--teal); }
.f-error { color: #b44444; font-size: .78rem; margin-top: 5px; }
.modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }
.btn-modal-cancel { background: transparent; color: rgba(59,42,26,.5); border: 1.5px solid rgba(59,42,26,.15); border-radius: 50px; padding: .5rem 1.3rem; font-size: .84rem; font-weight: 600; cursor: pointer; font-family: var(--ff-body); transition: all .15s; }
.btn-modal-cancel:hover { border-color: rgba(59,42,26,.3); color: var(--brown); }
.btn-modal-confirm { background: #c0392b; color: #fff; border: none; border-radius: 50px; padding: .5rem 1.5rem; font-size: .84rem; font-weight: 700; cursor: pointer; font-family: var(--ff-body); transition: background .15s; }
.btn-modal-confirm:hover { background: #a93226; }

/* ── Mobile ── */
.mobile-bar { display: none; background: var(--brown); padding: 14px 20px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 200; }
.hamburger { display: flex; flex-direction: column; gap: 5px; cursor: pointer; }
.hamburger span { width: 22px; height: 2px; background: var(--sand); border-radius: 2px; }
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(59,42,26,.5); z-index: 150; backdrop-filter: blur(2px); }

@media (max-width: 768px) {
  body { flex-direction: column; }
  .sidebar { position: fixed; left: -100%; top: 0; height: 100vh; transition: left .28s ease; z-index: 200; }
  .sidebar.open { left: 0; }
  .sidebar-overlay.open { display: block; }
  .mobile-bar { display: flex; }
  .topbar { display: none; }
  .content { padding: 20px 18px 36px; }
  .detail-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

{{-- Mobile bar --}}
<div class="mobile-bar">
  <div class="sb-logo" style="font-size:1.3rem;font-family:'Playfair Display',serif;color:#f5ede0;">OTR<span style="color:#d4a254;">S</span></div>
  <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
</div>
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

{{-- ── Sidebar ── --}}
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

{{-- ── Main ── --}}
<div class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div class="topbar-title">Payment Details</div>
      <span class="topbar-badge">Transaction Record</span>
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

    {{-- Flash messages --}}
    @if(session('success'))
      <div class="flash flash-success">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="flash flash-error">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
      </div>
    @endif

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
      <a href="{{ route('payments.index') }}">Payments &amp; Refunds</a>
      <span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current">{{ $payment->transaction_ref ?? 'Payment Details' }}</span>
    </div>

    {{-- Page heading --}}
    <div class="page-heading">
      <div class="page-heading-eyebrow"><span>Finance</span></div>
      <h1>Payment <em>Details</em></h1>
    </div>

    {{-- Status banner --}}
    @php $s = strtolower($payment->status ?? 'pending'); @endphp
    <div class="status-banner {{ $s === 'paid' ? 'banner-paid' : ($s === 'refunded' ? 'banner-refunded' : ($s === 'pending' ? 'banner-pending' : 'banner-failed')) }}">
      @if($s === 'paid')
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        Payment Successful
      @elseif($s === 'refunded')
        <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.71"/></svg>
        Refund Processed
      @elseif($s === 'pending')
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Payment Pending — Awaiting Confirmation
      @else
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        Payment Failed
      @endif
      <span class="status-banner-label">{{ ucfirst($s) }}</span>
    </div>

    {{-- Two-column detail grid --}}
    <div class="detail-grid">

      {{-- ── LEFT COLUMN ── --}}
      <div>

        {{-- Transaction Details --}}
        <div class="panel">
          <div class="panel-head">
            <div class="panel-icon teal">
              <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div>
              <div class="panel-title">Transaction Details</div>
              <div class="panel-sub-text">Payment record information</div>
            </div>
          </div>
          <div class="panel-divider"></div>
          <div class="detail-rows">
            <div class="detail-row">
              <span class="d-key">Transaction Ref</span>
              <span class="d-val mono">{{ $payment->transaction_ref ?? '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Booking Ref</span>
              <span class="d-val mono-tan">{{ $payment->booking->reference_no ?? '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Payment Method</span>
              <span class="d-val">{{ ucfirst($payment->method ?? '—') }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Currency</span>
              <span class="d-val">{{ strtoupper($payment->currency ?? 'PHP') }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Status</span>
              <span class="d-val">
                <span class="status-badge status-{{ $s }}">{{ ucfirst($s) }}</span>
              </span>
            </div>
            <div class="detail-row">
              <span class="d-key">Attempts</span>
              <span class="d-val">{{ $payment->attempts ?? 1 }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Paid At</span>
              <span class="d-val">{{ $payment->paid_at ? $payment->paid_at->format('M d, Y h:i A') : '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Created</span>
              <span class="d-val">{{ $payment->created_at->format('M d, Y h:i A') }}</span>
            </div>
          </div>
        </div>

        {{-- Trip Information --}}
        <div class="panel">
          <div class="panel-head">
            <div class="panel-icon gold">
              <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
            </div>
            <div>
              <div class="panel-title">Trip Information</div>
              <div class="panel-sub-text">Booking &amp; schedule details</div>
            </div>
          </div>
          <div class="panel-divider"></div>
          <div class="detail-rows">
            <div class="detail-row">
              <span class="d-key">Trip Name</span>
              <span class="d-val">{{ $payment->booking->schedule->trip->name ?? '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Route</span>
              <span class="d-val">
                {{ $payment->booking->schedule->trip->origin ?? '?' }}
                @if($payment->booking->schedule->trip->origin_country ?? null)
                  <span style="color:rgba(59,42,26,.4);font-size:.78rem">, {{ $payment->booking->schedule->trip->origin_country }}</span>
                @endif
                →
                {{ $payment->booking->schedule->trip->destination ?? '?' }}
                @if($payment->booking->schedule->trip->destination_country ?? null)
                  <span style="color:rgba(59,42,26,.4);font-size:.78rem">, {{ $payment->booking->schedule->trip->destination_country }}</span>
                @endif
              </span>
            </div>
            <div class="detail-row">
              <span class="d-key">Operator</span>
              <span class="d-val">{{ $payment->booking->schedule->trip->operator ?? '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Departure</span>
              <span class="d-val">{{ $payment->booking->schedule->departure_at?->format('M d, Y h:i A') ?? '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Fare Class</span>
              <span class="d-val">{{ ucfirst($payment->booking->schedule->fare_class ?? '—') }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Passengers</span>
              <span class="d-val">{{ $payment->booking->passenger_count ?? '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Contact Email</span>
              <span class="d-val" style="font-size:.82rem;">{{ $payment->booking->contact_email ?? '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Booking Status</span>
              <span class="d-val">
                @php $bs = strtolower($payment->booking->status ?? 'unknown'); @endphp
                <span class="status-badge status-{{ in_array($bs, ['paid','pending','refunded','failed','confirmed','cancelled','ticketed']) ? $bs : 'pending' }}">
                  {{ ucfirst($bs) }}
                </span>
              </span>
            </div>
          </div>
        </div>

        {{-- Refund Details (only when refunded) --}}
        @if($s === 'refunded')
        <div class="panel">
          <div class="panel-head">
            <div class="panel-icon red">
              <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.71"/></svg>
            </div>
            <div>
              <div class="panel-title">Refund Details</div>
              <div class="panel-sub-text">Refund transaction information</div>
            </div>
          </div>
          <div class="panel-divider"></div>
          <div class="detail-rows">
            <div class="detail-row">
              <span class="d-key">Refund Ref</span>
              <span class="d-val"><span class="refund-ref">{{ $payment->refund_ref ?? '—' }}</span></span>
            </div>
            <div class="detail-row">
              <span class="d-key">Refund Date</span>
              <span class="d-val">{{ $payment->refund_date ? $payment->refund_date->format('M d, Y h:i A') : '—' }}</span>
            </div>
            <div class="detail-row">
              <span class="d-key">Reason</span>
              <span class="d-val" style="font-size:.82rem;max-width:260px;text-align:right;line-height:1.5;">{{ $payment->refund_reason ?? '—' }}</span>
            </div>
          </div>
        </div>
        @endif

      </div>

      {{-- ── RIGHT COLUMN ── --}}
      <div>

        {{-- Amount Card --}}
        <div class="amount-panel">
          <div class="amount-eyebrow">Total Amount</div>
          <div class="amount-value {{ $s === 'refunded' ? 'refunded' : ($s === 'paid' ? 'paid' : '') }}">
            ₱{{ number_format($payment->amount, 2) }}
          </div>
          <div class="amount-meta">
            {{ $payment->booking->passenger_count ?? 1 }} pax
            &nbsp;×&nbsp;
            ₱{{ number_format($payment->booking->schedule->base_fare ?? 0, 2) }} base fare
          </div>
          <div class="amount-status">
            <span class="status-badge status-{{ $s }}" style="font-size:.8rem;padding:6px 18px;">
              {{ strtoupper($s) }}
            </span>
          </div>
        </div>

        {{-- Issued Tickets --}}
        @if($payment->booking->tickets && $payment->booking->tickets->count() > 0)
        <div class="panel">
          <div class="panel-head">
            <div class="panel-icon tan">
              <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
            </div>
            <div>
              <div class="panel-title">Issued Tickets</div>
              <div class="panel-sub-text">{{ $payment->booking->tickets->count() }} ticket(s) for this booking</div>
            </div>
          </div>
          <div class="panel-divider"></div>
          <div class="ticket-list" style="padding-top:14px;">
            @foreach($payment->booking->tickets as $ticket)
            <div class="ticket-item">
              <div>
                <div class="ticket-no">{{ $ticket->ticket_no }}</div>
                <div class="ticket-name">{{ $ticket->passenger_name }}</div>
              </div>
              <div class="ticket-tags">
                <span class="fare-badge {{ $ticket->fare_class === 'business' ? 'fare-biz' : ($ticket->fare_class === 'first' ? 'fare-first' : 'fare-eco') }}">
                  {{ ucfirst($ticket->fare_class ?? 'Economy') }}
                </span>
                @php $ts = strtolower($ticket->status ?? 'issued'); @endphp
                <span class="status-badge status-{{ in_array($ts, ['paid','pending','refunded','failed','confirmed','cancelled','ticketed']) ? $ts : 'pending' }}" style="font-size:.68rem;padding:3px 9px;">
                  {{ ucfirst($ts) }}
                </span>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        {{-- Action buttons --}}
        <div class="action-row" style="margin-top: 6px;">
          <a href="{{ route('payments.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back
          </a>
          @if($payment->booking)
          <a href="{{ route('bookings.show', $payment->booking->id) }}" class="btn-booking">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            View Booking
          </a>
          @endif
          @if($s === 'paid')
          <button type="button" class="btn-refund" onclick="openRefundModal()">
            <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.71"/></svg>
            Request Refund
          </button>
          @endif
        </div>

      </div>
    </div>
  </div>
</div>

{{-- ── Refund Modal ── --}}
@if($s === 'paid')
<div class="modal-overlay" id="refund-modal">
  <div class="modal">
    <button class="modal-close" onclick="closeRefundModal()" aria-label="Close">✕</button>
    <div class="modal-title">Request a Refund</div>
    <div class="modal-sub">This will cancel your booking and reverse the payment.</div>

    <div class="modal-info">
      <div class="modal-info-row">
        <span class="modal-info-k">Transaction</span>
        <span class="modal-info-v mono">{{ $payment->transaction_ref }}</span>
      </div>
      <div class="modal-info-row">
        <span class="modal-info-k">Booking Ref</span>
        <span class="modal-info-v mono">{{ $payment->booking->reference_no }}</span>
      </div>
      <div class="modal-info-row">
        <span class="modal-info-k">Route</span>
        <span class="modal-info-v">
          {{ $payment->booking->schedule->trip->origin ?? '?' }} →
          {{ $payment->booking->schedule->trip->destination ?? '?' }}
        </span>
      </div>
      <div class="modal-info-row">
        <span class="modal-info-k">Refund Amount</span>
        <span class="modal-info-v amount">₱{{ number_format($payment->amount, 2) }}</span>
      </div>
    </div>

    <div class="warn-box">
      ⚠ <strong>This action cannot be undone.</strong> Your booking will be cancelled, all tickets voided, and seats released. The refund will be processed to your original payment method.
    </div>

    <form method="POST" action="{{ route('payments.refund', $payment->id) }}">
      @csrf
      <label class="f-label">Reason for refund <span style="color:#c0392b">*</span></label>
      <textarea class="f-textarea" name="refund_reason"
        placeholder="e.g. Change of travel plans, schedule conflict, medical emergency…"
        required minlength="10" maxlength="500"></textarea>
      @error('refund_reason')
        <div class="f-error">{{ $message }}</div>
      @enderror
      <div class="modal-footer">
        <button type="button" class="btn-modal-cancel" onclick="closeRefundModal()">Cancel</button>
        <button type="submit" class="btn-modal-confirm">Confirm Refund</button>
      </div>
    </form>
  </div>
</div>
@endif

<script>
  // Sidebar toggle
  const sidebar   = document.getElementById('sidebar');
  const overlay   = document.getElementById('overlay');
  const hamburger = document.getElementById('hamburger');
  if (hamburger) {
    hamburger.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('open');
    });
  }
  function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
  }
  document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeSidebar(); closeRefundModal(); } });

  // Refund modal
  function openRefundModal()  { document.getElementById('refund-modal')?.classList.add('open'); }
  function closeRefundModal() { document.getElementById('refund-modal')?.classList.remove('open'); }
  document.getElementById('refund-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeRefundModal();
  });
</script>
</body>
</html>