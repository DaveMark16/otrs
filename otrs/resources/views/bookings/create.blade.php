<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>OTRS — New Flight Booking</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<style>
/* ═══════════════════════════════════════════════
   TOKENS — exact match to dashboard
═══════════════════════════════════════════════ */
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

/* ── Sidebar (identical to dashboard) ─────────── */
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

/* ── Main layout ───────────────────────────────── */
.main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
.topbar { background: var(--white); border-bottom: 1px solid rgba(59,42,26,.08); padding: 0 36px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
.topbar-left { display: flex; align-items: center; gap: 10px; }
.topbar-title { font-family: var(--ff-head); font-size: 1.1rem; font-weight: 700; color: var(--brown); }
.topbar-badge { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; background: rgba(45,110,110,.1); color: var(--teal); border-radius: 20px; padding: 3px 10px; }
.topbar-right { display: flex; align-items: center; gap: 14px; }
.topbar-date { font-size: .8rem; color: rgba(59,42,26,.45); }
.topbar-book { background: var(--teal); color: var(--white); padding: .5rem 1.2rem; border-radius: 50px; font-size: .82rem; font-weight: 600; display: inline-flex; align-items: center; gap: .4rem; transition: background .18s, transform .15s; }
.topbar-book:hover { background: var(--teal-lt); transform: translateY(-1px); }
.topbar-book svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }
.content { padding: 28px 36px 48px; flex: 1; }

/* ── Breadcrumb ─────────────────────────────────── */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: .8rem; color: rgba(59,42,26,.45); margin-bottom: 22px; }
.breadcrumb a { color: rgba(59,42,26,.45); transition: color .15s; }
.breadcrumb a:hover { color: var(--teal); }
.breadcrumb .sep { color: rgba(59,42,26,.25); }
.breadcrumb .current { color: var(--gold); font-weight: 600; }

/* ── Two-column layout ─────────────────────────── */
.booking-grid { display: grid; grid-template-columns: 1fr 360px; gap: 20px; align-items: start; }

/* ── Panel shell (same as dashboard) ───────────── */
.panel { background: var(--white); border-radius: var(--radius); box-shadow: 0 2px 16px rgba(59,42,26,.06); border: 1px solid rgba(59,42,26,.07); overflow: hidden; }

/* ── Flight list panel ──────────────────────────── */
.panel-head { padding: 22px 24px 0; margin-bottom: 18px; }
.panel-head-inner { display: flex; align-items: flex-start; gap: 14px; }
.panel-head-icon { width: 40px; height: 40px; background: rgba(212,162,84,.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--gold); flex-shrink: 0; }
.panel-head-icon svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.panel-head-title { font-family: var(--ff-head); font-size: 1.15rem; font-weight: 700; color: var(--brown); }
.panel-head-sub { font-size: .78rem; color: rgba(59,42,26,.45); margin-top: 3px; }

/* ── Search & filter bar ────────────────────────── */
.search-bar { padding: 0 24px 16px; }
.search-input-wrap { display: flex; align-items: center; gap: 8px; background: var(--cream); border: 1.5px solid rgba(59,42,26,.1); border-radius: 50px; padding: 10px 18px; margin-bottom: 14px; transition: border-color .15s; }
.search-input-wrap:focus-within { border-color: var(--teal); }
.search-input-wrap svg { width: 15px; height: 15px; stroke: rgba(59,42,26,.35); fill: none; stroke-width: 2; stroke-linecap: round; flex-shrink: 0; }
.search-input-wrap input { border: none; background: transparent; font-size: .88rem; color: var(--brown); font-family: var(--ff-body); outline: none; width: 100%; }
.search-input-wrap input::placeholder { color: rgba(59,42,26,.35); }

