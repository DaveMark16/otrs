@extends('layouts.user')
@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking')

@section('content')
<style>
/* ── Breadcrumb ─────────────────────────────────────── */
.breadcrumb { display:flex;align-items:center;gap:6px;font-size:.78rem;color:rgba(59,42,26,.38);margin-bottom:22px;flex-wrap:wrap; }
.breadcrumb a { color:rgba(59,42,26,.38);transition:color .15s; }
.breadcrumb a:hover { color:var(--teal); }
.breadcrumb .bc-sep { opacity:.4; }
.breadcrumb .bc-cur { color:var(--teal);font-weight:600; }

/* ── Page header ────────────────────────────────────── */
.page-eyebrow { font-size:.67rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:6px;display:flex;align-items:center;gap:7px; }
.page-eyebrow::before { content:'';display:block;width:28px;height:2px;background:var(--gold);border-radius:2px; }
.page-title { font-family:var(--ff-head);font-size:1.85rem;font-weight:900;color:var(--brown);line-height:1.15;margin-bottom:4px; }
.page-title em { color:var(--teal);font-style:italic; }
.page-subtitle { font-size:.82rem;color:rgba(59,42,26,.42);margin-bottom:26px; }

/* ── Ref tag ────────────────────────────────────────── */
.ref-tag { display:inline-flex;align-items:center;gap:7px;background:rgba(45,110,110,.07);border:1.5px solid rgba(45,110,110,.18);color:var(--teal);font-family:monospace;font-size:.85rem;font-weight:700;padding:5px 13px;border-radius:20px;margin-bottom:18px; }

/* ── Info banner ────────────────────────────────────── */
.info-banner { display:flex;align-items:flex-start;gap:11px;background:rgba(45,110,110,.05);border:1.5px solid rgba(45,110,110,.18);border-radius:var(--radius-sm);padding:13px 16px;font-size:.8rem;color:var(--teal);margin-bottom:22px;line-height:1.5; }
.info-banner svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0;margin-top:1px; }

/* ── Error banner ───────────────────────────────────── */
.error-banner { display:flex;align-items:center;gap:10px;background:rgba(180,60,60,.06);border:1.5px solid rgba(180,60,60,.2);border-radius:var(--radius-sm);padding:12px 16px;font-size:.82rem;color:#b44444;margin-bottom:18px; }
.error-banner svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0; }

/* ── Layout grid ────────────────────────────────────── */
.edit-grid { display:grid;grid-template-columns:1.5fr 1fr;gap:18px;align-items:start; }

/* ── Panel / card ───────────────────────────────────── */
.panel { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 14px rgba(59,42,26,.05);margin-bottom:14px; }
.panel:last-child { margin-bottom:0; }
.panel-head { display:flex;align-items:center;gap:12px;padding:18px 22px;border-bottom:1.5px solid rgba(59,42,26,.07);background:var(--sand); }
.panel-icon { width:38px;height:38px;background:linear-gradient(135deg,var(--gold),var(--tan));border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 10px rgba(212,162,84,.3); }
.panel-icon svg { width:18px;height:18px;stroke:var(--brown);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round; }
.panel-title { font-family:var(--ff-head);font-size:1rem;font-weight:700;color:var(--brown); }
.panel-sub   { font-size:.73rem;color:rgba(59,42,26,.4);margin-top:2px; }
.panel-body  { padding:22px; }

