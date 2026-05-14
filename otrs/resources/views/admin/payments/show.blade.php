@extends('layouts.user')
@section('page-title', 'Payment Detail')

@section('content')
<style>
.back-btn{display:inline-flex;align-items:center;gap:6px;background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:8px;padding:7px 14px;font-size:12px;color:#FF6044;text-decoration:none;margin-bottom:20px;transition:.15s}
.back-btn:hover{background:#222;border-color:#FF6044}

.page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px}
.page-title{font-size:18px;font-weight:700;color:#fff}
.page-sub{font-size:11px;color:#555;margin-top:3px}

.grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.panel{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:12px;padding:20px;margin-bottom:16px}
.panel-title{font-size:13px;font-weight:600;color:#ccc;margin-bottom:16px;padding-bottom:10px;border-bottom:0.5px solid #2a2b2b;display:flex;align-items:center;gap:8px}

.info-row{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:0.5px solid #1e1f1f}
.info-row:last-child{border-bottom:none}
.info-k{font-size:11px;color:#555;text-transform:uppercase;letter-spacing:.4px}
.info-v{font-size:13px;color:#ccc;font-weight:500;text-align:right}
.info-v.mono{font-family:monospace;color:#FF6044;font-size:12px}
.info-v.amount{font-family:monospace;font-size:18px;font-weight:700;color:#FF6044}

/* Pills */
.pill{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
.pill-green{background:rgba(76,175,129,.15);color:#4caf81}
.pill-amber{background:rgba(239,159,39,.15);color:#ef9f27}
.pill-red{background:rgba(226,75,74,.15);color:#e24b4a}
.pill-blue{background:rgba(55,138,221,.15);color:#378add}
.pill-purple{background:rgba(167,139,250,.15);color:#a78bfa}
.pill-gray{background:rgba(136,135,128,.15);color:#888}

/* Refund banner */
.refund-banner{background:rgba(167,139,250,.06);border:0.5px solid rgba(167,139,250,.25);border-radius:12px;padding:20px;margin-bottom:16px}
.refund-banner-title{font-size:14px;font-weight:700;color:#a78bfa;margin-bottom:14px;display:flex;align-items:center;gap:8px}
.refund-ref{font-family:monospace;font-size:13px;color:#a78bfa;background:rgba(167,139,250,.1);border:0.5px solid rgba(167,139,250,.25);border-radius:6px;padding:4px 10px;display:inline-block;margin-bottom:4px}
.refund-reason-box{background:#111;border:0.5px solid #2a2b2b;border-radius:8px;padding:12px 14px;font-size:12px;color:#888;line-height:1.6;margin-top:10px;font-style:italic}

/* Booking status badge block */
.booking-status-block{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:10px;background:#111;border:0.5px solid #2a2b2b;margin-bottom:16px}

/* Alert */
.alert{padding:10px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:8px}
.alert-success{background:rgba(76,175,129,.1);border:0.5px solid rgba(76,175,129,.3);color:#4caf81}
.alert-error{background:rgba(226,75,74,.1);border:0.5px solid rgba(226,75,74,.3);color:#e24b4a}

@media(max-width:768px){
    .grid2{grid-template-columns:1fr}
}
</style>

<div style="padding:18px 20px">

@if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">✕ {{ session('error') }}</div>
@endif

<a href="{{ route('payments.index') }}" class="back-btn">← Back to Payments</a>

<div class="page-header">
    <div>
        <div class="page-title">Payment Detail</div>
        <div class="page-sub">Transaction reference: <span style="color:#FF6044;font-family:monospace">{{ $payment->transaction_ref ?? '—' }}</span></div>
    </div>
    @php $status = $payment->status; @endphp
    <span class="pill {{ $status==='paid'?'pill-green':($status==='refunded'?'pill-purple':($status==='pending'?'pill-amber':'pill-red')) }}" style="font-size:13px;padding:6px 14px">
        {{ ucfirst($status) }}
    </span>
</div>

{{-- ── REFUND BANNER (shown only when refunded) ── --}}
@if($payment->status === 'refunded')
<div class="refund-banner">
    <div class="refund-banner-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.86"/></svg>
        Refund Processed
    </div>
    <div class="grid2" style="gap:12px;margin-bottom:0">
        <div>
            <div class="info-k" style="margin-bottom:6px">Refund Reference</div>
            <div class="refund-ref">{{ $payment->refund_ref ?? '—' }}</div>
        </div>
        <div>
            <div class="info-k" style="margin-bottom:6px">Refund Date</div>
            <div style="font-size:13px;color:#ccc">
                {{ $payment->refund_date ? $payment->refund_date->format('M d, Y · H:i') : '—' }}
            </div>
        </div>
        <div>
            <div class="info-k" style="margin-bottom:6px">Amount Refunded</div>
            <div style="font-family:monospace;font-size:18px;font-weight:700;color:#a78bfa">
                ₱{{ number_format($payment->amount, 2) }}
            </div>
        </div>
        <div>
            <div class="info-k" style="margin-bottom:6px">Booking Status</div>
            <span class="pill pill-red">Cancelled</span>
        </div>
    </div>
    @if($payment->refund_reason ?? null)
    <div class="info-k" style="margin-top:14px;margin-bottom:6px">Reason for Refund</div>
    <div class="refund-reason-box">"{{ $payment->refund_reason }}"</div>
    @endif
</div>
@endif

<div class="grid2">
    {{-- Payment Info --}}
    <div class="panel">
        <div class="panel-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
            Payment Information
        </div>
        <div class="info-row">
            <span class="info-k">Amount</span>
            <span class="info-v amount">₱{{ number_format($payment->amount, 2) }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Status</span>
            <span class="pill {{ $payment->status==='paid'?'pill-green':($payment->status==='refunded'?'pill-purple':($payment->status==='pending'?'pill-amber':'pill-red')) }}">
                {{ ucfirst($payment->status) }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-k">Method</span>
            <span class="info-v">{{ ucfirst($payment->method ?? '—') }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Transaction Ref</span>
            <span class="info-v mono">{{ $payment->transaction_ref ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Currency</span>
            <span class="info-v">{{ strtoupper($payment->currency ?? 'PHP') }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Attempts</span>
            <span class="info-v">{{ $payment->attempts ?? 1 }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Paid At</span>
            <span class="info-v">{{ $payment->paid_at ? $payment->paid_at->format('M d, Y · H:i') : '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Created</span>
            <span class="info-v">{{ $payment->created_at->format('M d, Y · H:i') }}</span>
        </div>
    </div>

    {{-- Booking Info --}}
    <div class="panel">
        <div class="panel-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
            Booking Information
        </div>
        @php $booking = $payment->booking; @endphp
        <div class="info-row">
            <span class="info-k">Reference No.</span>
            <span class="info-v mono">{{ $booking->reference_no ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Booking Status</span>
            @php $bs = $booking->status ?? 'unknown'; @endphp
            <span class="pill {{ $bs==='confirmed'?'pill-green':($bs==='pending'?'pill-amber':($bs==='cancelled'?'pill-red':'pill-gray')) }}">
                {{ ucfirst($bs) }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-k">Passengers</span>
            <span class="info-v">{{ $booking->passenger_count ?? 1 }} pax</span>
        </div>
        <div class="info-row">
            <span class="info-k">Contact Email</span>
            <span class="info-v" style="font-size:12px">{{ $booking->contact_email ?? auth()->user()->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Total Amount</span>
            <span class="info-v mono">₱{{ number_format($booking->total_amount, 2) }}</span>
        </div>
        <div class="info-row">
            <span class="info-k">Booked On</span>
            <span class="info-v">{{ $booking->created_at->format('M d, Y') }}</span>
        </div>
    </div>
</div>

{{-- Trip / Schedule Info --}}
@if($booking->schedule ?? null)
@php $schedule = $booking->schedule; $trip = $schedule->trip ?? null; @endphp
<div class="panel">
    <div class="panel-title">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
        Flight / Trip Details
    </div>
    <div class="grid2">
        <div>
            <div class="info-row">
                <span class="info-k">Trip Name</span>
                <span class="info-v">{{ $trip->name ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-k">Route</span>
                <span class="info-v">{{ $trip->origin ?? '?' }} → {{ $trip->destination ?? '?' }}</span>
            </div>
            <div class="info-row">
                <span class="info-k">Operator</span>
                <span class="info-v">{{ $trip->operator ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-k">Fare Class</span>
                @php $fc = $schedule->fare_class ?? 'economy'; @endphp
                <span class="pill {{ $fc==='first'?'pill-amber':($fc==='business'?'pill-blue':'pill-gray') }}">
                    {{ ucfirst($fc) }}
                </span>
            </div>
        </div>
        <div>
            <div class="info-row">
                <span class="info-k">Departure</span>
                <span class="info-v">{{ $schedule->departure_at ? $schedule->departure_at->format('M d, Y · H:i') : '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-k">Arrival</span>
                <span class="info-v">{{ $schedule->arrival_at ? $schedule->arrival_at->format('M d, Y · H:i') : '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-k">Base Fare</span>
                <span class="info-v mono">₱{{ number_format($schedule->base_fare, 2) }}</span>
            </div>
            <div class="info-row">
                <span class="info-k">Schedule Status</span>
                @php $ss = $schedule->status ?? 'scheduled'; @endphp
                <span class="pill {{ $ss==='scheduled'?'pill-green':($ss==='completed'?'pill-blue':'pill-red') }}">
                    {{ ucfirst($ss) }}
                </span>
            </div>
        </div>
    </div>
</div>
@endif

{{-- View Booking button --}}
<div style="display:flex;justify-content:flex-end;gap:10px;margin-top:4px">
    @if($booking ?? null)
    <a href="{{ route('bookings.show', $booking) }}"
       style="display:inline-flex;align-items:center;gap:6px;background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:8px;padding:9px 18px;font-size:13px;color:#ccc;text-decoration:none;transition:.15s"
       onmouseover="this.style.borderColor='#FF6044';this.style.color='#FF6044'"
       onmouseout="this.style.borderColor='#2a2b2b';this.style.color='#ccc'">
        View Full Booking →
    </a>
    @endif
</div>

</div>
@endsection