.filter-tabs { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.filter-tab { font-size: .78rem; font-weight: 600; padding: 5px 14px; border-radius: 50px; border: 1.5px solid rgba(59,42,26,.12); color: rgba(59,42,26,.55); background: transparent; cursor: pointer; transition: all .15s; font-family: var(--ff-body); }
.filter-tab:hover { border-color: var(--teal); color: var(--teal); }
.filter-tab.active { background: var(--teal); color: var(--white); border-color: var(--teal); }

/* ── Flight list ─────────────────────────────────── */
.flight-list { max-height: 520px; overflow-y: auto; border-top: 1px solid rgba(59,42,26,.06); }
.flight-list::-webkit-scrollbar { width: 5px; }
.flight-list::-webkit-scrollbar-track { background: transparent; }
.flight-list::-webkit-scrollbar-thumb { background: rgba(59,42,26,.12); border-radius: 4px; }

.flight-item { display: flex; align-items: stretch; gap: 0; border-bottom: 1px solid rgba(59,42,26,.06); cursor: pointer; transition: background .15s; }
.flight-item:last-child { border-bottom: none; }
.flight-item:hover { background: rgba(245,237,224,.5); }
.flight-item.selected { background: rgba(45,110,110,.05); border-left: 3px solid var(--teal); }
.flight-item.selected .fi-left { padding-left: 21px; }

.fi-left { flex: 1; padding: 14px 16px 14px 24px; min-width: 0; }
.fi-header { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
.fi-airline-icon { width: 28px; height: 28px; background: rgba(59,42,26,.07); border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.fi-airline-icon svg { width: 14px; height: 14px; stroke: var(--brown); fill: none; stroke-width: 1.8; stroke-linecap: round; }
.fi-route-name { font-size: .88rem; font-weight: 700; color: var(--brown); }
.fi-operator { font-size: .73rem; color: rgba(59,42,26,.4); margin-left: 2px; }

.fi-route-row { display: flex; align-items: center; gap: 10px; }
.fi-city { font-size: .82rem; font-weight: 600; color: var(--brown); }
.fi-city-sub { font-size: .68rem; color: var(--teal); font-weight: 600; }
.fi-arrow { flex: 1; display: flex; align-items: center; gap: 4px; }
.fi-arrow-line { flex: 1; height: 1px; background: rgba(59,42,26,.15); }
.fi-arrow-icon { color: rgba(59,42,26,.3); font-size: 10px; }
.fi-meta { display: flex; align-items: center; gap: 12px; margin-top: 6px; }
.fi-meta-item { font-size: .71rem; color: rgba(59,42,26,.4); display: flex; align-items: center; gap: 4px; }
.fi-meta-item svg { width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }
.fi-badge { font-size: .68rem; font-weight: 700; padding: 2px 7px; border-radius: 20px; background: rgba(212,162,84,.12); color: #a07830; }
.fi-badge.economy  { background: rgba(45,110,110,.1);   color: var(--teal); }
.fi-badge.business { background: rgba(212,162,84,.12); color: #a07830; }
.fi-badge.first    { background: rgba(59,42,26,.07);   color: var(--brown); }

.fi-right { padding: 14px 20px 14px 16px; display: flex; flex-direction: column; align-items: flex-end; justify-content: center; gap: 8px; flex-shrink: 0; border-left: 1px solid rgba(59,42,26,.06); }
.fi-price-label { font-size: .67rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: rgba(59,42,26,.35); }
.fi-price { font-family: var(--ff-head); font-size: 1.1rem; font-weight: 900; color: var(--teal); white-space: nowrap; }
.fi-price-sub { font-size: .67rem; color: rgba(59,42,26,.38); }
.fi-seats { font-size: .68rem; font-weight: 600; color: rgba(59,42,26,.38); }
.fi-select-btn { font-size: .73rem; font-weight: 600; background: var(--teal); color: var(--white); border: none; border-radius: 20px; padding: 5px 12px; cursor: pointer; font-family: var(--ff-body); transition: background .15s; white-space: nowrap; }
.fi-select-btn:hover { background: var(--teal-lt); }
.fi-select-btn.selected-btn { background: rgba(45,110,110,.12); color: var(--teal); }

/* ── Right panel: Booking summary ─────────────── */
.summary-panel { position: sticky; top: 84px; }

.summary-head { padding: 20px 22px 16px; border-bottom: 1px solid rgba(59,42,26,.07); }
.summary-head-label { font-size: .68rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(59,42,26,.4); display: flex; align-items: center; gap: 6px; }
.summary-head-label svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }

/* Empty state */
.summary-empty { padding: 36px 22px; text-align: center; }
.summary-empty-icon { font-size: 28px; opacity: .2; margin-bottom: 10px; }
.summary-empty-text { font-size: .82rem; color: rgba(59,42,26,.35); }

/* Selected flight summary */
.summary-flight { padding: 16px 22px; border-bottom: 1px solid rgba(59,42,26,.07); display: none; }
.summary-flight.visible { display: block; }
.sf-route { font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: var(--brown); margin-bottom: 4px; }
.sf-meta { font-size: .75rem; color: rgba(59,42,26,.45); }
.sf-operator { font-size: .72rem; font-weight: 600; color: var(--teal); margin-top: 2px; }

/* Promo section */
.promo-section { padding: 16px 22px; border-bottom: 1px solid rgba(59,42,26,.07); }
.promo-label { font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: rgba(59,42,26,.45); margin-bottom: 10px; display: flex; align-items: center; gap: 5px; }
.promo-label svg { width: 12px; height: 12px; stroke: var(--gold); fill: none; stroke-width: 2; stroke-linecap: round; }
.promo-input-row { display: flex; gap: 8px; margin-bottom: 10px; }
.promo-input { flex: 1; border: 1.5px solid rgba(59,42,26,.12); border-radius: 9px; padding: 9px 13px; font-size: .82rem; font-family: var(--ff-body); color: var(--brown); background: var(--cream); outline: none; transition: border-color .15s; text-transform: uppercase; letter-spacing: .05em; }
.promo-input::placeholder { text-transform: none; letter-spacing: 0; color: rgba(59,42,26,.35); }
.promo-input:focus { border-color: var(--teal); }
.promo-apply-btn { background: var(--brown); color: var(--sand); font-size: .8rem; font-weight: 600; padding: 9px 14px; border-radius: 9px; border: none; cursor: pointer; font-family: var(--ff-body); transition: background .15s; white-space: nowrap; }
.promo-apply-btn:hover { background: #2a1e0f; }
.promo-error { font-size: .75rem; color: #b44444; margin-top: 4px; }

.available-promos-label { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(59,42,26,.3); margin-bottom: 8px; }
.promo-chips { display: flex; flex-direction: column; gap: 6px; }
.promo-chip { display: flex; align-items: center; justify-content: space-between; background: rgba(245,237,224,.6); border: 1px solid rgba(59,42,26,.08); border-radius: 9px; padding: 8px 12px; cursor: pointer; transition: all .15s; }
.promo-chip:hover { background: rgba(212,162,84,.1); border-color: rgba(212,162,84,.3); }
.pc-left { display: flex; flex-direction: column; gap: 2px; }
.pc-code { font-size: .78rem; font-weight: 700; color: var(--brown); font-family: monospace; letter-spacing: .08em; }
.pc-name { font-size: .68rem; color: rgba(59,42,26,.45); }
.pc-right { display: flex; align-items: center; gap: 6px; }
.pc-discount { font-size: .72rem; font-weight: 700; background: rgba(180,60,60,.1); color: #b44444; border-radius: 20px; padding: 2px 8px; }
.pc-expiry { font-size: .67rem; color: rgba(59,42,26,.35); }

/* Price breakdown */
.price-breakdown { padding: 16px 22px; border-bottom: 1px solid rgba(59,42,26,.07); display: none; }
.price-breakdown.visible { display: block; }
.pb-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: .82rem; }
.pb-row:last-child { margin-bottom: 0; }
.pb-label { color: rgba(59,42,26,.55); }
.pb-value { font-weight: 600; color: var(--brown); }
.pb-total { border-top: 1px solid rgba(59,42,26,.1); margin-top: 10px; padding-top: 10px; }
.pb-total .pb-label { font-weight: 700; color: var(--brown); font-size: .9rem; }
.pb-total .pb-value { font-family: var(--ff-head); font-size: 1.1rem; font-weight: 900; color: var(--teal); }
.pb-discount-row .pb-value { color: #27ae60; }

/* Passenger count */
.pax-section { padding: 16px 22px; border-bottom: 1px solid rgba(59,42,26,.07); }
.pax-label { font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: rgba(59,42,26,.45); margin-bottom: 10px; }
.pax-row { display: flex; align-items: center; gap: 12px; }
.pax-btn { width: 32px; height: 32px; border-radius: 50%; border: 1.5px solid rgba(59,42,26,.15); background: var(--cream); color: var(--brown); font-size: 1rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; flex-shrink: 0; }
.pax-btn:hover { background: var(--sand); border-color: var(--tan); }
.pax-count { font-family: var(--ff-head); font-size: 1.5rem; font-weight: 900; color: var(--brown); min-width: 28px; text-align: center; }
.pax-sub { font-size: .72rem; color: rgba(59,42,26,.4); }

/* Contact */
.contact-section { padding: 16px 22px; border-bottom: 1px solid rgba(59,42,26,.07); }
.contact-label { font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: rgba(59,42,26,.45); margin-bottom: 10px; }
.contact-input { width: 100%; border: 1.5px solid rgba(59,42,26,.12); border-radius: 9px; padding: 9px 13px; font-size: .85rem; font-family: var(--ff-body); color: var(--brown); background: var(--cream); outline: none; transition: border-color .15s; }
.contact-input:focus { border-color: var(--teal); }
.contact-input.error { border-color: #b44444; }

/* Warning banner */
.warning-banner { margin: 0 22px 16px; padding: 10px 14px; border-radius: 10px; background: rgba(212,162,84,.08); border: 1px solid rgba(212,162,84,.25); font-size: .75rem; color: rgba(59,42,26,.6); display: flex; align-items: flex-start; gap: 7px; }
.warning-banner svg { width: 13px; height: 13px; stroke: var(--gold); fill: none; stroke-width: 2; stroke-linecap: round; flex-shrink: 0; margin-top: 1px; }

/* Action buttons */
.summary-actions { padding: 16px 22px 22px; display: flex; gap: 10px; }
.btn-cancel { flex: 1; padding: 11px; border-radius: 10px; border: 1.5px solid rgba(59,42,26,.15); background: transparent; color: rgba(59,42,26,.6); font-size: .88rem; font-weight: 600; cursor: pointer; font-family: var(--ff-body); transition: all .15s; }
.btn-cancel:hover { background: var(--sand); color: var(--brown); }
.btn-confirm { flex: 2; padding: 11px; border-radius: 10px; border: none; background: linear-gradient(135deg, var(--teal), var(--teal-lt)); color: var(--white); font-size: .88rem; font-weight: 700; cursor: pointer; font-family: var(--ff-body); transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 7px; }
.btn-confirm:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(45,110,110,.3); }
.btn-confirm:disabled { opacity: .45; cursor: not-allowed; transform: none; box-shadow: none; }
.btn-confirm svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }

/* Validation errors */
.err-list { background: rgba(180,60,60,.06); border: 1px solid rgba(180,60,60,.2); border-radius: 12px; padding: 12px 16px; margin-bottom: 18px; font-size: .83rem; color: #b44444; }
.err-list ul { padding-left: 16px; }
.err-list li { margin-bottom: 3px; }

/* Empty flight state */
.no-flights { text-align: center; padding: 44px 20px; color: rgba(59,42,26,.35); }
.no-flights-icon { font-size: 28px; opacity: .25; margin-bottom: 8px; }

/* Mobile */
.mobile-bar { display: none; background: var(--brown); padding: 14px 20px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 200; }
.hamburger { display: flex; flex-direction: column; gap: 5px; cursor: pointer; }
.hamburger span { width: 22px; height: 2px; background: var(--sand); border-radius: 2px; }
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(59,42,26,.5); z-index: 150; backdrop-filter: blur(2px); }

@media (max-width: 1024px) { .booking-grid { grid-template-columns: 1fr; } .summary-panel { position: static; } }
@media (max-width: 768px) {
  body { flex-direction: column; }
  .sidebar { position: fixed; left: -100%; top: 0; height: 100vh; transition: left .28s ease; z-index: 200; }
  .sidebar.open { left: 0; }
  .sidebar-overlay.open { display: block; }
  .mobile-bar { display: flex; }
  .topbar { display: none; }
  .content { padding: 20px 16px 36px; }
}
</style>
</head>
<body>

{{-- Mobile bar --}}
<div class="mobile-bar">
  <div class="sb-logo" style="font-size:1.3rem;">OTR<span>S</span></div>
  <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
</div>
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

{{-- ══════════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════════ --}}
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
    <a href="{{ route('dashboard') }}" class="sb-item" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Dashboard
    </a>
    <a href="{{ route('bookings.index') }}" class="sb-item" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      My Bookings
    </a>
    <a href="{{ route('tickets.index') }}" class="sb-item" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
      My Tickets
    </a>
    <a href="{{ route('bookings.create') }}" class="sb-item active" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
      Trips &amp; Schedules
    </a>
    <a href="{{ route('promos.index') }}" class="sb-item" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg>
      Promo Codes
    </a>
    <div class="sb-section">Finance</div>
    <a href="{{ route('payments.index') }}" class="sb-item" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      Payments &amp; Refunds
    </a>
    <div class="sb-section">Account</div>
    <a href="{{ route('profile.edit') }}" class="sb-item" onclick="closeSidebar()">
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

{{-- ══════════════════════════════════════════════
     MAIN
══════════════════════════════════════════════ --}}
<div class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div class="topbar-title">Dashboard</div>
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

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
      <a href="{{ route('bookings.index') }}">My Bookings</a>
      <span class="sep">→</span>
      <span class="current">New Flight Booking</span>
    </div>

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="err-list">
      <ul>
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('bookings.store') }}" id="bookingForm">
      @csrf
      <input type="hidden" name="schedule_id"     id="hiddenScheduleId"     value="{{ old('schedule_id', $selectedSchedule?->id) }}">
      <input type="hidden" name="passenger_count" id="hiddenPassengerCount" value="1">
      <input type="hidden" name="promo_code"       id="hiddenPromoCode"      value="{{ old('promo_code') }}">

      <div class="booking-grid">

        {{-- ── LEFT: Flight selection ───────────────── --}}
        <div class="panel">
          <div class="panel-head">
            <div class="panel-head-inner">
              <div class="panel-head-icon">
                <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
              </div>
              <div>
                <div class="panel-head-title">Select Your Flight</div>
                <div class="panel-head-sub">{{ $schedules->count() }} flights available · prices per person</div>
              </div>
            </div>
          </div>

          {{-- Search & filter --}}
          <div class="search-bar">
            <div class="search-input-wrap">
              <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              <input type="text" id="searchInput" placeholder="Search by destination, airline, route…"
                     value="{{ request('search') }}" oninput="filterFlights()">
            </div>
            <div class="filter-tabs">
              <button type="button" class="filter-tab active" data-class="all"      onclick="setClass(this,'all')">All Classes</button>
              <button type="button" class="filter-tab"        data-class="economy"  onclick="setClass(this,'economy')">Economy</button>
              <button type="button" class="filter-tab"        data-class="business" onclick="setClass(this,'business')">Business</button>
              <button type="button" class="filter-tab"        data-class="first"    onclick="setClass(this,'first')">First Class</button>
            </div>
          </div>

          {{-- Flight rows --}}
          <div class="flight-list" id="flightList">
            @forelse($schedules as $schedule)
              @php
                $trip = $schedule->trip;
                $fc   = strtolower($schedule->fare_class ?? 'economy');
              @endphp
              <div class="flight-item {{ ($selectedSchedule?->id == $schedule->id) ? 'selected' : '' }}"
                   id="flight-{{ $schedule->id }}"
                   data-id="{{ $schedule->id }}"
                   data-class="{{ $fc }}"
                   data-origin="{{ $trip->origin ?? '' }}"
                   data-destination="{{ $trip->destination ?? '' }}"
                   data-origin-country="{{ $trip->origin_country ?? '' }}"
                   data-dest-country="{{ $trip->destination_country ?? '' }}"
                   data-operator="{{ $trip->operator ?? '' }}"
                   data-fare="{{ $schedule->base_fare ?? 0 }}"
                   data-seats="{{ $schedule->available_seats ?? 0 }}"
                   data-departure="{{ $schedule->departure_at?->format('M d, Y · h:i A') ?? '—' }}"
                   onclick="selectFlight(this)">
                <div class="fi-left">
                  <div class="fi-header">
                    <div class="fi-airline-icon">
                      <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
                    </div>
                    <div>
                      <div class="fi-route-name">{{ $trip->origin_country ?? $trip->origin ?? '?' }} → {{ $trip->destination_country ?? $trip->destination ?? '?' }}</div>
                      <div class="fi-operator">{{ $trip->operator ?? 'Unknown Airline' }}</div>
                    </div>
                  </div>
                  <div class="fi-route-row">
                    <div>
                      <div class="fi-city">{{ $trip->origin ?? '?' }}</div>
                      <div class="fi-city-sub">{{ $trip->origin_country ?? '' }}</div>
                    </div>
                    <div class="fi-arrow">
                      <div class="fi-arrow-line"></div>
                      <div class="fi-arrow-icon">✈</div>
                      <div class="fi-arrow-line"></div>
                    </div>
                    <div style="text-align:right;">
                      <div class="fi-city">{{ $trip->destination ?? '?' }}</div>
                      <div class="fi-city-sub">{{ $trip->destination_country ?? '' }}</div>
                    </div>
                  </div>
                  <div class="fi-meta">
                    <div class="fi-meta-item">
                      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                      {{ $schedule->departure_at?->format('M d, Y · h:i A') ?? '—' }}
                    </div>
                    <span class="fi-badge {{ $fc }}">{{ ucfirst($fc) }}</span>
                  </div>
                </div>
                <div class="fi-right">
                  <div class="fi-price-label">Price</div>
                  <div class="fi-price">₱{{ number_format($schedule->base_fare ?? 0, 0) }}</div>
                  <div class="fi-price-sub">per person</div>
                  <div class="fi-seats">{{ $schedule->available_seats ?? 0 }} seats left</div>
                  <button type="button" class="fi-select-btn {{ ($selectedSchedule?->id == $schedule->id) ? 'selected-btn' : '' }}">
                    {{ ($selectedSchedule?->id == $schedule->id) ? '✓ Selected' : 'Select' }}
                  </button>
                </div>
              </div>
            @empty
              <div class="no-flights">
                <div class="no-flights-icon">✈</div>
                No flights available matching your criteria.
              </div>
            @endforelse
          </div>
        </div>

        {{-- ── RIGHT: Booking Summary ───────────────── --}}
        <div class="summary-panel">
          <div class="panel">

            {{-- Header --}}
            <div class="summary-head">
              <div class="summary-head-label">
                <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
                Booking Summary
              </div>
            </div>

            {{-- Empty state --}}
            <div class="summary-empty" id="summaryEmpty" style="{{ $selectedSchedule ? 'display:none' : '' }}">
              <div class="summary-empty-icon">✈</div>
              <div class="summary-empty-text">Select a flight to see your booking summary</div>
            </div>

            {{-- Selected flight info --}}
            <div class="summary-flight {{ $selectedSchedule ? 'visible' : '' }}" id="summaryFlight">
              <div class="sf-route" id="sfRoute">
                {{ $selectedSchedule ? ($selectedSchedule->trip->origin_country ?? $selectedSchedule->trip->origin ?? '?') . ' → ' . ($selectedSchedule->trip->destination_country ?? $selectedSchedule->trip->destination ?? '?') : '' }}
              </div>
              <div class="sf-meta" id="sfDep">{{ $selectedSchedule?->departure_at?->format('M d, Y · h:i A') ?? '' }}</div>
              <div class="sf-operator" id="sfOp">{{ $selectedSchedule?->trip->operator ?? '' }}</div>
            </div>

            {{-- Passenger count --}}
            <div class="pax-section" id="paxSection" style="{{ $selectedSchedule ? '' : 'display:none' }}">
              <div class="pax-label">Passengers</div>
              <div class="pax-row">
                <button type="button" class="pax-btn" onclick="changePax(-1)">−</button>
                <div class="pax-count" id="paxCount">1</div>
                <button type="button" class="pax-btn" onclick="changePax(1)">+</button>
                <div class="pax-sub">person(s)</div>
              </div>
            </div>

            {{-- Contact --}}
            <div class="contact-section" id="contactSection" style="{{ $selectedSchedule ? '' : 'display:none' }}">
              <div class="contact-label">Contact Email</div>
              <input type="email" name="contact_email" class="contact-input @error('contact_email') error @enderror"
                     placeholder="{{ auth()->user()->email }}"
                     value="{{ old('contact_email', auth()->user()->email) }}">
              @error('contact_email')<div class="promo-error">{{ $message }}</div>@enderror
            </div>

            {{-- Promo section --}}
            <div class="promo-section">
              <div class="promo-label">
                <svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg>
                Have a promo code?
              </div>
              <div class="promo-input-row">
                <input type="text" id="promoInput" class="promo-input" placeholder="Enter Code"
                       value="{{ old('promo_code') }}" oninput="this.value=this.value.toUpperCase()">
                <button type="button" class="promo-apply-btn" onclick="applyPromo()">Apply</button>
              </div>
              @error('promo_code')<div class="promo-error">{{ $message }}</div>@enderror
              <div class="promo-error" id="promoError" style="display:none;"></div>
              <div class="promo-error" id="promoSuccess" style="color:var(--teal);display:none;"></div>

              {{-- Available promos --}}
              @php
                try { $availPromos = \App\Models\Promo::active()->orderBy('end_date')->limit(4)->get(); }
                catch(\Exception $e) { $availPromos = collect(); }
              @endphp
              @if($availPromos->isNotEmpty())
              <div class="available-promos-label" style="margin-top:12px;">Available Promos — Click to Apply</div>
              <div class="promo-chips">
                @foreach($availPromos as $ap)
                <div class="promo-chip" onclick="fillPromo('{{ $ap->promo_code }}')">
                  <div class="pc-left">
                    <div class="pc-code">{{ $ap->promo_code }}</div>
                    <div class="pc-name">{{ $ap->title ?? 'Promo discount' }}</div>
                  </div>
                  <div class="pc-right">
                    <span class="pc-discount">{{ $ap->formatted_discount ?? ($ap->discount_value . ($ap->discount_type === 'percent' ? '%' : '') . ' off') }}</span>
                    @if($ap->end_date)
                    <span class="pc-expiry">Exp {{ $ap->end_date->format('M d') }}</span>
                    @endif
                  </div>
                </div>
                @endforeach
              </div>
              @endif
            </div>

            {{-- Price breakdown --}}
            <div class="price-breakdown" id="priceBreakdown">
              <div class="pb-row">
                <span class="pb-label">Base fare × <span id="pbPax">1</span></span>
                <span class="pb-value" id="pbBase">₱0</span>
              </div>
              <div class="pb-row pb-discount-row" id="pbDiscountRow" style="display:none;">
                <span class="pb-label">Promo discount</span>
                <span class="pb-value" id="pbDiscount">−₱0</span>
              </div>
              <div class="pb-row pb-total">
                <span class="pb-label">Total</span>
                <span class="pb-value" id="pbTotal">₱0</span>
              </div>
            </div>

            {{-- Warning --}}
            <div class="warning-banner" id="warningBanner" style="{{ $selectedSchedule ? '' : 'display:none' }}">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              <span>30-minute window — Complete payment within 30 minutes or the booking expires automatically.</span>
            </div>

            {{-- Actions --}}
            <div class="summary-actions">
              <a href="{{ route('bookings.index') }}" class="btn-cancel" style="display:flex;align-items:center;justify-content:center;">Cancel</a>
              <button type="submit" class="btn-confirm" id="confirmBtn" {{ $selectedSchedule ? '' : 'disabled' }}>
                <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
                Confirm Booking
              </button>
            </div>

          </div>
        </div>

      </div>{{-- /booking-grid --}}
    </form>

  </div>{{-- /content --}}
</div>{{-- /main --}}

<script>
/* ── State ── */
let selectedId   = {{ $selectedSchedule?->id ?? 'null' }};
let paxCount     = 1;
let baseFare     = {{ $selectedSchedule?->base_fare ?? 0 }};
let discount     = 0;
let activeClass  = 'all';

/* ── Flight selection ── */
function selectFlight(el) {
  // Deselect previous
  document.querySelectorAll('.flight-item').forEach(f => {
    f.classList.remove('selected');
    f.querySelector('.fi-select-btn').classList.remove('selected-btn');
    f.querySelector('.fi-select-btn').textContent = 'Select';
  });

  el.classList.add('selected');
  const btn = el.querySelector('.fi-select-btn');
  btn.classList.add('selected-btn');
  btn.textContent = '✓ Selected';

  selectedId = el.dataset.id;
  baseFare   = parseFloat(el.dataset.fare);

  document.getElementById('hiddenScheduleId').value = selectedId;

  // Update summary
  document.getElementById('sfRoute').textContent =
    (el.dataset.originCountry || el.dataset.origin) + ' → ' +
    (el.dataset.destCountry   || el.dataset.destination);
  document.getElementById('sfDep').textContent  = el.dataset.departure;
  document.getElementById('sfOp').textContent   = el.dataset.operator;

  document.getElementById('summaryEmpty').style.display   = 'none';
  document.getElementById('summaryFlight').classList.add('visible');
  document.getElementById('paxSection').style.display     = '';
  document.getElementById('contactSection').style.display = '';
  document.getElementById('warningBanner').style.display  = '';
  document.getElementById('priceBreakdown').classList.add('visible');
  document.getElementById('confirmBtn').disabled = false;

  discount = 0;
  document.getElementById('promoInput').value    = '';
  document.getElementById('hiddenPromoCode').value = '';
  document.getElementById('pbDiscountRow').style.display = 'none';
  updatePrices();
}

/* ── Passenger count ── */
function changePax(delta) {
  const seats = selectedId
    ? parseInt(document.getElementById('flight-' + selectedId)?.dataset.seats || 150)
    : 150;
  paxCount = Math.max(1, Math.min(seats, paxCount + delta));
  document.getElementById('paxCount').textContent = paxCount;
  document.getElementById('hiddenPassengerCount').value = paxCount;
  updatePrices();
}

/* ── Price update ── */
function updatePrices() {
  const base  = baseFare * paxCount;
  const disc  = discount * paxCount;
  const total = Math.max(0, base - disc);

  document.getElementById('pbPax').textContent     = paxCount;
  document.getElementById('pbBase').textContent    = '₱' + base.toLocaleString();
  document.getElementById('pbTotal').textContent   = '₱' + total.toLocaleString();

  if (disc > 0) {
    document.getElementById('pbDiscount').textContent = '−₱' + disc.toLocaleString();
    document.getElementById('pbDiscountRow').style.display = '';
  }
}

/* ── Promo ── */
function fillPromo(code) {
  document.getElementById('promoInput').value = code;
  applyPromo();
}

function applyPromo() {
  const code  = document.getElementById('promoInput').value.trim().toUpperCase();
  const errEl = document.getElementById('promoError');
  const okEl  = document.getElementById('promoSuccess');
  errEl.style.display = 'none';
  okEl.style.display  = 'none';

  if (!code) { errEl.textContent = 'Please enter a promo code.'; errEl.style.display = ''; return; }

  // AJAX validate
  fetch(`/promos/validate?code=${encodeURIComponent(code)}&amount=${baseFare * paxCount}`, {
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
  })
  .then(r => r.json())
  .then(data => {
    if (data.valid) {
      discount = data.discount_per_person ?? (data.discount / paxCount);
      document.getElementById('hiddenPromoCode').value = code;
      okEl.textContent = '✓ ' + (data.message ?? 'Promo applied!');
      okEl.style.display = '';
      document.getElementById('pbDiscountRow').style.display = '';
      updatePrices();
    } else {
      discount = 0;
      document.getElementById('hiddenPromoCode').value = '';
      errEl.textContent = data.message ?? 'Invalid promo code.';
      errEl.style.display = '';
      document.getElementById('pbDiscountRow').style.display = 'none';
      updatePrices();
    }
  })
  .catch(() => {
    // If no validate endpoint, just store the code and let server validate on submit
    document.getElementById('hiddenPromoCode').value = code;
    okEl.textContent = '✓ Code applied — discount applied on confirmation.';
    okEl.style.display = '';
  });
}

/* ── Client-side search & filter ── */
function filterFlights() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.flight-item').forEach(el => {
    const text = (el.dataset.origin + el.dataset.destination +
                  el.dataset.originCountry + el.dataset.destCountry +
                  el.dataset.operator).toLowerCase();
    const matchClass = activeClass === 'all' || el.dataset.class === activeClass;
    el.style.display = (text.includes(q) && matchClass) ? '' : 'none';
  });
}

function setClass(btn, cls) {
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  activeClass = cls;
  filterFlights();
}

/* ── Mobile sidebar ── */
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

/* ── Init if pre-selected ── */
@if($selectedSchedule)
  document.getElementById('priceBreakdown').classList.add('visible');
  baseFare = {{ $selectedSchedule->base_fare ?? 0 }};
  updatePrices();
@endif
</script>

</body>
</html>