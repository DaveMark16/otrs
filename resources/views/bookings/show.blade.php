@extends('layouts.user')
@section('page-title', 'Booking Details')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
/* ── Local resets & helpers ─────────────────────────── */
.back-link { display:inline-flex;align-items:center;gap:6px;color:rgba(59,42,26,.38);font-size:.8rem;font-weight:500;margin-bottom:24px;transition:color .15s; }
.back-link:hover { color:var(--teal); }
.back-link svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }

/* ── Page header ────────────────────────────────────── */
.page-eyebrow { font-size:.67rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:6px;display:flex;align-items:center;gap:7px; }
.page-eyebrow::before { content:'';display:block;width:28px;height:2px;background:var(--gold);border-radius:2px; }
.page-title { font-family:var(--ff-head);font-size:1.85rem;font-weight:900;color:var(--brown);line-height:1.15;margin-bottom:4px; }
.page-title em { color:var(--teal);font-style:italic; }
.page-subtitle { font-size:.82rem;color:rgba(59,42,26,.42);margin-bottom:26px; }

/* ── Status banner ──────────────────────────────────── */
.status-banner { border-radius:var(--radius);padding:14px 20px;display:flex;align-items:center;gap:12px;margin-bottom:20px;border-width:1.5px;border-style:solid; }
.status-banner svg { width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0; }
.status-banner-text { font-size:.84rem;font-weight:600; }
.status-banner-sub  { font-size:.74rem;opacity:.75;margin-top:1px; }
.sb-pending  { background:rgba(212,162,84,.07); border-color:rgba(212,162,84,.3); color:#9a7030; }
.sb-confirmed{ background:rgba(45,110,110,.07); border-color:rgba(45,110,110,.2);  color:var(--teal); }
.sb-ticketed { background:rgba(45,110,110,.07); border-color:rgba(45,110,110,.2);  color:var(--teal); }
.sb-cancelled{ background:rgba(180,60,60,.06);  border-color:rgba(180,60,60,.18);  color:#b44444; }

/* ── Route hero card ────────────────────────────────── */
.route-hero {
  background:var(--white);
  border:1.5px solid rgba(59,42,26,.08);
  border-radius:var(--radius);
  padding:24px 28px;
  margin-bottom:16px;
  box-shadow:0 2px 20px rgba(59,42,26,.06);
  position:relative;
  overflow:hidden;
}
.route-hero::before {
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--teal),var(--gold));
}
.route-inner { display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap; }
.city-block { min-width:0; }
.city-code  { font-family:monospace;font-size:2.2rem;font-weight:900;color:var(--brown);letter-spacing:2px;line-height:1; }
.city-name  { font-size:.73rem;color:rgba(59,42,26,.38);margin-top:3px;white-space:nowrap; }
.city-time  { font-size:1.05rem;font-weight:700;color:var(--teal);margin-top:6px; }
.city-date  { font-size:.72rem;color:rgba(59,42,26,.35); }
.route-mid  { flex:1;text-align:center;padding:0 18px;min-width:160px; }
.dur-badge  { display:inline-block;background:rgba(212,162,84,.12);border:1.5px solid rgba(212,162,84,.3);border-radius:20px;padding:4px 14px;font-size:.78rem;font-weight:700;color:var(--gold); }
.route-line { position:relative;height:2px;background:linear-gradient(90deg,var(--teal),rgba(196,154,108,.4),var(--gold));border-radius:2px;margin:9px 0; }
.route-line::after { content:'✈';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:14px;background:var(--white);padding:0 6px;color:rgba(59,42,26,.4); }
.fstats { display:flex;gap:18px;justify-content:center;flex-wrap:wrap;margin-top:10px; }
.fstat-label { font-size:.64rem;color:rgba(59,42,26,.35);text-transform:uppercase;letter-spacing:.07em; }
.fstat-val   { font-size:.82rem;font-weight:700;color:var(--brown);margin-top:2px; }
.fstat-val.gold { color:var(--gold); }

/* ── Map ────────────────────────────────────────────── */
#flight-map { width:100%;height:340px;border-radius:var(--radius);border:1.5px solid rgba(59,42,26,.08);margin-bottom:18px;overflow:hidden;position:relative;z-index:0;box-shadow:0 2px 16px rgba(59,42,26,.05); }
.leaflet-popup-content-wrapper { background:var(--white);color:var(--brown);border:1.5px solid rgba(59,42,26,.1);border-radius:10px;box-shadow:0 4px 20px rgba(59,42,26,.14); }
.leaflet-popup-tip { background:var(--white); }
.leaflet-popup-content { color:var(--brown);font-size:12px;font-family:var(--ff-body); }
.leaflet-control-zoom a { background:var(--white)!important;color:var(--brown)!important;border-color:rgba(59,42,26,.14)!important; }
.leaflet-control-attribution { background:rgba(250,246,240,.88)!important;color:rgba(59,42,26,.38)!important; }

