@extends('admin.layouts.app')
@section('page-title', 'Create Booking')

@section('content')
<style>
  .back-link { display:inline-flex;align-items:center;gap:6px;color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;font-weight:500;transition:color .15s;margin-bottom:20px; }
  .back-link:hover { color:var(--teal); }
  .back-link svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }

  .page-grid { display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start; }

  /* Panel */
  .panel { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 12px rgba(59,42,26,.05);margin-bottom:16px; }
  .panel-head { padding:20px 22px;border-bottom:1.5px solid rgba(59,42,26,.07);display:flex;align-items:center;gap:10px; }
  .panel-head-icon { width:36px;height:36px;background:rgba(45,110,110,.1);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
  .panel-head-icon svg { width:17px;height:17px;stroke:var(--teal);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round; }
  .panel-title { font-family:var(--ff-head);font-size:1rem;font-weight:700;color:var(--brown); }
  .panel-sub { font-size:.75rem;color:rgba(59,42,26,.4);margin-top:2px; }
  .panel-body { padding:20px 22px; }

  /* Flight summary card */
  .flight-card { background:linear-gradient(135deg,var(--teal) 0%,#3d8f8f 100%);border-radius:var(--radius);padding:22px 24px;color:var(--white);margin-bottom:16px;position:relative;overflow:hidden; }
  .flight-card::before { content:'✈';position:absolute;right:20px;top:50%;transform:translateY(-50%);font-size:5rem;opacity:.08;line-height:1; }
  .fc-route { font-family:var(--ff-head);font-size:1.3rem;font-weight:900;margin-bottom:8px; }
  .fc-meta { display:flex;flex-wrap:wrap;gap:14px;font-size:.78rem;opacity:.85; }
  .fc-meta-item { display:flex;align-items:center;gap:5px; }
  .fc-meta-item svg { width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }
  .fc-price { margin-top:14px;display:flex;align-items:baseline;gap:6px; }
  .fc-price-val { font-family:var(--ff-head);font-size:1.6rem;font-weight:900; }
  .fc-price-label { font-size:.75rem;opacity:.7; }
  .fc-seats { display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,.18);border-radius:20px;padding:3px 10px;font-size:.72rem;font-weight:700;margin-top:10px; }

  /* Form fields */
  .f-group { margin-bottom:16px; }
  .f-label { font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:7px;display:block; }
  .f-label .req { color:#b44444;margin-left:2px; }
  .f-input, .f-select { width:100%;background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:var(--radius-sm);padding:10px 14px;font-size:.88rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s; }
  .f-input:focus,.f-select:focus { border-color:var(--teal);background:var(--white); }
  .f-hint { font-size:.72rem;color:rgba(59,42,26,.35);margin-top:5px; }
  .f-error { font-size:.72rem;color:#b44444;margin-top:4px; }
  .f-error-banner { background:rgba(180,68,68,.06);border:1.5px solid rgba(180,68,68,.2);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;font-size:.84rem;color:#b44444; }

  /* Passenger counter */
  .pax-row { display:flex;align-items:center;gap:14px;margin-top:4px; }
  .pax-btn { width:36px;height:36px;border-radius:50%;border:1.5px solid rgba(59,42,26,.15);background:var(--cream);color:var(--brown);font-size:1.1rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;flex-shrink:0; }
  .pax-btn:hover { background:var(--sand);border-color:var(--tan); }
  .pax-display { font-family:var(--ff-head);font-size:1.6rem;font-weight:900;color:var(--brown);min-width:36px;text-align:center; }
  .pax-input { display:none; }

  /* Summary sidebar */
  .summary-sticky { position:sticky;top:84px; }
  .summary-row { display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid rgba(59,42,26,.06);font-size:.83rem; }
  .summary-row:last-child { border-bottom:none; }
  .summary-label { color:rgba(59,42,26,.5); }
  .summary-value { font-weight:600;color:var(--brown); }
  .summary-total { border-top:2px solid rgba(59,42,26,.1);margin-top:10px;padding-top:12px; }
  .summary-total .summary-label { font-weight:700;color:var(--brown);font-size:.9rem; }
  .summary-total .summary-value { font-family:var(--ff-head);font-size:1.2rem;font-weight:900;color:var(--teal); }

  .info-box { background:rgba(212,162,84,.07);border:1px solid rgba(212,162,84,.25);border-radius:var(--radius-sm);padding:12px 14px;font-size:.78rem;color:rgba(59,42,26,.6);display:flex;align-items:flex-start;gap:8px;margin-top:14px; }
  .info-box svg { width:13px;height:13px;stroke:var(--gold);fill:none;stroke-width:2;stroke-linecap:round;flex-shrink:0;margin-top:1px; }

  .btn-confirm { width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:var(--white);border:none;border-radius:50px;padding:13px;font-size:.92rem;font-weight:700;cursor:pointer;font-family:var(--ff-body);transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:16px;box-shadow:0 4px 16px rgba(45,110,110,.28); }
  .btn-confirm:hover { transform:translateY(-2px);box-shadow:0 8px 24px rgba(45,110,110,.32); }
  .btn-confirm svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.2;stroke-linecap:round; }

  @media(max-width:900px) { .page-grid { grid-template-columns:1fr; } .summary-sticky { position:static; } }
</style>

<a href="{{ route('admin.book-trip') }}" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Back to Trips
</a>

@if($errors->isNotEmpty())
  <div class="f-error-banner">Please fix the following errors: {{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.book-trip.store', $schedule) }}" id="bookForm">
@csrf

<div class="page-grid">

  {{-- LEFT: Flight info + form --}}
  <div>
    {{-- Flight summary card --}}
    <div class="flight-card">
      <div class="fc-route">
        {{ $schedule->trip->origin_country }} → {{ $schedule->trip->destination_country }}
      </div>
      <div class="fc-meta">
        <div class="fc-meta-item">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          {{ $schedule->departure_at->format('M d, Y · h:i A') }}
        </div>
        <div class="fc-meta-item">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Arrives {{ $schedule->arrival_at->format('M d, Y · h:i A') }}
        </div>
        @if($schedule->trip->operator)
        <div class="fc-meta-item">
          <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
          {{ $schedule->trip->operator }}
        </div>
        @endif
        <div class="fc-meta-item">
          <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
          {{ ucfirst($schedule->fare_class) }} Class
        </div>
      </div>
      <div class="fc-price">
        <span class="fc-price-val">₱{{ number_format($schedule->base_fare, 0) }}</span>
        <span class="fc-price-label">per person</span>
      </div>
      <div class="fc-seats">
        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        {{ $schedule->available_seats }} seats available
      </div>
    </div>

    {{-- Select user --}}
    <div class="panel">
      <div class="panel-head">
        <div class="panel-head-icon">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div>
          <div class="panel-title">Select User</div>
          <div class="panel-sub">Who is this booking for?</div>
        </div>
      </div>
      <div class="panel-body">
        <div class="f-group">
          <label class="f-label">User <span class="req">*</span></label>
          <select name="user_id" class="f-select" required onchange="updateUserEmail(this)">
            <option value="">— Select a user —</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}"
                      data-email="{{ $user->email }}"
                      {{ old('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name }} — {{ $user->email }}
              </option>
            @endforeach
          </select>
          @error('user_id')<div class="f-error">{{ $message }}</div>@enderror
        </div>

        <div class="f-group">
          <label class="f-label">Contact Email <span class="req">*</span></label>
          <input type="email" name="contact_email" id="contactEmail" class="f-input"
                 placeholder="Will auto-fill when user is selected"
                 value="{{ old('contact_email') }}" required>
          @error('contact_email')<div class="f-error">{{ $message }}</div>@enderror
        </div>
      </div>
    </div>

    {{-- Passenger count --}}
    <div class="panel">
      <div class="panel-head">
        <div class="panel-head-icon">
          <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
          <div class="panel-title">Passengers</div>
          <div class="panel-sub">Max {{ $schedule->available_seats }} available</div>
        </div>
      </div>
      <div class="panel-body">
        <div class="pax-row">
          <button type="button" class="pax-btn" onclick="changePax(-1)">−</button>
          <div class="pax-display" id="paxDisplay">1</div>
          <button type="button" class="pax-btn" onclick="changePax(1)">+</button>
          <span style="font-size:.82rem;color:rgba(59,42,26,.45);">passenger(s)</span>
        </div>
        <input type="hidden" name="passenger_count" id="paxInput" value="{{ old('passenger_count', 1) }}">
        <div class="f-hint" style="margin-top:10px;">Total: ₱<span id="totalDisplay">{{ number_format($schedule->base_fare, 0) }}</span></div>
        @error('passenger_count')<div class="f-error">{{ $message }}</div>@enderror
      </div>
    </div>
  </div>

  {{-- RIGHT: Summary sidebar --}}
  <div class="summary-sticky">
    <div class="panel">
      <div class="panel-head">
        <div class="panel-head-icon">
          <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div>
          <div class="panel-title">Booking Summary</div>
        </div>
      </div>
      <div class="panel-body">
        <div class="summary-row">
          <span class="summary-label">Route</span>
          <span class="summary-value" style="text-align:right;font-size:.8rem;">
            {{ $schedule->trip->origin_country }}<br>→ {{ $schedule->trip->destination_country }}
          </span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Departure</span>
          <span class="summary-value" style="font-size:.8rem;">{{ $schedule->departure_at->format('M d, Y') }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Class</span>
          <span class="summary-value">{{ ucfirst($schedule->fare_class) }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Fare / person</span>
          <span class="summary-value">₱{{ number_format($schedule->base_fare, 2) }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Passengers</span>
          <span class="summary-value" id="summaryPax">1</span>
        </div>
        <div class="summary-row summary-total">
          <span class="summary-label">Total Amount</span>
          <span class="summary-value">₱<span id="summaryTotal">{{ number_format($schedule->base_fare, 2) }}</span></span>
        </div>

        <div class="info-box">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Admin-created bookings are automatically set to <strong>Confirmed</strong>. The user will be able to pay immediately.
        </div>

        <button type="submit" class="btn-confirm">
          <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          Confirm Booking
        </button>

        <a href="{{ route('admin.book-trip') }}" style="display:block;text-align:center;margin-top:12px;font-size:.82rem;color:rgba(59,42,26,.4);text-decoration:none;transition:color .15s;" onmouseover="this.style.color='var(--teal)'" onmouseout="this.style.color='rgba(59,42,26,.4)'">
          Cancel
        </a>
      </div>
    </div>
  </div>

</div>
</form>

<script>
  const baseFare  = {{ $schedule->base_fare }};
  const maxSeats  = {{ $schedule->available_seats }};
  let   pax       = parseInt('{{ old('passenger_count', 1) }}') || 1;

  function changePax(delta) {
    pax = Math.max(1, Math.min(maxSeats, pax + delta));
    document.getElementById('paxDisplay').textContent = pax;
    document.getElementById('paxInput').value = pax;
    document.getElementById('summaryPax').textContent = pax;
    const total = (baseFare * pax).toLocaleString('en-PH', {minimumFractionDigits:2});
    document.getElementById('totalDisplay').textContent = (baseFare * pax).toLocaleString();
    document.getElementById('summaryTotal').textContent = total;
  }

  function updateUserEmail(select) {
    const opt = select.options[select.selectedIndex];
    const email = opt.dataset.email || '';
    document.getElementById('contactEmail').value = email;
  }

  // Init display
  changePax(0);
</script>

@endsection