/* ── Form fields ────────────────────────────────────── */
.f-group { margin-bottom:18px; }
.f-group:last-child { margin-bottom:0; }
.f-row { display:grid;grid-template-columns:1fr 1fr;gap:14px; }
.f-label { display:block;font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.45);margin-bottom:7px; }
.req { color:var(--teal); }
.f-input {
  width:100%;
  background:var(--cream);
  border:1.5px solid rgba(59,42,26,.12);
  border-radius:var(--radius-sm);
  padding:11px 14px;
  font-size:.86rem;
  color:var(--brown);
  font-family:var(--ff-body);
  outline:none;
  transition:border-color .2s,box-shadow .2s;
}
.f-input:focus { border-color:var(--teal);box-shadow:0 0 0 3px rgba(45,110,110,.08); }
.f-input.f-readonly { background:rgba(59,42,26,.04);color:rgba(59,42,26,.4);cursor:not-allowed;border-style:dashed; }
.f-input.f-error { border-color:#e05555;box-shadow:0 0 0 3px rgba(224,85,85,.08); }

/* ── Inline field error ─────────────────────────────── */
.field-error { display:none;margin-top:8px;font-size:.75rem;color:#b44444;background:rgba(180,68,68,.06);border:1.5px solid rgba(180,68,68,.2);border-radius:8px;padding:8px 12px;align-items:center;gap:7px; }
.field-error svg { width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5;flex-shrink:0; }
.field-error.visible { display:flex; }

/* ── Summary box ────────────────────────────────────── */
.summary-box { background:var(--sand);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius-sm);padding:18px; }
.summary-head { font-size:.67rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:14px;display:flex;align-items:center;gap:6px; }
.summary-head::before { content:'';display:block;width:16px;height:2px;background:var(--gold);border-radius:2px; }
.s-row { display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid rgba(59,42,26,.06);font-size:.82rem; }
.s-row:last-of-type { border-bottom:none; }
.s-k { color:rgba(59,42,26,.42); }
.s-v { color:var(--brown);font-weight:600;text-align:right; }
.s-v.seats-ok   { color:#2e7d52; }
.s-v.seats-warn { color:#a07030; }
.s-v.seats-crit { color:#b44444; }
.summary-total { display:flex;justify-content:space-between;align-items:center;padding-top:14px;margin-top:6px;border-top:2px solid rgba(59,42,26,.1); }
.total-label { font-size:.84rem;color:rgba(59,42,26,.55);font-weight:600; }
.total-value { font-family:var(--ff-head);font-size:2rem;font-weight:900;color:var(--gold);line-height:1; }

/* ── Action buttons ─────────────────────────────────── */
.btn-row { display:flex;gap:10px;justify-content:flex-end;margin-top:18px;flex-wrap:wrap; }
.btn { padding:10px 22px;border-radius:50px;font-size:.84rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .18s;font-family:var(--ff-body);white-space:nowrap;text-decoration:none; }
.btn svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }
.btn-cancel-act { background:transparent;color:rgba(59,42,26,.5);border:1.5px solid rgba(59,42,26,.14); }
.btn-cancel-act:hover { border-color:rgba(59,42,26,.28);color:var(--brown); }
.btn-save { background:var(--teal);color:var(--white);border:none;box-shadow:0 4px 14px rgba(45,110,110,.25); }
.btn-save:hover { background:var(--teal-lt);transform:translateY(-1px);box-shadow:0 6px 20px rgba(45,110,110,.3); }
.btn-save:disabled { opacity:.4;cursor:not-allowed;transform:none;box-shadow:none; }

/* ── Responsive ─────────────────────────────────────── */
@media(max-width:860px) { .edit-grid { grid-template-columns:1fr; } }
@media(max-width:480px) { .f-row { grid-template-columns:1fr; } }
</style>

{{-- Breadcrumb --}}
<nav class="breadcrumb">
  <a href="{{ route('bookings.index') }}">My Bookings</a>
  <span class="bc-sep">→</span>
  <a href="{{ route('bookings.show', $booking->id) }}">{{ $booking->reference_no }}</a>
  <span class="bc-sep">→</span>
  <span class="bc-cur">Edit</span>
</nav>

{{-- Page header --}}
<div class="page-eyebrow">Your Travel Hub</div>
<h1 class="page-title">Edit <em>Booking</em></h1>
<p class="page-subtitle">You can only update the passenger count and contact email.</p>

{{-- Reference tag --}}
<div class="ref-tag">
  <svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" fill="none" stroke-width="2"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg>
  {{ $booking->reference_no }}
</div>

{{-- Info banner --}}
<div class="info-banner">
  <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
  You can only update the number of passengers and contact email. Trip schedule cannot be changed after booking.
</div>

{{-- Validation errors --}}
@if($errors->isNotEmpty())
<div class="error-banner">
  <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
  {{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('bookings.update', $booking->id) }}" id="booking-edit-form">
@csrf
@method('PUT')
<input type="hidden" name="status" value="{{ $booking->status }}" />

<div class="edit-grid">

  {{-- LEFT: Form panel --}}
  <div>
    <div class="panel">
      <div class="panel-head">
        <div class="panel-icon">
          <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4L18.5 2.5z"/></svg>
        </div>
        <div>
          <div class="panel-title">Update Booking</div>
          <div class="panel-sub">Modify passenger count or contact email</div>
        </div>
      </div>
      <div class="panel-body">

        {{-- Read-only schedule --}}
        <div class="f-group">
          <label class="f-label">Trip Schedule <span style="font-size:.65rem;color:rgba(59,42,26,.32);font-weight:500;text-transform:none;letter-spacing:0;">(cannot be changed)</span></label>
          <input type="text" class="f-input f-readonly" readonly
            value="{{ $booking->schedule->trip->name }} · {{ $booking->schedule->departure_at->format('M d, Y h:i A') }}" />
        </div>

        {{-- Editable fields --}}
        <div class="f-row">
          <div class="f-group">
            <label class="f-label" for="pax-input">Number of Passengers <span class="req">*</span></label>
            <input type="number" class="f-input" name="passenger_count" id="pax-input"
              value="{{ old('passenger_count', $booking->passenger_count) }}"
              min="1" max="{{ $booking->schedule->available_seats }}"
              oninput="updateTotal()" required />
            <div class="field-error" id="pax-error">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
              Only <strong style="margin:0 3px;">{{ $booking->schedule->available_seats }}</strong> seat(s) available.
            </div>
          </div>
          <div class="f-group">
            <label class="f-label" for="contact-email">Contact Email <span class="req">*</span></label>
            <input type="email" class="f-input" name="contact_email" id="contact-email"
              value="{{ old('contact_email', $booking->contact_email) }}" required />
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- RIGHT: Summary + actions --}}
  <div>
    <div class="panel">
      <div class="panel-body">
        <div class="summary-box">
          <div class="summary-head">Updated Summary</div>
          <div class="s-row">
            <span class="s-k">Trip</span>
            <span class="s-v">{{ $booking->schedule->trip->name }}</span>
          </div>
          <div class="s-row">
            <span class="s-k">Route</span>
            <span class="s-v">
              {{ $booking->schedule->trip->origin_country ?: $booking->schedule->trip->origin }}
              →
              {{ $booking->schedule->trip->destination_country ?: $booking->schedule->trip->destination }}
            </span>
          </div>
          <div class="s-row">
            <span class="s-k">Departure</span>
            <span class="s-v">{{ $booking->schedule->departure_at->format('M d, Y h:i A') }}</span>
          </div>
          <div class="s-row">
            <span class="s-k">Fare Class</span>
            <span class="s-v">{{ ucfirst($booking->schedule->fare_class ?? 'Economy') }}</span>
          </div>
          <div class="s-row">
            <span class="s-k">Available Seats</span>
            @php
              $seats = $booking->schedule->available_seats;
              $seatsClass = $seats <= 5 ? 'seats-crit' : ($seats <= 20 ? 'seats-warn' : 'seats-ok');
            @endphp
            <span class="s-v {{ $seatsClass }}">
              {{ $seats }}
              @if($seats <= 5) &nbsp;⚠ Almost full
              @elseif($seats <= 20) &nbsp;· Limited
              @endif
            </span>
          </div>
          <div class="s-row">
            <span class="s-k">Base Fare / pax</span>
            <span class="s-v">₱{{ number_format($booking->schedule->base_fare, 2) }}</span>
          </div>
          <div class="s-row">
            <span class="s-k">Passengers</span>
            <span class="s-v" id="disp-pax">{{ $booking->passenger_count }}</span>
          </div>
          <div class="summary-total">
            <span class="total-label">New Total</span>
            <span class="total-value" id="disp-total">₱{{ number_format($booking->schedule->base_fare * $booking->passenger_count, 2) }}</span>
          </div>
        </div>
      </div>
    </div>

    {{-- Action buttons --}}
    <div class="btn-row">
      <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-cancel-act">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        Cancel
      </a>
      <button type="submit" class="btn btn-save" id="save-btn">
        <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Save Changes
      </button>
    </div>
  </div>

</div>
</form>

<script>
var baseFare = {{ $booking->schedule->base_fare }};
var maxSeats = {{ $booking->schedule->available_seats }};

function updateTotal() {
  var paxInput = document.getElementById('pax-input');
  var errorBox = document.getElementById('pax-error');
  var saveBtn  = document.getElementById('save-btn');
  var pax      = parseInt(paxInput.value) || 1;

  if (pax > maxSeats || pax < 1) {
    errorBox.classList.add('visible');
    paxInput.classList.add('f-error');
    saveBtn.disabled = true;
  } else {
    errorBox.classList.remove('visible');
    paxInput.classList.remove('f-error');
    saveBtn.disabled = false;
  }

  var total = baseFare * Math.max(1, Math.min(pax, maxSeats));
  document.getElementById('disp-pax').textContent   = pax;
  document.getElementById('disp-total').textContent = '₱' + total.toLocaleString('en-PH', { minimumFractionDigits: 2 });
}

document.getElementById('booking-edit-form').addEventListener('submit', function (e) {
  var pax = parseInt(document.getElementById('pax-input').value) || 1;
  if (pax > maxSeats || pax < 1) {
    e.preventDefault();
    document.getElementById('pax-error').classList.add('visible');
    document.getElementById('pax-input').classList.add('f-error');
  }
});
</script>
@endsection