/* ── Two-column grid ────────────────────────────────── */
.detail-grid { display:grid;grid-template-columns:1.1fr 1fr;gap:16px;margin-bottom:16px; }

/* ── Panel cards ────────────────────────────────────── */
.panel {
  background:var(--white);
  border:1.5px solid rgba(59,42,26,.08);
  border-radius:var(--radius);
  overflow:hidden;
  box-shadow:0 2px 14px rgba(59,42,26,.05);
  margin-bottom:14px;
}
.panel:last-child { margin-bottom:0; }
.panel-head {
  display:flex;align-items:center;justify-content:space-between;
  padding:16px 20px;
  border-bottom:1.5px solid rgba(59,42,26,.07);
  background:var(--sand);
}
.panel-title-wrap { display:flex;align-items:center;gap:8px; }
.panel-dot  { width:8px;height:8px;border-radius:50%;background:var(--gold);flex-shrink:0; }
.panel-title { font-family:var(--ff-head);font-size:.96rem;font-weight:700;color:var(--brown); }
.panel-body { padding:16px 20px; }
.panel-section { padding:14px 20px;border-bottom:1px solid rgba(59,42,26,.06); }
.panel-section:last-child { border-bottom:none; }

/* ── Reference bar ──────────────────────────────────── */
.ref-bar { display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1.5px solid rgba(59,42,26,.07); }
.ref-label { font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:4px; }
.ref-val   { font-family:monospace;font-size:1.45rem;font-weight:900;color:var(--teal); }

/* ── Status pill ────────────────────────────────────── */
.pill { display:inline-flex;align-items:center;padding:5px 14px;border-radius:20px;font-size:.74rem;font-weight:700; }
.st-confirmed { background:rgba(45,110,110,.1); color:var(--teal); }
.st-pending   { background:rgba(212,162,84,.12);color:#a07830; }
.st-cancelled { background:rgba(180,60,60,.08); color:#b44444; }
.st-ticketed  { background:rgba(45,110,110,.1); color:var(--teal); }

/* ── Section eyebrow ────────────────────────────────── */
.section-eyebrow { font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:12px;display:flex;align-items:center;gap:6px; }
.section-eyebrow svg { width:12px;height:12px;stroke:var(--teal);fill:none;stroke-width:1.8; }

/* ── Info rows ──────────────────────────────────────── */
.info-row { display:flex;justify-content:space-between;align-items:baseline;padding:7px 0;border-bottom:1px solid rgba(59,42,26,.05);font-size:.83rem; }
.info-row:last-child { border-bottom:none; }
.info-k { color:rgba(59,42,26,.38);font-size:.75rem; }
.info-v { color:var(--brown);font-weight:600;text-align:right; }
.info-v.gold { color:var(--gold);font-family:monospace; }

/* ── User chip ──────────────────────────────────────── */
.user-chip { display:flex;align-items:center;gap:12px;padding:10px 0; }
.user-av   { width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--tan));display:flex;align-items:center;justify-content:center;font-family:var(--ff-head);font-size:.9rem;font-weight:700;color:var(--brown);flex-shrink:0; }
.user-name { font-weight:700;color:var(--brown);font-size:.9rem; }
.user-email{ font-size:.73rem;color:rgba(59,42,26,.38);margin-top:1px; }

/* ── Amount box ─────────────────────────────────────── */
.amount-box {
  background:linear-gradient(135deg,rgba(45,110,110,.04),rgba(212,162,84,.06));
  border:1.5px solid rgba(212,162,84,.22);
  border-radius:12px;
  padding:16px 18px;
}
.amount-main { font-family:var(--ff-head);font-size:2rem;font-weight:900;color:var(--gold);line-height:1; }
.amount-sub  { font-size:.72rem;color:rgba(59,42,26,.38);margin-top:4px; }
.amount-orig { font-size:.74rem;color:rgba(59,42,26,.3);text-decoration:line-through;margin-bottom:2px; }
.promo-tag  { display:inline-flex;align-items:center;gap:6px;background:rgba(45,110,110,.07);border:1px solid rgba(45,110,110,.18);border-radius:6px;padding:4px 10px;font-size:.72rem;color:var(--teal);font-weight:600;margin-top:8px; }

