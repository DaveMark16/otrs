@extends('layouts.app')
@section('page-title', 'Payment Receipt')

@section('content')
<style>
:root{--sand:#f5ede0;--cream:#faf6f0;--brown:#3b2a1a;--tan:#c49a6c;--gold:#d4a254;--teal:#2d6e6e;--teal-lt:#3d8f8f;--white:#ffffff;--radius:18px;--ff-head:'Playfair Display',Georgia,serif;--ff-body:'DM Sans',sans-serif;}

/* Action bar */
.action-bar{display:flex;gap:10px;margin-bottom:28px;flex-wrap:wrap;}
.btn-back{display:inline-flex;align-items:center;gap:6px;background:var(--white);border:1.5px solid rgba(59,42,26,.12);border-radius:50px;padding:9px 18px;font-size:.82rem;font-weight:600;color:rgba(59,42,26,.5);text-decoration:none;transition:all .15s;font-family:var(--ff-body);}
.btn-back:hover{color:var(--brown);border-color:rgba(59,42,26,.3);}
.btn-back svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;}
.btn-print{display:inline-flex;align-items:center;gap:6px;background:var(--teal);border:none;border-radius:50px;padding:9px 20px;font-size:.82rem;font-weight:600;color:var(--white);cursor:pointer;transition:background .18s;font-family:var(--ff-body);box-shadow:0 4px 14px rgba(45,110,110,.25);}
.btn-print:hover{background:var(--teal-lt);}
.btn-print svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;}

/* Receipt wrap */
.receipt-wrap{background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;margin-bottom:24px;max-width:720px;box-shadow:0 4px 24px rgba(59,42,26,.08);}

/* Receipt header */
.receipt-header{background:linear-gradient(135deg,var(--teal),var(--teal-lt));padding:28px 32px;text-align:center;}
.receipt-brand{font-size:.72rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.7);margin-bottom:8px;}
.receipt-title{font-family:var(--ff-head);font-size:1.8rem;font-weight:900;color:var(--white);margin:0;}
.receipt-sub{font-size:.78rem;color:rgba(255,255,255,.55);margin-top:4px;}

/* Receipt body */
.receipt-body{padding:28px 32px;}

/* Section header */
.sec-head{display:flex;align-items:center;gap:8px;font-size:.68rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(59,42,26,.38);border-bottom:1.5px solid rgba(59,42,26,.07);padding-bottom:10px;margin-bottom:14px;margin-top:22px;}
.sec-head:first-child{margin-top:0;}
.sec-head svg{width:12px;height:12px;stroke:var(--teal);fill:none;stroke-width:2;}

/* Ref boxes */
.ref-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:22px;}
.ref-box{background:var(--sand);border:1.5px solid rgba(59,42,26,.09);border-radius:12px;padding:14px;}
.ref-label{font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.35);margin-bottom:6px;}
.ref-val{font-family:monospace;font-size:.95rem;font-weight:800;color:var(--teal);}

/* Fields */
.field{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid rgba(59,42,26,.06);font-size:.83rem;}
.field:last-child{border-bottom:none;}
.field-label{color:rgba(59,42,26,.38);font-size:.75rem;font-weight:500;}
.field-value{color:rgba(59,42,26,.7);font-weight:600;text-align:right;}
.field-value.gold{color:var(--gold);font-family:monospace;font-weight:800;font-size:.95rem;}
.field-value.teal{color:var(--teal);font-weight:700;}
.field-value.strike{text-decoration:line-through;color:rgba(59,42,26,.3);}

/* Total row */
.total-row{display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-top:2px solid rgba(59,42,26,.1);margin-top:6px;}
.total-label{font-size:.95rem;font-weight:700;color:var(--brown);}
.total-val{font-family:var(--ff-head);font-size:1.6rem;font-weight:900;color:var(--teal);}

/* Receipt footer */
.receipt-footer{border-top:1.5px dashed rgba(59,42,26,.1);padding:16px 32px;text-align:center;font-size:.75rem;color:rgba(59,42,26,.35);display:flex;align-items:center;justify-content:center;gap:8px;}
.receipt-footer svg{width:13px;height:13px;stroke:var(--teal);fill:none;stroke-width:2;flex-shrink:0;}

