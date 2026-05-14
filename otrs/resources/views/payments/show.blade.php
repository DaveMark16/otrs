@extends('layouts.user')
@section('page-title', 'Payment Details')

@section('content')
<style>
    .breadcrumb{font-size:12px;color:#555;margin-bottom:20px}
    .breadcrumb a{color:#888;text-decoration:none}.breadcrumb a:hover{color:#FF6044}
    .breadcrumb span{color:#FF6044}

    .grid2{display:grid;grid-template-columns:1.4fr 1fr;gap:16px}
    @media(max-width:768px){.grid2{grid-template-columns:1fr}}

    .panel{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:12px;padding:20px;margin-bottom:14px}
    .p-head{display:flex;align-items:center;gap:12px;margin-bottom:18px;padding-bottom:14px;border-bottom:0.5px solid #2a2b2b}
    .p-icon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .p-title{font-size:14px;font-weight:600;color:#fff}
    .p-sub{font-size:11px;color:#555;margin-top:2px}

    .detail-row{display:flex;justify-content:space-between;align-items:flex-start;padding:10px 0;border-bottom:0.5px solid #1e1f1f;font-size:13px}
    .detail-row:last-child{border-bottom:none}
    .d-key{color:#555;font-size:12px;min-width:130px;flex-shrink:0}
    .d-val{color:#ccc;font-weight:500;text-align:right}

    .mono{font-family:monospace;color:#FF6044;font-size:12px}
    .pill{display:inline-flex;align-items:center;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600}
    .pill-green{background:rgba(76,175,129,.15);color:#4caf81}
    .pill-amber{background:rgba(239,159,39,.15);color:#ef9f27}
    .pill-red{background:rgba(226,75,74,.15);color:#e24b4a}
    .pill-blue{background:rgba(55,138,221,.15);color:#378add}
    .pill-gray{background:rgba(136,135,128,.15);color:#888}

    .amount-big{font-size:32px;font-weight:700;color:#FF6044;font-family:monospace;letter-spacing:-1px}

    .status-banner{border-radius:10px;padding:14px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;font-size:13px;font-weight:500}
    .banner-paid{background:rgba(76,175,129,.08);border:0.5px solid rgba(76,175,129,.3);color:#4caf81}
    .banner-refunded{background:rgba(55,138,221,.08);border:0.5px solid rgba(55,138,221,.3);color:#378add}
    .banner-pending{background:rgba(239,159,39,.08);border:0.5px solid rgba(239,159,39,.3);color:#ef9f27}
    .banner-failed{background:rgba(226,75,74,.08);border:0.5px solid rgba(226,75,74,.3);color:#e24b4a}

    .refund-section{background:#0e0f0f;border:0.5px solid rgba(55,138,221,.25);border-radius:10px;padding:16px;margin-top:4px}
    .refund-title{font-size:11px;color:#378add;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;font-weight:600}

    .btn-back{display:inline-flex;align-items:center;gap:6px;background:transparent;border:0.5px solid #2a2b2b;border-radius:8px;padding:9px 18px;font-size:12px;color:#888;text-decoration:none}
    .btn-back:hover{background:#222;color:#ccc;border-color:#555}
    .btn-refund{display:inline-flex;align-items:center;gap:6px;background:rgba(226,75,74,.1);border:0.5px solid rgba(226,75,74,.4);border-radius:8px;padding:9px 18px;font-size:12px;color:#e24b4a;cursor:pointer;font-family:sans-serif}
    .btn-refund:hover{background:rgba(226,75,74,.2);border-color:#e24b4a}

    .ticket-row{display:flex;align-items:center;justify-content:space-between;padding:9px 0;border-bottom:0.5px solid #1e1f1f;font-size:12px}
    .ticket-row:last-child{border-bottom:none}
    .tkt-no{font-family:monospace;font-size:11px;color:#4caf81}
    .tkt-name{color:#ccc}
    .tkt-class{font-size:10px;padding:2px 8px;border-radius:20px;font-weight:600}
    .cls-eco{background:rgba(76,175,129,.12);color:#4caf81}
    .cls-biz{background:rgba(239,159,39,.12);color:#ef9f27}
    .cls-first{background:rgba(55,138,221,.12);color:#378add}
    .tkt-status{font-size:10px;padding:2px 8px;border-radius:20px}
    .ts-issued{background:rgba(76,175,129,.12);color:#4caf81}
    .ts-cancelled{background:rgba(226,75,74,.12);color:#e24b4a}
    .ts-used{background:rgba(136,135,128,.12);color:#888}

    .warn-box{background:rgba(255,196,68,.06);border:0.5px solid rgba(255,196,68,.25);border-radius:8px;padding:10px 12px;font-size:11px;color:#ffc444;margin-bottom:14px;line-height:1.6}
    .f-label{font-size:11px;color:#aaa;margin-bottom:6px;display:block;text-transform:uppercase;letter-spacing:.5px}
    .f-textarea{width:100%;background:#0e0f0f;border:0.5px solid #2a2b2b;border-radius:8px;padding:10px 14px;font-size:13px;color:#fff;outline:none;font-family:sans-serif;resize:vertical;min-height:80px}
    .f-textarea:focus{border-color:#e24b4a}

    /* Modal */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:9999;align-items:center;justify-content:center}
    .modal-overlay.open{display:flex}
    .modal{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:16px;padding:28px;width:100%;max-width:460px;position:relative}
    .modal-title{font-size:16px;font-weight:700;color:#fff;margin-bottom:4px}
    .modal-sub{font-size:12px;color:#555;margin-bottom:20px}
    .modal-close{position:absolute;top:16px;right:16px;background:transparent;border:none;color:#555;font-size:18px;cursor:pointer;line-height:1}
    .modal-close:hover{color:#fff}
    .modal-info{background:#111;border:0.5px solid #2a2b2b;border-radius:8px;padding:12px 14px;margin-bottom:16px}
    .modal-info-row{display:flex;justify-content:space-between;font-size:12px;padding:4px 0;border-bottom:0.5px solid #1a1b1b}
    .modal-info-row:last-child{border-bottom:none}
    .modal-info-k{color:#555}.modal-info-v{color:#ccc;font-weight:500}
    .modal-info-v.red{color:#FF6044;font-family:monospace;font-size:14px}
    .modal-footer{display:flex;gap:10px;justify-content:flex-end;margin-top:18px}
    .btn-cancel-modal{background:transparent;color:#888;border:0.5px solid #2a2b2b;border-radius:8px;padding:9px 20px;font-size:13px;cursor:pointer;font-family:sans-serif}
    .btn-cancel-modal:hover{border-color:#555;color:#ccc}
    .btn-confirm-refund{background:#e24b4a;color:#fff;border:none;border-radius:8px;padding:9px 22px;font-size:13px;font-weight:600;cursor:pointer;font-family:sans-serif}
    .btn-confirm-refund:hover{background:#c93a39}

    .alert{padding:10px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:8px}
    .alert-success{background:rgba(76,175,129,.1);border:0.5px solid rgba(76,175,129,.3);color:#4caf81}
    .alert-error{background:rgba(226,75,74,.1);border:0.5px solid rgba(226,75,74,.3);color:#e24b4a}
</style>

<div style="padding:2px 0 18px">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">✕ {{ session('error') }}</div>
    @endif

    <div class="breadcrumb">
        <a href="{{ route('payments.index') }}">Payments & Refunds</a> →
        <span>{{ $payment->transaction_ref ?? 'Payment Details' }}</span>
    </div>

    {{-- Status Banner --}}
    @php $s = $payment->status; @endphp
    <div class="status-banner {{ $s==='paid'?'banner-paid':($s==='refunded'?'banner-refunded':($s==='pending'?'banner-pending':'banner-failed')) }}">
        @if($s === 'paid')      ✓ Payment Successful
        @elseif($s === 'refunded') ↩ Refund Processed
        @elseif($s === 'pending')  ⏳ Payment Pending
        @else                      ✕ Payment Failed
        @endif
        <span style="margin-left:auto;font-size:11px;opacity:.7">{{ ucfirst($s) }}</span>
    </div>

    <div class="grid2">

        {{-- LEFT: Payment Details --}}
        <div>
            {{-- Transaction Info --}}
            <div class="panel">
                <div class="p-head">
                    <div class="p-icon" style="background:#1F4E79">💳</div>
                    <div>
                        <div class="p-title">Transaction Details</div>
                        <div class="p-sub">Payment record information</div>
                    </div>
                </div>

                <div class="detail-row">
                    <span class="d-key">Transaction Ref</span>
                    <span class="d-val mono">{{ $payment->transaction_ref ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="d-key">Booking Ref</span>
                    <span class="d-val mono">{{ $payment->booking->reference_no ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="d-key">Payment Method</span>
                    <span class="d-val" style="color:#ccc">{{ ucfirst($payment->method) }}</span>
                </div>
                <div class="detail-row">
                    <span class="d-key">Currency</span>
                    <span class="d-val">{{ strtoupper($payment->currency ?? 'PHP') }}</span>
                </div>
                <div class="detail-row">
                    <span class="d-key">Status</span>
                    <span class="d-val">
                        <span class="pill {{ $s==='paid'?'pill-green':($s==='pending'?'pill-amber':($s==='failed'?'pill-red':($s==='refunded'?'pill-blue':'pill-gray'))) }}">
                            {{ ucfirst($s) }}
                        </span>
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

            {{-- Trip Info --}}
            <div class="panel">
                <div class="p-head">
                    <div class="p-icon" style="background:#FF6044">✈</div>
                    <div>
                        <div class="p-title">Trip Information</div>
                        <div class="p-sub">Booking & schedule details</div>
                    </div>
                </div>

                <div class="detail-row">
                    <span class="d-key">Trip Name</span>
                    <span class="d-val" style="color:#ccc">{{ $payment->booking->schedule->trip->name ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="d-key">Route</span>
                    <span class="d-val" style="color:#ccc">
                        {{ $payment->booking->schedule->trip->origin ?? '?' }}
                        @if($payment->booking->schedule->trip->origin_country ?? null)
                            <span style="color:#FF6044;font-size:10px">, {{ $payment->booking->schedule->trip->origin_country }}</span>
                        @endif
                        →
                        {{ $payment->booking->schedule->trip->destination ?? '?' }}
                        @if($payment->booking->schedule->trip->destination_country ?? null)
                            <span style="color:#FF6044;font-size:10px">, {{ $payment->booking->schedule->trip->destination_country }}</span>
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
                    <span class="d-val" style="font-size:11px">{{ $payment->booking->contact_email ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="d-key">Booking Status</span>
                    <span class="d-val">
                        @php $bs = $payment->booking->status ?? 'unknown'; @endphp
                        <span class="pill {{ $bs==='confirmed'||$bs==='ticketed'?'pill-green':($bs==='pending'?'pill-amber':($bs==='cancelled'?'pill-red':'pill-gray')) }}">
                            {{ ucfirst($bs) }}
                        </span>
                    </span>
                </div>
            </div>

            {{-- Refund Info (if refunded) --}}
            @if($payment->status === 'refunded')
            <div class="panel">
                <div class="p-head">
                    <div class="p-icon" style="background:#378add">↩</div>
                    <div>
                        <div class="p-title">Refund Details</div>
                        <div class="p-sub">Refund transaction information</div>
                    </div>
                </div>
                <div class="detail-row">
                    <span class="d-key">Refund Ref</span>
                    <span class="d-val mono" style="color:#378add">{{ $payment->refund_ref ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="d-key">Refund Date</span>
                    <span class="d-val">{{ $payment->refund_date ? \Carbon\Carbon::parse($payment->refund_date)->format('M d, Y h:i A') : '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="d-key">Reason</span>
                    <span class="d-val" style="font-size:11px;max-width:240px;text-align:right">{{ $payment->refund_reason ?? '—' }}</span>
                </div>
            </div>
            @endif
        </div>

        {{-- RIGHT: Amount Summary + Tickets --}}
        <div>
            {{-- Amount Card --}}
            <div class="panel" style="text-align:center;padding:28px 20px">
                <div style="font-size:11px;color:#555;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px">Total Amount</div>
                <div class="amount-big">₱{{ number_format($payment->amount, 2) }}</div>
                <div style="margin-top:12px;font-size:11px;color:#555">
                    {{ $payment->booking->passenger_count ?? 1 }} pax
                    &nbsp;×&nbsp;
                    ₱{{ number_format($payment->booking->schedule->base_fare ?? 0, 2) }} base fare
                </div>
                <div style="margin-top:16px">
                    <span class="pill {{ $s==='paid'?'pill-green':($s==='refunded'?'pill-blue':($s==='pending'?'pill-amber':'pill-red')) }}" style="font-size:12px;padding:6px 16px">
                        {{ strtoupper($s) }}
                    </span>
                </div>
            </div>

            {{-- Issued Tickets --}}
            @if($payment->booking->tickets && $payment->booking->tickets->count() > 0)
            <div class="panel">
                <div class="p-head">
                    <div class="p-icon" style="background:#4caf81">🎫</div>
                    <div>
                        <div class="p-title">Issued Tickets</div>
                        <div class="p-sub">{{ $payment->booking->tickets->count() }} ticket(s) for this booking</div>
                    </div>
                </div>
                @foreach($payment->booking->tickets as $ticket)
                <div class="ticket-row">
                    <div>
                        <div class="tkt-no">{{ $ticket->ticket_no }}</div>
                        <div class="tkt-name" style="margin-top:2px">{{ $ticket->passenger_name }}</div>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <span class="tkt-class {{ $ticket->fare_class==='business'?'cls-biz':($ticket->fare_class==='first'?'cls-first':'cls-eco') }}">
                            {{ ucfirst($ticket->fare_class) }}
                        </span>
                        <span class="tkt-status {{ $ticket->status==='issued'?'ts-issued':($ticket->status==='cancelled'?'ts-cancelled':'ts-used') }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Action Buttons --}}
            <div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap">
                <a href="{{ route('payments.index') }}" class="btn-back">← Back to Payments</a>
                <a href="{{ route('bookings.show', $payment->booking->id) }}" class="btn-back" style="color:#378add;border-color:rgba(55,138,221,.3)">View Booking</a>
                @if($payment->status === 'paid')
                    <button type="button" class="btn-refund" onclick="openRefundModal()">↩ Request Refund</button>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Refund Modal --}}
@if($payment->status === 'paid')
<div class="modal-overlay" id="refund-modal">
    <div class="modal">
        <button class="modal-close" onclick="closeRefundModal()">✕</button>
        <div class="modal-title">↩ Request Refund</div>
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
                <span class="modal-info-v red">₱{{ number_format($payment->amount, 2) }}</span>
            </div>
        </div>

        <div class="warn-box">
            ⚠ <strong>This action cannot be undone.</strong> Your booking will be cancelled, all tickets voided, and seats released. The refund will be processed to your original payment method.
        </div>

        <form method="POST" action="{{ route('payments.refund', $payment->id) }}">
            @csrf
            <label class="f-label">Reason for refund <span style="color:#e24b4a">*</span></label>
            <textarea class="f-textarea" name="refund_reason"
                placeholder="e.g. Change of travel plans, schedule conflict, medical emergency…"
                required minlength="10" maxlength="500"></textarea>
            @error('refund_reason')
                <div style="color:#e24b4a;font-size:11px;margin-top:4px">{{ $message }}</div>
            @enderror
            <div class="modal-footer">
                <button type="button" class="btn-cancel-modal" onclick="closeRefundModal()">Cancel</button>
                <button type="submit" class="btn-confirm-refund">Confirm Refund</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRefundModal()  { document.getElementById('refund-modal').classList.add('open'); }
function closeRefundModal() { document.getElementById('refund-modal').classList.remove('open'); }
document.getElementById('refund-modal').addEventListener('click', function(e) {
    if (e.target === this) closeRefundModal();
});
</script>
@endif

@endsection