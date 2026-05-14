@extends('layouts.user')
@section('page-title', 'Ticket — ' . ($ticket->ticket_no ?? 'Details'))

@section('content')
<style>
/* ── Page header ────────────────────────────────────── */
.page-eyebrow { font-size:.67rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:6px;display:flex;align-items:center;gap:7px; }
.page-eyebrow::before { content:'';display:block;width:28px;height:2px;background:var(--gold);border-radius:2px; }
.page-title { font-family:var(--ff-head);font-size:1.85rem;font-weight:900;color:var(--brown);line-height:1.15;margin-bottom:4px; }
.page-title em { color:var(--teal);font-style:italic; }
.page-subtitle { font-size:.82rem;color:rgba(59,42,26,.42);margin-bottom:26px; }

/* ── Back link ──────────────────────────────────────── */
.back-link { display:inline-flex;align-items:center;gap:6px;font-size:.8rem;font-weight:600;color:var(--teal);text-decoration:none;margin-bottom:20px;opacity:.8;transition:opacity .15s; }
.back-link:hover { opacity:1; }
.back-link svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2; }

/* ── Ticket card ────────────────────────────────────── */
.ticket-card {
  background:var(--white);
  border:1.5px solid rgba(59,42,26,.08);
  border-radius:var(--radius);
  overflow:hidden;
  box-shadow:0 2px 14px rgba(59,42,26,.06);
  max-width:720px;
}

/* Header strip */
.ticket-header {
  background:linear-gradient(135deg, var(--teal), var(--teal-lt));
  padding:28px 32px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:16px;
}
.ticket-header-left {}
.ticket-no-label { font-size:.67rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:4px; }
.ticket-no-value { font-family:monospace;font-size:1.5rem;font-weight:700;color:#fff;letter-spacing:.05em; }
.ticket-status-badge {
  padding:6px 16px;border-radius:20px;font-size:.75rem;font-weight:700;
  background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.3);
}

/* Route strip */
.route-strip {
  display:flex;align-items:center;justify-content:center;gap:20px;
  padding:24px 32px;border-bottom:1.5px solid rgba(59,42,26,.07);
  background:var(--sand);
}
.route-city { text-align:center; }
.route-city-code { font-family:var(--ff-head);font-size:2rem;font-weight:900;color:var(--brown); }
.route-city-name { font-size:.72rem;color:rgba(59,42,26,.45);margin-top:2px; }
.route-arrow { display:flex;flex-direction:column;align-items:center;gap:4px; }
.route-arrow-line { width:80px;height:2px;background:linear-gradient(90deg,var(--teal),var(--gold));border-radius:2px; }
.route-arrow-label { font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.3); }

/* Details grid */
.details-grid {
  display:grid;grid-template-columns:repeat(3,1fr);gap:0;
  border-bottom:1.5px solid rgba(59,42,26,.07);
}
.detail-cell {
  padding:20px 24px;
  border-right:1.5px solid rgba(59,42,26,.07);
}
.detail-cell:last-child { border-right:none; }
.detail-cell:nth-child(n+4) { border-top:1.5px solid rgba(59,42,26,.07); }
.detail-label { font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.35);margin-bottom:6px; }
.detail-value { font-size:.88rem;font-weight:600;color:var(--brown); }
.detail-value.mono { font-family:monospace; }

/* Passenger section */
.pax-section { padding:20px 24px;border-bottom:1.5px solid rgba(59,42,26,.07); }
.pax-section-label { font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.35);margin-bottom:10px; }
.pax-chip { display:flex;align-items:center;gap:12px; }
.pax-av { width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--tan));display:inline-flex;align-items:center;justify-content:center;font-family:var(--ff-head);font-size:.8rem;font-weight:700;color:var(--brown);flex-shrink:0; }
.pax-name { font-size:.92rem;font-weight:600;color:var(--brown); }

/* Footer / actions */
.ticket-footer { padding:18px 24px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap; }
.ticket-footer-note { font-size:.75rem;color:rgba(59,42,26,.38); }
.btn-cancel-ticket {
  padding:9px 22px;border-radius:50px;font-size:.82rem;font-weight:600;
  background:rgba(180,60,60,.08);color:#b44444;border:1.5px solid rgba(180,60,60,.2);
  cursor:pointer;font-family:var(--ff-body);transition:all .15s;
}
.btn-cancel-ticket:hover { background:rgba(180,60,60,.14);border-color:rgba(180,60,60,.35); }

