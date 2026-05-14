@extends('layouts.user')
@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking')

@section('content')
<style>
    .breadcrumb{font-size:12px;color:#555;margin-bottom:20px}
    .breadcrumb a{color:#888;text-decoration:none}.breadcrumb a:hover{color:#FF6044}
    .breadcrumb span{color:#FF6044}
    .panel{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:10px;padding:20px;margin-bottom:14px}
    .p-head{display:flex;align-items:center;gap:12px;margin-bottom:18px;padding-bottom:14px;border-bottom:0.5px solid #2a2b2b}
    .p-icon{width:36px;height:36px;background:#ef9f27;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .p-icon svg{width:18px;height:18px}
    .p-title{font-size:14px;font-weight:600;color:#fff}
    .p-sub{font-size:11px;color:#555;margin-top:2px}
    .ref-tag{font-size:12px;color:#FF6044;font-family:monospace;background:rgba(255,96,68,.1);padding:4px 10px;border-radius:6px;display:inline-block;margin-bottom:14px}
    .f-group{margin-bottom:14px}
    .f-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .f-label{font-size:11px;color:#aaa;margin-bottom:6px;display:block;text-transform:uppercase;letter-spacing:0.5px}
    .req{color:#FF6044}
    .f-input{width:100%;background:#0e0f0f;border:0.5px solid #333;border-radius:8px;padding:10px 14px;font-size:13px;color:#fff;outline:none;font-family:sans-serif}
    .f-input:focus{border-color:#FF6044}
    .f-readonly{background:#0a0b0b;color:#555;cursor:not-allowed}
    .info-box{background:rgba(55,138,221,.08);border:0.5px solid rgba(55,138,221,.3);border-radius:8px;padding:12px 14px;font-size:12px;color:#378add;margin-bottom:14px}
    .s-box{background:#0e0f0f;border:0.5px solid #2a2b2b;border-radius:8px;padding:16px}
    .s-head{font-size:10px;color:#555;letter-spacing:1px;text-transform:uppercase;margin-bottom:12px}
    .s-row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:0.5px solid #1a1b1b;font-size:12px}
    .s-row:last-child{border-bottom:none}
    .s-k{color:#555}.s-v{color:#ccc;font-weight:500}
    .s-total{display:flex;justify-content:space-between;align-items:center;padding-top:12px;margin-top:6px;border-top:0.5px solid #2a2b2b}
    .s-tl{font-size:13px;color:#ccc;font-weight:500}
    .s-tv{font-size:24px;font-weight:700;color:#FF6044}
    .btn-row{display:flex;gap:10px;justify-content:flex-end;margin-top:20px}
    .btn-cancel{background:transparent;color:#888;border:0.5px solid #2a2b2b;border-radius:8px;padding:10px 20px;font-size:13px;cursor:pointer;text-decoration:none;display:inline-block}
    .btn-cancel:hover{border-color:#555;color:#ccc}
    .btn-save{background:#ef9f27;color:#fff;border:none;border-radius:8px;padding:11px 26px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:8px}
    .btn-save:hover{background:#d98e1c}
    .alert-error{background:rgba(224,85,85,0.1);border:0.5px solid rgba(224,85,85,0.4);border-radius:8px;padding:10px 14px;font-size:12px;color:#e05555;margin-bottom:14px}
    .grid2{display:grid;grid-template-columns:minmax(0,1.6fr) minmax(0,1fr);gap:16px}
</style>

<div class="breadcrumb">
    <a href="{{ route('bookings.index') }}">My Bookings</a> →
    <a href="{{ route('bookings.show', $booking->id) }}">{{ $booking->reference_no }}</a> →
    <span>Edit</span>
</div>

<div class="ref-tag">{{ $booking->reference_no }}</div>

<div class="info-box">
    ℹ You can only update the number of passengers and contact email. Trip schedule cannot be changed after booking.
</div>

@if($errors->isNotEmpty())
    <div class="alert-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('bookings.update', $booking->id) }}">
@csrf
@method('PUT')
<input type="hidden" name="status" value="{{ $booking->status }}" />
<div class="grid2">
    <div>
        <div class="panel">
            <div class="p-head">
                <div class="p-icon">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="#fff" stroke-width="1.8"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="#fff" stroke-width="1.8"/></svg>
                </div>
                <div>
                    <div class="p-title">Update Booking</div>
                    <div class="p-sub">Modify passenger count or contact email</div>
                </div>
            </div>

            <div class="f-group">
                <label class="f-label">Trip Schedule (cannot be changed)</label>
                <input type="text" class="f-input f-readonly" readonly
                    value="{{ $booking->schedule->trip->name }} · {{ $booking->schedule->departure_at->format('M d, Y h:i A') }}" />
            </div>

            <div class="f-row">
                <div class="f-group">
                    <label class="f-label">Number of Passengers <span class="req">*</span></label>
                   <input type="number" class="f-input" name="passenger_count" id="pax-input"
       value="{{ old('passenger_count', $booking->passenger_count) }}"
       min="1" max="150" oninput="updateTotal()" required />
                </div>
                <div class="f-group">
                    <label class="f-label">Contact Email <span class="req">*</span></label>
                    <input type="email" class="f-input" name="contact_email"
                           value="{{ old('contact_email', $booking->contact_email) }}" required />
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="panel">
            <div class="s-box">
                <div class="s-head">Updated Summary</div>
                <div class="s-row"><span class="s-k">Trip</span><span class="s-v">{{ $booking->schedule->trip->name }}</span></div>
                <div class="s-row"><span class="s-k">Route</span><span class="s-v">{{ $booking->schedule->trip->origin }} → {{ $booking->schedule->trip->destination }}</span></div>
                <div class="s-row"><span class="s-k">Departure</span><span class="s-v">{{ $booking->schedule->departure_at->format('M d, Y h:i A') }}</span></div>
                <div class="s-row"><span class="s-k">Fare Class</span><span class="s-v">{{ ucfirst($booking->schedule->fare_class) }}</span></div>
                <div class="s-row">
                    <span class="s-k">Available Seats</span>
                    <span class="s-v" style="color:{{ $booking->schedule->available_seats <= 5 ? '#e24b4a' : ($booking->schedule->available_seats <= 20 ? '#ef9f27' : '#4caf81') }}">
                        {{ $booking->schedule->available_seats }}
                        @if($booking->schedule->available_seats <= 5)
                            &nbsp;⚠ Almost full
                        @elseif($booking->schedule->available_seats <= 20)
                            &nbsp;· Limited
                        @endif
                    </span>
                </div>
                <div class="s-row"><span class="s-k">Base Fare / pax</span><span class="s-v">₱{{ number_format($booking->schedule->base_fare, 2) }}</span></div>
                <div class="s-row"><span class="s-k">Passengers</span><span class="s-v" id="disp-pax">{{ $booking->passenger_count }}</span></div>
                <div class="s-total">
                    <span class="s-tl">New Total</span>
                    <span class="s-tv" id="disp-total">₱{{ number_format($booking->schedule->base_fare * $booking->passenger_count, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="btn-row">
            <a href="{{ route('bookings.show', $booking->id) }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save">
                <svg viewBox="0 0 24 24" fill="none" width="15" height="15"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" stroke="#fff" stroke-width="2"/><polyline points="17 21 17 13 7 13 7 21" stroke="#fff" stroke-width="2"/><polyline points="7 3 7 8 15 8" stroke="#fff" stroke-width="2"/></svg>
                Save Changes
            </button>
        </div>
    </div>
</div>
</form>

<script>
var baseFare = {{ $booking->schedule->base_fare }};
function updateTotal() {
    var pax = parseInt(document.getElementById('pax-input').value) || 1;
    var total = baseFare * pax;
    document.getElementById('disp-pax').textContent = pax;
    document.getElementById('disp-total').textContent = '₱' + total.toLocaleString('en-PH',{minimumFractionDigits:2});
}
</script>
@endsection