/* ═══ TICKET ═══ */
.tickets-label{display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:18px;}
.tickets-badge{background:var(--white);border:1.5px solid rgba(59,42,26,.1);border-radius:50px;padding:6px 18px;font-size:.78rem;font-weight:600;color:rgba(59,42,26,.5);}

.ticket-card{background:var(--white);border:1.5px solid rgba(59,42,26,.1);border-radius:var(--radius);overflow:hidden;margin-bottom:18px;max-width:720px;box-shadow:0 4px 20px rgba(59,42,26,.08);}
.ticket-header-band{background:linear-gradient(135deg,var(--brown),#5a3f28);padding:16px 22px;display:flex;justify-content:space-between;align-items:center;}
.ticket-no{font-family:monospace;font-size:1.1rem;font-weight:800;color:var(--white);letter-spacing:2px;}
.ticket-issued{font-size:.7rem;color:rgba(255,255,255,.45);margin-top:3px;}
.ticket-status-badge{background:rgba(255,255,255,.15);color:var(--white);font-size:.7rem;font-weight:700;padding:4px 12px;border-radius:20px;letter-spacing:.08em;}

.ticket-body{padding:20px 22px;}
.ticket-route-row{display:flex;align-items:center;gap:14px;padding:16px 0;border-bottom:1.5px solid rgba(59,42,26,.07);margin-bottom:16px;}
.tc-city{text-align:center;}
.tc-code{font-size:2rem;font-weight:900;color:var(--brown);font-family:monospace;letter-spacing:3px;line-height:1;}
.tc-name{font-size:.72rem;color:rgba(59,42,26,.4);margin-top:2px;}
.tc-time{font-size:.95rem;font-weight:700;color:var(--teal);margin-top:5px;}
.tc-date{font-size:.68rem;color:rgba(59,42,26,.35);}
.tc-divider{flex:1;text-align:center;}
.tc-dur{font-size:.72rem;color:rgba(59,42,26,.35);margin-bottom:6px;}
.tc-line{height:2px;background:linear-gradient(90deg,var(--teal),rgba(196,154,108,.5),var(--gold));border-radius:2px;position:relative;}
.tc-plane{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:16px;line-height:1;}
.tc-direct{font-size:.68rem;color:rgba(59,42,26,.35);margin-top:6px;}

.ticket-fields{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.tf-label{font-size:.65rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(59,42,26,.35);}
.tf-val{font-size:.83rem;font-weight:600;color:var(--brown);margin-top:3px;}
.tf-val.teal{color:var(--teal);}

/* Barcode strip */
.ticket-barcode{margin-top:16px;padding-top:16px;border-top:1.5px dashed rgba(59,42,26,.1);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.barcode-lines{display:flex;gap:2px;align-items:flex-end;}
.barcode-lines span{display:inline-block;background:var(--brown);border-radius:1px;opacity:.7;}
.tkt-num{font-size:.72rem;color:rgba(59,42,26,.35);margin-top:5px;font-family:monospace;}
.tkt-status{color:var(--teal);font-weight:700;font-size:.84rem;}

/* Print */
@media print{
  *{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  .no-print{display:none!important;}
  body,html{background:#fff!important;}
  .receipt-header{background:var(--teal)!important;}
  .ticket-header-band{background:var(--brown)!important;}
  .print-break{page-break-before:always;}
}
@media(max-width:600px){
  .ref-grid{grid-template-columns:1fr;}
  .ticket-fields{grid-template-columns:1fr;}
  .receipt-body{padding:20px 18px;}
  .receipt-header{padding:20px 18px;}
}
</style>

@php
  $schedule   = $booking->schedule;
  $trip       = $schedule->trip;
  $dep        = $schedule->departure_at;
  $arr        = $schedule->arrival_at;
  $mins       = $arr ? $dep->diffInMinutes($arr) : 0;
  $hours      = floor($mins/60);
  $remMins    = $mins%60;
  $durStr     = $hours>0 ? "{$hours}h {$remMins}m" : "{$remMins}m";
  $originCode = strtoupper(substr(preg_replace('/[^a-zA-Z]/','', $trip->origin ?? 'ORG'), 0, 3));
  $destCode   = strtoupper(substr(preg_replace('/[^a-zA-Z]/','', $trip->destination ?? 'DST'), 0, 3));
@endphp

<div class="no-print action-bar">
  <a href="{{ route('bookings.show', $booking) }}" class="btn-back">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Booking
  </a>
  <button onclick="window.print()" class="btn-print">
    <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
    Print Receipt & Tickets
  </button>
</div>

{{-- ══ RECEIPT ══ --}}
<div class="receipt-wrap">
  <div class="receipt-header">
    <div class="receipt-brand">OTRS — Online Travel & Reservation System</div>
    <div class="receipt-title">Payment Receipt</div>
    <div class="receipt-sub">Official Transaction Record</div>
  </div>

  <div class="receipt-body">
    {{-- References --}}
    <div class="sec-head">
      <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
      References
    </div>
    <div class="ref-grid">
      <div class="ref-box">
        <div class="ref-label">Transaction Ref</div>
        <div class="ref-val">{{ $booking->payment->transaction_ref ?? 'N/A' }}</div>
      </div>
      <div class="ref-box">
        <div class="ref-label">Booking Ref</div>
        <div class="ref-val">{{ $booking->reference_no }}</div>
      </div>
    </div>

    {{-- Passenger & Trip --}}
    <div class="sec-head">
      <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Passenger & Trip
    </div>
    <div class="field"><span class="field-label">Passenger</span><span class="field-value">{{ $booking->user->name }}</span></div>
    <div class="field"><span class="field-label">Email</span><span class="field-value">{{ $booking->user->email }}</span></div>
    <div class="field"><span class="field-label">Route</span><span class="field-value">{{ $trip->origin_country ?? $trip->origin }} → {{ $trip->destination_country ?? $trip->destination }}</span></div>
    <div class="field"><span class="field-label">Operator</span><span class="field-value">{{ $trip->operator ?? '—' }}</span></div>
    <div class="field"><span class="field-label">Departure</span><span class="field-value">{{ $dep->format('M d, Y · h:i A') }}</span></div>
    @if($arr)<div class="field"><span class="field-label">Arrival</span><span class="field-value">{{ $arr->format('M d, Y · h:i A') }}</span></div>@endif
    <div class="field"><span class="field-label">Duration</span><span class="field-value">{{ $durStr }}</span></div>
    <div class="field"><span class="field-label">Fare Class</span><span class="field-value">{{ ucfirst($schedule->fare_class ?? 'Economy') }}</span></div>

    {{-- Payment --}}
    <div class="sec-head">
      <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      Payment Details
    </div>
    <div class="field"><span class="field-label">Method</span><span class="field-value">{{ ucfirst($booking->payment->method ?? '—') }}</span></div>
    <div class="field"><span class="field-label">Status</span><span class="field-value teal">✓ Paid</span></div>
    <div class="field"><span class="field-label">Paid On</span><span class="field-value">{{ $booking->payment->paid_at ? $booking->payment->paid_at->format('M d, Y h:i A') : '—' }}</span></div>
    <div class="field"><span class="field-label">Passengers</span><span class="field-value">{{ $booking->passenger_count }} pax</span></div>
    @if($booking->has_promo ?? false)
      <div class="field"><span class="field-label">Original Amount</span><span class="field-value strike">₱{{ number_format($booking->original_amount ?? 0, 2) }}</span></div>
      <div class="field"><span class="field-label">Promo ({{ $booking->promo->promo_code ?? '' }})</span><span class="field-value teal">−₱{{ number_format($booking->discount_amount ?? 0, 2) }}</span></div>
    @endif

    <div class="total-row">
      <span class="total-label">Total Paid</span>
      <span class="total-val">₱{{ number_format($booking->total_amount, 2) }}</span>
    </div>
  </div>

  <div class="receipt-footer">
    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
    Computer-generated receipt — no signature required.
  </div>
</div>

{{-- ══ TICKETS ══ --}}
@if($booking->tickets->count() > 0)
<div class="print-break">
  <div class="no-print tickets-label">
    <span class="tickets-badge">✈ {{ $booking->tickets->count() }} Ticket(s)</span>
  </div>

  @foreach($booking->tickets as $ticket)
  <div class="ticket-card">
    <div class="ticket-header-band">
      <div>
        <div style="font-size:.65rem;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.12em;margin-bottom:5px;">Boarding Pass</div>
        <div class="ticket-no">{{ $ticket->ticket_no }}</div>
        <div class="ticket-issued">{{ $ticket->issued_at ? $ticket->issued_at->format('M d, Y h:i A') : now()->format('M d, Y h:i A') }}</div>
      </div>
      <span class="ticket-status-badge">{{ strtoupper($ticket->status ?? 'ISSUED') }}</span>
    </div>

    <div class="ticket-body">
      <div class="ticket-route-row">
        <div class="tc-city">
          <div class="tc-code">{{ $originCode }}</div>
          <div class="tc-name">{{ $trip->origin }}</div>
          <div class="tc-time">{{ $dep->format('h:i A') }}</div>
          <div class="tc-date">{{ $dep->format('M d, Y') }}</div>
        </div>
        <div class="tc-divider">
          <div class="tc-dur">{{ $durStr }}</div>
          <div class="tc-line"><span class="tc-plane">✈</span></div>
          <div class="tc-direct">Direct Flight</div>
        </div>
        <div class="tc-city" style="text-align:right;">
          <div class="tc-code">{{ $destCode }}</div>
          <div class="tc-name">{{ $trip->destination }}</div>
          <div class="tc-time" style="color:var(--gold);">{{ $arr ? $arr->format('h:i A') : '—' }}</div>
          <div class="tc-date">{{ $arr ? $arr->format('M d, Y') : '—' }}</div>
        </div>
      </div>

      <div class="ticket-fields">
        <div><div class="tf-label">Passenger Name</div><div class="tf-val">{{ $ticket->passenger_name }}</div></div>
        <div><div class="tf-label">Booking Ref</div><div class="tf-val teal">{{ $booking->reference_no }}</div></div>
        <div><div class="tf-label">Fare Class</div><div class="tf-val">{{ ucfirst($ticket->fare_class ?? 'Economy') }}</div></div>
        <div><div class="tf-label">Seat</div><div class="tf-val">{{ $ticket->seat_no ?? 'Open Seating' }}</div></div>
        <div><div class="tf-label">Operator</div><div class="tf-val">{{ $trip->operator ?? '—' }}</div></div>
        <div><div class="tf-label">Contact Email</div><div class="tf-val" style="font-size:.74rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $booking->contact_email }}</div></div>
      </div>

      <div class="ticket-barcode">
        <div>
          <div style="font-size:.65rem;color:rgba(59,42,26,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Scan at Gate</div>
          <div class="barcode-lines">
            @php $seed=crc32($ticket->ticket_no);$heights=[18,30,22,35,14,28,20,32,18,25,30,16,35,22,28,12,30,20,35,24]; @endphp
            @foreach($heights as $i=>$h)
              <span style="height:{{$h}}px;width:{{(($seed>>$i)&1)?3:2}}px;"></span>
            @endforeach
          </div>
          <div class="tkt-num">{{ $ticket->ticket_no }}</div>
        </div>
        <div style="text-align:right;">
          <div style="font-size:.65rem;color:rgba(59,42,26,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px;">Status</div>
          <div class="tkt-status">✓ {{ ucfirst($ticket->status ?? 'Issued') }}</div>
          <div style="font-size:.68rem;color:rgba(59,42,26,.35);margin-top:5px;">{{ $ticket->issued_at ? $ticket->issued_at->format('M d, Y') : now()->format('M d, Y') }}</div>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <div class="no-print" style="text-align:center;font-size:.75rem;color:rgba(59,42,26,.3);margin-top:8px;">
    Please present this ticket at the gate. Keep your booking reference handy.
  </div>
</div>
@else
<div style="background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:32px;text-align:center;color:rgba(59,42,26,.3);max-width:720px;">
  <div style="font-size:28px;opacity:.2;margin-bottom:10px;">🎫</div>
  No tickets found for this booking.
</div>
@endif

@endsection