/* ── Flash messages ─────────────────────────────────── */
.alert { padding:12px 18px;border-radius:10px;font-size:.83rem;font-weight:600;margin-bottom:18px; }
.alert-success { background:rgba(45,110,110,.08);color:var(--teal);border:1.5px solid rgba(45,110,110,.18); }
.alert-error   { background:rgba(180,60,60,.07);color:#b44444;border:1.5px solid rgba(180,60,60,.18); }

@media(max-width:640px) {
  .details-grid { grid-template-columns:repeat(2,1fr); }
  .route-strip  { gap:12px; }
  .route-arrow-line { width:48px; }
}
</style>

{{-- Back link --}}
<a href="{{ route('tickets.index') }}" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15,18 9,12 15,6"/></svg>
  Back to My Tickets
</a>

{{-- Flash --}}
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error">{{ session('error') }}</div>
@endif

{{-- Page heading --}}
<div class="page-eyebrow">Ticket Detail</div>
<h1 class="page-title">Your <em>Ticket</em></h1>
<p class="page-subtitle">Full details for ticket {{ $ticket->ticket_no ?? '—' }}</p>

@php
  $trip     = $ticket->booking->schedule->trip ?? null;
  $schedule = $ticket->booking->schedule ?? null;
  $origin   = $trip->origin ?? '?';
  $dest     = $trip->destination ?? '?';
  $originC  = $trip->origin_country ?? null;
  $destC    = $trip->destination_country ?? null;
  $paxName  = $ticket->passenger_name ?? $ticket->booking->user->name ?? '—';
  $initials = strtoupper(substr($paxName, 0, 2));
@endphp

<div class="ticket-card">

  {{-- Header --}}
  <div class="ticket-header">
    <div class="ticket-header-left">
      <div class="ticket-no-label">Ticket Number</div>
      <div class="ticket-no-value">{{ $ticket->ticket_no ?? '—' }}</div>
    </div>
    <div class="ticket-status-badge">{{ ucfirst($ticket->status) }}</div>
  </div>

  {{-- Route --}}
  <div class="route-strip">
    <div class="route-city">
      <div class="route-city-code">{{ strtoupper(substr($origin, 0, 3)) }}</div>
      <div class="route-city-name">{{ $origin }}{{ $originC ? ', '.$originC : '' }}</div>
    </div>
    <div class="route-arrow">
      <div class="route-arrow-line"></div>
      <div class="route-arrow-label">Direct</div>
    </div>
    <div class="route-city">
      <div class="route-city-code">{{ strtoupper(substr($dest, 0, 3)) }}</div>
      <div class="route-city-name">{{ $dest }}{{ $destC ? ', '.$destC : '' }}</div>
    </div>
  </div>

  {{-- Passenger --}}
  <div class="pax-section">
    <div class="pax-section-label">Passenger</div>
    <div class="pax-chip">
      <div class="pax-av">{{ $initials }}</div>
      <div class="pax-name">{{ $paxName }}</div>
    </div>
  </div>

  {{-- Details grid --}}
  <div class="details-grid">
    <div class="detail-cell">
      <div class="detail-label">Departure</div>
      <div class="detail-value">
        @if($schedule && $schedule->departure_at)
          {{ $schedule->departure_at->format('M d, Y') }}<br>
          <span style="font-size:.78rem;color:rgba(59,42,26,.45);">{{ $schedule->departure_at->format('h:i A') }}</span>
        @else
          —
        @endif
      </div>
    </div>
    <div class="detail-cell">
      <div class="detail-label">Seat</div>
      <div class="detail-value mono">{{ $ticket->seat_no ?? '—' }}</div>
    </div>
    <div class="detail-cell">
      <div class="detail-label">Class</div>
      <div class="detail-value">{{ ucfirst($ticket->fare_class ?? 'Economy') }}</div>
    </div>
    <div class="detail-cell">
      <div class="detail-label">Booking Ref</div>
      <div class="detail-value mono">{{ $ticket->booking->booking_ref ?? '—' }}</div>
    </div>
    <div class="detail-cell">
      <div class="detail-label">Issued At</div>
      <div class="detail-value">
        {{ $ticket->issued_at ? $ticket->issued_at->format('M d, Y h:i A') : '—' }}
      </div>
    </div>
    <div class="detail-cell">
      <div class="detail-label">Passengers</div>
      <div class="detail-value">{{ $ticket->booking->passenger_count ?? 1 }} pax</div>
    </div>
  </div>

  {{-- Footer / actions --}}
  <div class="ticket-footer">
    <span class="ticket-footer-note">
      Issued on {{ $ticket->issued_at ? $ticket->issued_at->format('M d, Y') : '—' }}
    </span>
    @if($ticket->status === 'issued')
      <form method="POST" action="{{ route('tickets.cancel', $ticket) }}"
            onsubmit="return confirm('Cancel this ticket? This cannot be undone.')">
        @csrf
        <button type="submit" class="btn-cancel-ticket">Cancel Ticket</button>
      </form>
    @endif
  </div>

</div>
@endsection