/* ── Action buttons ─────────────────────────────────── */
.btn { padding:10px 22px;border-radius:50px;font-size:.84rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .18s;font-family:var(--ff-body);border:none;text-decoration:none;white-space:nowrap; }
.btn svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }
.btn-pay     { background:var(--teal);color:var(--white);box-shadow:0 4px 14px rgba(45,110,110,.25); }
.btn-pay:hover { background:var(--teal-lt);transform:translateY(-1px);box-shadow:0 6px 20px rgba(45,110,110,.3); }
.btn-receipt { background:var(--sand);color:var(--teal);border:1.5px solid rgba(45,110,110,.2); }
.btn-receipt:hover { background:rgba(45,110,110,.08); }
.btn-edit    { background:rgba(212,162,84,.12);color:#9a7030;border:1.5px solid rgba(212,162,84,.25); }
.btn-edit:hover { background:rgba(212,162,84,.2); }
.btn-cancel  { background:rgba(180,68,68,.07);color:#b44444;border:1.5px solid rgba(180,68,68,.22); }
.btn-cancel:hover { background:rgba(180,68,68,.14); }
.btn-group { display:flex;gap:10px;flex-wrap:wrap; }

/* ── Payment method picker ── */
.pay-method-wrap { margin-bottom: 16px; }
.pay-method-label { font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:10px; }
.pay-method-grid { display:grid;grid-template-columns:1fr 1fr;gap:8px; }
.pay-method-card {
  display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;
  padding:12px 8px;border-radius:12px;cursor:pointer;
  border:1.5px solid rgba(59,42,26,.1);background:var(--cream);
  transition:all .18s;text-align:center;
}
.pay-method-card:hover { border-color:var(--teal);background:rgba(45,110,110,.04); }
.pay-method-card.selected { border-color:var(--teal);background:rgba(45,110,110,.08);box-shadow:0 0 0 3px rgba(45,110,110,.1); }
.pay-method-icon { width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1.25rem; }
.pay-method-name { font-size:.75rem;font-weight:700;color:var(--brown); }
.pay-method-sub  { font-size:.63rem;color:rgba(59,42,26,.38); }

/* ── Bottom extra cards ─────────────────────────────── */
.extras { display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:4px; }
.extra-card { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:12px;padding:14px 16px;display:flex;align-items:center;gap:12px;transition:all .18s; }
.extra-card:hover { border-color:rgba(45,110,110,.2);background:rgba(45,110,110,.025);transform:translateY(-2px);box-shadow:0 4px 16px rgba(59,42,26,.08); }
.extra-icon { width:36px;height:36px;background:rgba(45,110,110,.08);border-radius:9px;display:flex;align-items:center;justify-content:center;color:var(--teal);flex-shrink:0; }
.extra-icon svg { width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8; }
.extra-icon.gold-icon { background:rgba(212,162,84,.1);color:var(--gold); }
.extra-label { font-size:.72rem;color:rgba(59,42,26,.38); }
.extra-val   { font-size:.82rem;font-weight:600;color:var(--brown);margin-top:1px; }

/* ── Timeline (payment steps) ───────────────────────── */
.timeline { padding:4px 0; }
.tl-step  { display:flex;gap:14px;padding-bottom:16px;position:relative; }
.tl-step:last-child { padding-bottom:0; }
.tl-step:last-child .tl-line { display:none; }
.tl-dot   { width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.72rem;font-weight:700;position:relative;z-index:1; }
.tl-dot-done   { background:rgba(45,110,110,.12);color:var(--teal);border:1.5px solid rgba(45,110,110,.25); }
.tl-dot-active { background:var(--teal);color:var(--white);box-shadow:0 0 0 4px rgba(45,110,110,.12); }
.tl-dot-wait   { background:var(--cream);color:rgba(59,42,26,.3);border:1.5px solid rgba(59,42,26,.12); }
.tl-dot svg    { width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5; }
.tl-line  { position:absolute;left:13px;top:28px;bottom:0;width:1.5px;background:rgba(59,42,26,.08); }
.tl-body  { flex:1;padding-top:4px; }
.tl-label { font-size:.82rem;font-weight:600;color:var(--brown); }
.tl-sub   { font-size:.72rem;color:rgba(59,42,26,.38);margin-top:2px; }

/* ── Responsive ─────────────────────────────────────── */
@media(max-width:960px) { .detail-grid { grid-template-columns:1fr; } }
@media(max-width:700px) { .extras { grid-template-columns:1fr 1fr; } .route-mid { display:none; } }
@media(max-width:480px) { .extras { grid-template-columns:1fr; } .route-hero { padding:18px 16px; } }
</style>

@php
  $schedule  = $booking->schedule;
  $trip      = $schedule->trip;
  $dep       = $schedule->departure_at;
  $arr       = $schedule->arrival_at;
  $mins      = $arr ? $dep->diffInMinutes($arr) : 0;
  $hours     = floor($mins / 60);
  $remMins   = $mins % 60;
  $durStr    = $hours > 0 ? "{$hours}h {$remMins}m" : "{$remMins}m";
  $originLabel = $trip->origin_country ?: ($trip->origin ?? 'Origin');
  $destLabel   = $trip->destination_country ?: ($trip->destination ?? 'Destination');
  $originCode  = strtoupper(substr(preg_replace('/[^a-zA-Z]/','', $originLabel), 0, 3));
  $destCode    = strtoupper(substr(preg_replace('/[^a-zA-Z]/','', $destLabel), 0, 3));
  $coords = [
    'Philippines'=>[12.8797,121.7740],'Indonesia'=>[-2.5489,118.0149],'Japan'=>[36.2048,138.2529],
    'South Korea'=>[35.9078,127.7669],'China'=>[35.8617,104.1954],'Singapore'=>[1.3521,103.8198],
    'Malaysia'=>[4.2105,101.9758],'Thailand'=>[15.8700,100.9925],'Vietnam'=>[14.0583,108.2772],
    'United Arab Emirates'=>[23.4241,53.8478],'UAE'=>[23.4241,53.8478],'Saudi Arabia'=>[23.8859,45.0792],
    'Qatar'=>[25.3548,51.1839],'Kuwait'=>[29.3117,47.4818],'United Kingdom'=>[55.3781,-3.4360],
    'UK'=>[55.3781,-3.4360],'Germany'=>[51.1657,10.4515],'France'=>[46.2276,2.2137],
    'Italy'=>[41.8719,12.5674],'Spain'=>[40.4637,-3.7492],'Turkey'=>[38.9637,35.2433],
    'United States'=>[37.0902,-95.7129],'USA'=>[37.0902,-95.7129],'Australia'=>[-25.2744,133.7751],
    'New Zealand'=>[-40.9006,174.8860],'Guam'=>[13.4443,144.7937],'Taiwan'=>[23.6978,120.9605],
    'Hong Kong'=>[22.3193,114.1694],'India'=>[20.5937,78.9629],'Cambodia'=>[12.5657,104.9910],
    'Myanmar'=>[19.1633,95.9560],'Oman'=>[21.4735,55.9754],'Canada'=>[56.1304,-106.3468],
    'Russia'=>[61.5240,105.3188],
  ];
  $originCoords = $coords[$originLabel] ?? $coords[$trip->origin ?? ''] ?? [14.5995,120.9842];
  $destCoords   = $coords[$destLabel]   ?? $coords[$trip->destination ?? ''] ?? [10.3157,123.8854];
  $midLat = ($originCoords[0] + $destCoords[0]) / 2;
  $midLng = ($originCoords[1] + $destCoords[1]) / 2;
  $s = $booking->status;
@endphp

{{-- Back link --}}
<a href="{{ route('bookings.index') }}" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Back to My Bookings
</a>

{{-- Page header --}}
<div class="page-eyebrow">Your Travel Hub</div>
<h1 class="page-title">Booking <em>Details</em></h1>
<p class="page-subtitle">Reference #{{ $booking->reference_no }} · {{ $dep ? $dep->format('F j, Y') : '—' }}</p>

{{-- Status banner --}}
@if($s === 'pending')
<div class="status-banner sb-pending">
  <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
  <div>
    <div class="status-banner-text">Awaiting Admin Approval</div>
    <div class="status-banner-sub">Your booking has been received and is currently under review. Pay Now will appear once confirmed.</div>
  </div>
</div>
@elseif($s === 'confirmed' && !$booking->payment)
<div class="status-banner sb-confirmed">
  <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
  <div>
    <div class="status-banner-text">Booking Approved — Payment Required</div>
    <div class="status-banner-sub">Great news! Your booking is approved. Complete payment below to secure your seat.</div>
  </div>
</div>
@elseif($s === 'ticketed')
<div class="status-banner sb-ticketed">
  <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
  <div>
    <div class="status-banner-text">Payment Confirmed — Ticket Issued</div>
    <div class="status-banner-sub">Your booking is fully confirmed and tickets are ready to download.</div>
  </div>
</div>
@elseif($s === 'cancelled')
<div class="status-banner sb-cancelled">
  <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
  <div>
    <div class="status-banner-text">Booking Cancelled</div>
    <div class="status-banner-sub">This booking has been cancelled. If you believe this is a mistake, please contact support.</div>
  </div>
</div>
@endif

{{-- Route Hero Card --}}
<div class="route-hero">
  <div class="route-inner">
    <div class="city-block" style="text-align:left;">
      <div class="city-code">{{ $originCode }}</div>
      <div class="city-name">{{ $originLabel }}@if($trip->origin && $trip->origin !== $originLabel) · {{ $trip->origin }}@endif</div>
      <div class="city-time">{{ $dep ? $dep->format('h:i A') : '—' }}</div>
      <div class="city-date">{{ $dep ? $dep->format('M d, Y') : '—' }}</div>
    </div>
    <div class="route-mid">
      <div class="dur-badge">⏱ {{ $durStr }}</div>
      <div class="route-line"></div>
      <div style="font-size:.7rem;color:rgba(59,42,26,.32);">Direct · {{ $trip->operator ?? 'N/A' }}</div>
      <div class="fstats">
        <div><div class="fstat-label">Hours</div><div class="fstat-val">{{ $hours }}h</div></div>
        <div><div class="fstat-label">Min</div><div class="fstat-val">{{ $remMins }}m</div></div>
        <div><div class="fstat-label">Class</div><div class="fstat-val">{{ ucfirst($schedule->fare_class ?? 'Economy') }}</div></div>
        <div><div class="fstat-label">Pax</div><div class="fstat-val">{{ $booking->passenger_count }}</div></div>
        <div><div class="fstat-label">Fare</div><div class="fstat-val gold">₱{{ number_format($booking->total_amount, 0) }}</div></div>
      </div>
    </div>
    <div class="city-block" style="text-align:right;">
      <div class="city-code">{{ $destCode }}</div>
      <div class="city-name">{{ $destLabel }}@if($trip->destination && $trip->destination !== $destLabel) · {{ $trip->destination }}@endif</div>
      <div class="city-time">{{ $arr ? $arr->format('h:i A') : '—' }}</div>
      <div class="city-date">{{ $arr ? $arr->format('M d, Y') : '—' }}</div>
    </div>
  </div>
</div>

{{-- Interactive Map --}}
<div id="flight-map"></div>

{{-- Two-column detail grid --}}
<div class="detail-grid">

  {{-- LEFT: Booking & Trip Info --}}
  <div>
    {{-- Booking reference panel --}}
    <div class="panel">
      <div class="ref-bar">
        <div>
          <div class="ref-label">Booking Reference</div>
          <div class="ref-val">{{ $booking->reference_no }}</div>
        </div>
        <span class="pill st-{{ $s }}">{{ ucfirst($s) }}</span>
      </div>

      <div class="panel-section">
        <div class="section-eyebrow">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Passenger
        </div>
        <div class="user-chip">
          <div class="user-av">{{ strtoupper(substr($booking->user->name ?? 'U', 0, 2)) }}</div>
          <div>
            <div class="user-name">{{ $booking->user->name ?? '—' }}</div>
            <div class="user-email">{{ $booking->user->email ?? '—' }}</div>
          </div>
        </div>
      </div>

      <div class="panel-section">
        <div class="section-eyebrow">
          <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
          Flight Information
        </div>
        <div class="info-row"><span class="info-k">Route</span><span class="info-v">{{ $originLabel }} → {{ $destLabel }}</span></div>
        <div class="info-row"><span class="info-k">Departure</span><span class="info-v">{{ $dep?->format('M d, Y · h:i A') ?? '—' }}</span></div>
        <div class="info-row"><span class="info-k">Arrival</span><span class="info-v">{{ $arr?->format('M d, Y · h:i A') ?? '—' }}</span></div>
        <div class="info-row"><span class="info-k">Duration</span><span class="info-v">{{ $durStr }}</span></div>
        <div class="info-row"><span class="info-k">Airline / Operator</span><span class="info-v">{{ $trip->operator ?? '—' }}</span></div>
        <div class="info-row"><span class="info-k">Fare Class</span><span class="info-v">{{ ucfirst($schedule->fare_class ?? 'Economy') }}</span></div>
        <div class="info-row"><span class="info-k">Passengers</span><span class="info-v">{{ $booking->passenger_count }} adult(s)</span></div>
        <div class="info-row"><span class="info-k">Date Booked</span><span class="info-v">{{ $booking->created_at->format('M d, Y') }}</span></div>
      </div>
    </div>
  </div>

  {{-- RIGHT: Fare + Payment + Actions --}}
  <div>
    {{-- Fare summary panel --}}
    <div class="panel">
      <div class="panel-section">
        <div class="section-eyebrow">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          Total Fare
        </div>
        <div class="amount-box">
          @if($booking->has_promo ?? false)
            <div class="amount-orig">₱{{ number_format($booking->original_amount ?? 0, 2) }}</div>
          @endif
          <div class="amount-main">₱{{ number_format($booking->total_amount, 2) }}</div>
          <div class="amount-sub">inclusive of taxes &amp; fees</div>
          @if($booking->has_promo ?? false)
            <div class="promo-tag">
              🏷 {{ $booking->promo->promo_code ?? '' }} — saved ₱{{ number_format($booking->discount_amount ?? 0, 2) }}
            </div>
          @endif
        </div>
      </div>

      {{-- Payment details (if paid) --}}
      @if($booking->payment)
      <div class="panel-section">
        <div class="section-eyebrow">
          <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          Payment Details
        </div>
        <div class="info-row"><span class="info-k">Method</span><span class="info-v">{{ ucfirst($booking->payment->method ?? '—') }}</span></div>
        <div class="info-row"><span class="info-k">Status</span><span class="info-v">{{ ucfirst($booking->payment->status ?? '—') }}</span></div>
        <div class="info-row"><span class="info-k">Transaction Ref</span><span class="info-v" style="font-size:.72rem;font-family:monospace;">{{ $booking->payment->transaction_ref ?? '—' }}</span></div>
      </div>
      @endif

      {{-- Journey progress timeline --}}
      <div class="panel-section">
        <div class="section-eyebrow" style="margin-bottom:14px;">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Booking Progress
        </div>
        <div class="timeline">
          {{-- Step 1: Booking Received --}}
          <div class="tl-step">
            <div class="tl-dot tl-dot-done">
              <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="tl-line"></div>
            <div class="tl-body">
              <div class="tl-label">Booking Received</div>
              <div class="tl-sub">{{ $booking->created_at->format('M d, Y · h:i A') }}</div>
            </div>
          </div>
          {{-- Step 2: Admin Approval --}}
          <div class="tl-step">
            <div class="tl-dot {{ in_array($s, ['confirmed','ticketed']) ? 'tl-dot-done' : ($s === 'pending' ? 'tl-dot-active' : 'tl-dot-wait') }}">
              @if(in_array($s, ['confirmed','ticketed']))
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              @elseif($s === 'pending')
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              @else
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              @endif
            </div>
            <div class="tl-line"></div>
            <div class="tl-body">
              <div class="tl-label">Admin Approval</div>
              <div class="tl-sub">{{ in_array($s, ['confirmed','ticketed']) ? 'Approved' : ($s === 'pending' ? 'Pending review' : 'Rejected') }}</div>
            </div>
          </div>
          {{-- Step 3: Payment --}}
          <div class="tl-step">
            <div class="tl-dot {{ $s === 'ticketed' ? 'tl-dot-done' : (($s === 'confirmed' && !$booking->payment) ? 'tl-dot-active' : 'tl-dot-wait') }}">
              @if($s === 'ticketed')
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              @elseif($s === 'confirmed' && !$booking->payment)
                <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
              @else
                <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
              @endif
            </div>
            <div class="tl-line"></div>
            <div class="tl-body">
              <div class="tl-label">Payment</div>
              <div class="tl-sub">{{ $s === 'ticketed' ? 'Paid · ₱'.number_format($booking->total_amount,2) : ($s === 'confirmed' && !$booking->payment ? 'Awaiting payment' : 'Not yet due') }}</div>
            </div>
          </div>
          {{-- Step 4: Ticket Issued --}}
          <div class="tl-step">
            <div class="tl-dot {{ $s === 'ticketed' ? 'tl-dot-done' : 'tl-dot-wait' }}">
              @if($s === 'ticketed')
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              @else
                <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
              @endif
            </div>
            <div class="tl-body">
              <div class="tl-label">Ticket Issued</div>
              <div class="tl-sub">{{ $s === 'ticketed' ? 'Ready for download' : 'Pending payment' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Action panel --}}
    <div class="panel">
      <div class="panel-head">
        <div class="panel-title-wrap"><div class="panel-dot"></div><div class="panel-title">Actions</div></div>
      </div>
      <div class="panel-body">
        @if($s === 'ticketed' && $booking->payment)
          <div class="btn-group">
            <a href="{{ route('bookings.receipt', $booking->id) }}" class="btn btn-receipt">
              <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
              View Receipt &amp; Tickets
            </a>
          </div>

        @elseif($s === 'confirmed' && !$booking->payment)
          <div class="pay-method-wrap">
            <div class="pay-method-label">Select Payment Method</div>
            <div class="pay-method-grid">
              <div class="pay-method-card selected" onclick="selectMethod(this,'gcash')">
                <div class="pay-method-icon" style="background:#0070ff14;color:#0070ff;">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <div class="pay-method-name">GCash</div>
                <div class="pay-method-sub">Instant transfer</div>
              </div>
              <div class="pay-method-card" onclick="selectMethod(this,'maya')">
                <div class="pay-method-icon" style="background:#00a86b14;color:#00a86b;">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div class="pay-method-name">Maya</div>
                <div class="pay-method-sub">Instant transfer</div>
              </div>
              <div class="pay-method-card" onclick="selectMethod(this,'credit_card')">
                <div class="pay-method-icon" style="background:#d4a25414;color:#9a7030;">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/><line x1="5" y1="15" x2="9" y2="15"/><line x1="11" y1="15" x2="13" y2="15"/></svg>
                </div>
                <div class="pay-method-name">Credit Card</div>
                <div class="pay-method-sub">Visa / Mastercard</div>
              </div>
              <div class="pay-method-card" onclick="selectMethod(this,'bank_transfer')">
                <div class="pay-method-icon" style="background:#2d6e6e14;color:var(--teal);">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;"><line x1="3" y1="22" x2="21" y2="22"/><line x1="6" y1="18" x2="6" y2="11"/><line x1="10" y1="18" x2="10" y2="11"/><line x1="14" y1="18" x2="14" y2="11"/><line x1="18" y1="18" x2="18" y2="11"/><polygon points="12 2 2 7 22 7"/></svg>
                </div>
                <div class="pay-method-name">Bank Transfer</div>
                <div class="pay-method-sub">Online banking</div>
              </div>
            </div>
          </div>
          <div class="btn-group">
            <form method="POST" action="{{ route('bookings.pay', $booking->id) }}" style="display:inline" id="payForm"
                  onsubmit="return confirm('Pay ₱{{ number_format($booking->total_amount,2) }} via ' + document.getElementById('selectedMethod').value.replace(/_/g,' ') + '?')">
              @csrf
              <input type="hidden" name="payment_method" id="selectedMethod" value="gcash">
              <button type="submit" class="btn btn-pay">
                <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Pay Now
              </button>
            </form>
            <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" style="display:inline"
                  onsubmit="return confirm('Cancel this booking?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-cancel">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Cancel
              </button>
            </form>
          </div>

        @elseif($s === 'pending')
          <div class="btn-group">
            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-edit">
              <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4L18.5 2.5z"/></svg>
              Edit Booking
            </a>
            <form method="POST" action="{{ route('bookings.destroy', $booking->id) }}" style="display:inline"
                  onsubmit="return confirm('Cancel this booking?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-cancel">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Cancel
              </button>
            </form>
          </div>
        @elseif($s === 'cancelled')
          <a href="{{ route('bookings.create') }}" class="btn btn-pay">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Book Again
          </a>
        @endif
      </div>
    </div>
  </div>

</div>{{-- /detail-grid --}}

{{-- Bottom extras row --}}
<div class="extras">
  <div class="extra-card">
    <div class="extra-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
    <div><div class="extra-label">Secure Payment</div><div class="extra-val">SSL Encrypted</div></div>
  </div>
  <div class="extra-card">
    <div class="extra-icon"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.36 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
    <div><div class="extra-label">24/7 Support</div><div class="extra-val">Always available</div></div>
  </div>
  <div class="extra-card">
    <div class="extra-icon gold-icon"><svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg></div>
    <div><div class="extra-label">Refund Policy</div><div class="extra-val">Free cancellation 24h</div></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var oLat={{ $originCoords[0] }},oLng={{ $originCoords[1] }};
  var dLat={{ $destCoords[0] }},dLng={{ $destCoords[1] }};
  var midLat={{ $midLat }},midLng={{ $midLng }};
  var originCity=@json($originLabel),destCity=@json($destLabel);
  var operator=@json($trip->operator ?? 'N/A'),durStr=@json($durStr);
  var depTime=@json($dep ? $dep->format('M d, Y h:i A') : '—');
  var arrTime=@json($arr ? $arr->format('M d, Y h:i A') : '—');

  var map=L.map('flight-map',{center:[midLat,midLng],zoom:4,zoomControl:true});
  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{
    attribution:'© OpenStreetMap © CARTO',subdomains:'abcd',maxZoom:19
  }).addTo(map);

  var oIcon=L.divIcon({className:'',html:'<div style="width:14px;height:14px;background:#2d6e6e;border:2.5px solid #fff;border-radius:50%;box-shadow:0 0 12px rgba(45,110,110,.6);"></div>',iconSize:[14,14],iconAnchor:[7,7]});
  var dIcon=L.divIcon({className:'',html:'<div style="width:14px;height:14px;background:#d4a254;border:2.5px solid #fff;border-radius:50%;box-shadow:0 0 12px rgba(212,162,84,.6);"></div>',iconSize:[14,14],iconAnchor:[7,7]});
  var planeIcon=L.divIcon({className:'',html:'<div style="font-size:20px;filter:drop-shadow(0 0 4px rgba(45,110,110,.8));transform:rotate(45deg);">✈</div>',iconSize:[24,24],iconAnchor:[12,12]});

  var oM=L.marker([oLat,oLng],{icon:oIcon}).addTo(map);
  var dM=L.marker([dLat,dLng],{icon:dIcon}).addTo(map);
  oM.bindPopup('<div style="text-align:center;padding:4px 8px;font-family:DM Sans,sans-serif"><div style="font-size:14px;font-weight:800;color:#2d6e6e">'+originCity+'</div><div style="font-size:11px;color:#888;margin-top:2px">Departure</div><div style="font-size:12px;color:#3b2a1a;margin-top:4px">'+depTime+'</div></div>');
  dM.bindPopup('<div style="text-align:center;padding:4px 8px;font-family:DM Sans,sans-serif"><div style="font-size:14px;font-weight:800;color:#d4a254">'+destCity+'</div><div style="font-size:11px;color:#888;margin-top:2px">Arrival</div><div style="font-size:12px;color:#3b2a1a;margin-top:4px">'+arrTime+'</div></div>');

  function arc(lat1,lng1,lat2,lng2,n){
    var pts=[];
    for(var i=0;i<=n;i++){
      var t=i/n,lat=lat1+(lat2-lat1)*t,lng=lng1+(lng2-lng1)*t;
      var c=Math.sin(Math.PI*t)*(Math.abs(lat2-lat1)*0.3+2);
      pts.push([lat+c,lng]);
    }
    return pts;
  }
  var pts=arc(oLat,oLng,dLat,dLng,60);
  L.polyline(pts,{color:'#2d6e6e',weight:2,opacity:.2,dashArray:'8,8'}).addTo(map);
  L.polyline(pts,{color:'#2d6e6e',weight:1.5,opacity:.65}).addTo(map);

  var pM=L.marker(pts[0],{icon:planeIcon}).addTo(map);
  pM.bindPopup('<div style="text-align:center;font-family:DM Sans,sans-serif"><div style="font-weight:700;color:#2d6e6e">✈ In Flight</div><div style="font-size:11px;color:#888;margin-top:3px">'+originCity+' → '+destCity+'</div></div>');

  var step=0,total=pts.length,fwd=true;
  setInterval(function(){
    fwd ? step++ : step--;
    if(step>=total-1) fwd=false;
    if(step<=0) fwd=true;
    pM.setLatLng(pts[step]);
    if(step<total-1){
      var p1=pts[step],p2=pts[step+1];
      var a=Math.atan2(p2[1]-p1[1],p2[0]-p1[0])*180/Math.PI;
      var el=pM.getElement();
      if(el){var d=el.querySelector('div');if(d)d.style.transform='rotate('+(a+45)+'deg)';}
    }
  },80);

  map.fitBounds([[oLat,oLng],[dLat,dLng]],{padding:[60,60]});
  setTimeout(function(){oM.openPopup();},800);
});

function selectMethod(card, method) {
  document.querySelectorAll('.pay-method-card').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');
  document.getElementById('selectedMethod').value = method;
}
</script>
@endsection