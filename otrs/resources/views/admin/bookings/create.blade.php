@extends('layouts.user')

@section('content')
<style>
    * { box-sizing: border-box; }
    .breadcrumb{font-size:12px;color:#aaa;margin-bottom:20px}
    .breadcrumb a{color:#888;text-decoration:none}
    .breadcrumb a:hover{color:#FF6044}
    .breadcrumb span{color:#FF6044}
    .grid2{display:grid;grid-template-columns:1.6fr 1fr;gap:20px}
    .search-bar{width:100%;background:#0e0f0f;border:0.5px solid #2a2b2b;border-radius:8px;padding:9px 14px;font-size:12px;color:#ccc;outline:none;margin-bottom:10px}
    .search-bar:focus{border-color:#FF6044}
    .search-bar::placeholder{color:#444}
    .filter-row{display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap}
    .f-chip{background:transparent;border:0.5px solid #2a2b2b;border-radius:20px;padding:4px 12px;font-size:11px;color:#888;cursor:pointer;font-family:sans-serif;transition:all .15s}
    .f-chip:hover{border-color:#555;color:#ccc}
    .f-chip.active{background:#FF6044;border-color:#FF6044;color:#fff}
    .flight-list{display:flex;flex-direction:column;gap:8px;max-height:520px;overflow-y:auto;padding-right:4px}
    .flight-list::-webkit-scrollbar{width:4px}
    .flight-list::-webkit-scrollbar-thumb{background:#333;border-radius:2px}
    .panel{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:12px;padding:20px;margin-bottom:14px}
    .p-head{display:flex;align-items:center;gap:12px;margin-bottom:18px;padding-bottom:14px;border-bottom:0.5px solid #2a2b2b}
    .p-icon{width:36px;height:36px;background:#FF6044;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .p-title{font-size:14px;font-weight:600;color:#fff}
    .p-sub{font-size:11px;color:#888;margin-top:2px}
    .f-group{margin-bottom:14px}
    .f-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .f-label{font-size:11px;color:#aaa;margin-bottom:6px;display:block;text-transform:uppercase;letter-spacing:.5px}
    .req{color:#FF6044}
    .f-input{width:100%;background:#0e0f0f;border:0.5px solid #2a2b2b;border-radius:8px;padding:10px 14px;font-size:13px;color:#fff;outline:none;font-family:sans-serif;transition:.15s}
    .f-input:focus{border-color:#FF6044}
    .s-box{background:#0e0f0f;border:0.5px solid #2a2b2b;border-radius:8px;padding:16px}
    .s-head{font-size:10px;color:#888;letter-spacing:1px;text-transform:uppercase;margin-bottom:14px}
    .s-row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:0.5px solid #151515;font-size:12px}
    .s-row:last-child{border-bottom:none}
    .s-k{color:#888}
    .s-v{color:#ccc;font-weight:500;text-align:right;max-width:60%}
    .s-divider{height:0.5px;background:#2a2b2b;margin:8px 0}
    .s-total{display:flex;justify-content:space-between;align-items:center;padding-top:8px}
    .s-tl{font-size:13px;color:#ccc;font-weight:600}
    .s-tv{font-size:26px;font-weight:700;color:#FF6044;font-family:monospace}
    .no-flight{text-align:center;padding:24px;color:#666;font-size:12px}
    .note{font-size:11px;color:#888;margin-top:14px;line-height:1.7;padding:10px 12px;background:rgba(255,96,68,.04);border-radius:8px;border-left:2px solid rgba(255,96,68,.4)}
    .btn-row{display:flex;gap:12px;justify-content:flex-end;margin-top:20px}
    .btn-cancel{background:transparent;color:#888;border:0.5px solid #2a2b2b;border-radius:8px;padding:11px 22px;font-size:13px;cursor:pointer;text-decoration:none;display:inline-block;transition:.15s}
    .btn-cancel:hover{border-color:#555;color:#ccc}
    .btn-book{background:#FF6044;color:#fff;border:none;border-radius:8px;padding:11px 28px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:.15s}
    .btn-book:hover{background:#e5532e}
    .btn-book:disabled{opacity:.4;cursor:not-allowed}
    .alert-error{background:rgba(224,85,85,.1);border:0.5px solid rgba(224,85,85,.4);border-radius:8px;padding:10px 14px;font-size:12px;color:#e05555;margin-bottom:14px}
    @media(max-width:768px){.grid2{grid-template-columns:1fr}.f-row{grid-template-columns:1fr}}
</style>

<div class="max-w-7xl mx-auto">
    <div class="breadcrumb">
        <a href="{{ route('bookings.index') }}">My Bookings</a> → <span>New Flight Booking</span>
    </div>

    @if($errors->isNotEmpty())
        <div class="alert-error"><strong>Error:</strong> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('bookings.store') }}" id="booking-form">
    @csrf
    <input type="hidden" name="schedule_id" id="selected-schedule-id" value="{{ old('schedule_id', $selectedSchedule?->id) }}" />

    <div class="grid2">
        {{-- LEFT --}}
        <div>
            <div class="panel">
                <div class="p-head">
                    <div class="p-icon">
                        <svg viewBox="0 0 24 24" fill="none" width="18" height="18">
                            <path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="p-title">✈ Select Your Flight</div>
                        <div class="p-sub">{{ $schedules->count() }} flights available · prices per person</div>
                    </div>
                </div>

                <input type="text" class="search-bar" id="flight-search"
                       placeholder="🔍 Search by destination, airline, route..."
                       oninput="filterFlights()" />

                <div class="filter-row">
                    <button type="button" class="f-chip active" onclick="filterClass('all',this)">All Classes</button>
                    <button type="button" class="f-chip" onclick="filterClass('economy',this)">Economy</button>
                    <button type="button" class="f-chip" onclick="filterClass('business',this)">Business</button>
                    <button type="button" class="f-chip" onclick="filterClass('first',this)">First Class</button>
                </div>

                <div class="flight-list" id="flight-list">
                    @forelse($schedules as $schedule)
                    @php
                        $dep      = $schedule->departure_at->format('h:i A');
                        $arr      = $schedule->arrival_at ? $schedule->arrival_at->format('h:i A') : 'N/A';
                        $date     = $schedule->departure_at->format('M d, Y');
                        $mins     = $schedule->arrival_at ? $schedule->departure_at->diffInMinutes($schedule->arrival_at) : 0;
                        $dur      = $mins > 0 ? floor($mins/60).'h '.($mins%60).'m' : '—';
                        $fc       = strtolower($schedule->fare_class ?? 'economy');
                        $origin   = $schedule->trip->origin ?? '—';
                        $dest     = $schedule->trip->destination ?? '—';
                        $origCo   = $schedule->trip->origin_country ?? '';
                        $destCo   = $schedule->trip->destination_country ?? '';
                        $operator = $schedule->trip->operator ?? 'N/A';
                        $tripName = $schedule->trip->name ?? '—';
                        $seats    = $schedule->available_seats;
                        $fare     = $schedule->base_fare;
                        $isSelected = (old('schedule_id', $selectedSchedule?->id) == $schedule->id);
                        $tagColor = $fc === 'business' ? '#ef9f27' : ($fc === 'first' ? '#378add' : '#4caf81');
                        $tagBg    = $fc === 'business' ? 'rgba(239,159,39,.15)' : ($fc === 'first' ? 'rgba(55,138,221,.15)' : 'rgba(76,175,129,.15)');
                        $seatColor = $seats < 20 ? '#ffc444' : '#888';
                        $seatBg    = $seats < 20 ? 'rgba(255,196,68,.12)' : 'rgba(136,136,128,.1)';
                        $cardBorder = $isSelected ? '#FF6044' : '#2a2b2b';
                        $priceBg    = $isSelected ? 'rgba(255,96,68,.1)' : '#111';
                    @endphp

                    {{-- FLIGHT CARD — all styles inline to bypass Tailwind reset --}}
                    <div id="card-{{ $schedule->id }}"
                         data-id="{{ $schedule->id }}"
                         data-name="{{ $tripName }}"
                         data-origin="{{ $origin }}"
                         data-dest="{{ $dest }}"
                         data-dep="{{ $date }} {{ $dep }}"
                         data-arr="{{ $arr }}"
                         data-fare="{{ $fare }}"
                         data-class="{{ $fc }}"
                         data-seats="{{ $seats }}"
                         data-operator="{{ $operator }}"
                         data-duration="{{ $dur }}"
                         data-search="{{ strtolower($tripName.' '.$origin.' '.$dest.' '.$operator.' '.$origCo.' '.$destCo) }}"
                         onclick="selectFlight(this)"
                         style="
                            background: #0e0f0f;
                            border: 1px solid {{ $cardBorder }};
                            border-radius: 10px;
                            overflow: hidden;
                            cursor: pointer;
                            margin-bottom: 2px;
                            display: flex;
                            align-items: stretch;
                            min-height: 100px;
                            transition: border-color .15s;
                         ">

                        {{-- LEFT: Info --}}
                        <div style="flex:1;padding:12px 14px;display:flex;flex-direction:column;justify-content:space-between;min-width:0;">

                            {{-- Name + Airline --}}
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                <div style="width:30px;height:30px;background:#1a1b1b;border:1px solid #2a2b2b;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:14px;color:#fff;">✈</div>
                                <div style="min-width:0;">
                                    <div style="font-size:13px;font-weight:700;color:#ffffff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tripName }}</div>
                                    <div style="font-size:11px;color:#aaaaaa;margin-top:1px;">{{ $operator }}</div>
                                </div>
                            </div>

                            {{-- Route --}}
                            <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                                <div>
                                    <div style="font-size:14px;font-weight:700;color:#ffffff;">{{ $origin }}</div>
                                    @if($origCo)<div style="font-size:10px;color:#777;">{{ $origCo }}</div>@endif
                                    <div style="font-size:10px;color:#888;">{{ $dep }}</div>
                                </div>
                                <div style="flex:1;text-align:center;color:#555;font-size:12px;padding:0 4px;">
                                    ──✈──
                                    <div style="font-size:9px;color:#444;margin-top:2px;">{{ $dur }}</div>
                                </div>
                                <div style="text-align:right;">
                                    <div style="font-size:14px;font-weight:700;color:#ffffff;">{{ $dest }}</div>
                                    @if($destCo)<div style="font-size:10px;color:#777;">{{ $destCo }}</div>@endif
                                    <div style="font-size:10px;color:#888;">{{ $arr }}</div>
                                </div>
                            </div>

                            {{-- Tags --}}
                            <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:{{ $tagBg }};color:{{ $tagColor }};">{{ ucfirst($fc) }}</span>
                                <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:{{ $seatBg }};color:{{ $seatColor }};">{{ $seats }} seats</span>
                                <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:rgba(255,96,68,.08);color:#FF6044;">{{ $date }}</span>
                            </div>
                        </div>

                        {{-- RIGHT: Price --}}
                        <div style="background:{{ $priceBg }};border-left:1px solid #2a2b2b;padding:12px 14px;display:flex;flex-direction:column;align-items:center;justify-content:center;min-width:110px;flex-shrink:0;">
                            <div style="font-size:9px;color:#888;text-transform:uppercase;letter-spacing:1px;margin-bottom:3px;">Price</div>
                            <div style="font-size:18px;font-weight:700;color:#FF6044;font-family:monospace;white-space:nowrap;">₱{{ number_format($fare, 0) }}</div>
                            <div style="font-size:10px;color:#666;margin-top:2px;">per person</div>
                            <button type="button"
                                    onclick="event.stopPropagation();selectFlight(this.closest('[data-id]'))"
                                    style="margin-top:8px;background:#FF6044;border:none;border-radius:6px;padding:5px 10px;font-size:11px;color:#fff;cursor:pointer;width:100%;font-family:sans-serif;">
                                {{ $isSelected ? 'Selected ✓' : 'Select' }}
                            </button>
                        </div>
                    </div>

                    @empty
                    <div style="text-align:center;padding:32px;color:#888;font-size:13px;">
                        <div style="font-size:32px;margin-bottom:8px;">✈</div>
                        No available flights. Run <code>php artisan seed:all</code> first.
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Passenger & Contact --}}
            <div class="panel">
                <div class="p-head">
                    <div class="p-icon" style="background:#378add">
                        <svg viewBox="0 0 24 24" fill="none" width="18" height="18">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="#fff" stroke-width="1.8"/>
                            <circle cx="9" cy="7" r="4" stroke="#fff" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <div>
                        <div class="p-title">Passenger & Contact Info</div>
                        <div class="p-sub">Set number of passengers and your contact</div>
                    </div>
                </div>
                <div class="f-row">
                    <div class="f-group">
                        <label class="f-label">Number of Passengers <span class="req">*</span></label>
                        <input type="number" class="f-input" name="passenger_count" id="pax-input"
                               value="{{ old('passenger_count', 1) }}" min="1" max="150"
                               oninput="updateSummary()" required />
                    </div>
                    <div class="f-group">
                        <label class="f-label">Contact Email <span class="req">*</span></label>
                        <input type="email" class="f-input" name="contact_email"
                               value="{{ old('contact_email', auth()->user()->email) }}"
                               placeholder="email@example.com" required />
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Summary --}}
        <div>
            <div class="panel">
                <div class="s-box">
                    <div class="s-head">✈ Booking Summary</div>
                    <div id="no-flight-msg" class="no-flight" style="{{ $selectedSchedule ? 'display:none' : '' }}">
                        <div style="font-size:28px;opacity:.2;margin-bottom:8px;">✈</div>
                        Select a flight to see your booking summary
                    </div>
                    <div id="summary-content" style="{{ $selectedSchedule ? '' : 'display:none' }}">
                        <div class="s-row"><span class="s-k">Flight</span><span class="s-v" id="sum-name">{{ $selectedSchedule?->trip->name ?? '—' }}</span></div>
                        <div class="s-row"><span class="s-k">Route</span><span class="s-v" id="sum-route">{{ $selectedSchedule ? $selectedSchedule->trip->origin.' → '.$selectedSchedule->trip->destination : '—' }}</span></div>
                        <div class="s-row"><span class="s-k">Airline</span><span class="s-v" id="sum-op">{{ $selectedSchedule?->trip->operator ?? '—' }}</span></div>
                        <div class="s-row"><span class="s-k">Date</span><span class="s-v" id="sum-dep">{{ $selectedSchedule?->departure_at->format('M d, Y h:i A') ?? '—' }}</span></div>
                        <div class="s-row"><span class="s-k">Arrival</span><span class="s-v" id="sum-arr">{{ $selectedSchedule?->arrival_at?->format('h:i A') ?? '—' }}</span></div>
                        <div class="s-row"><span class="s-k">Class</span><span class="s-v" id="sum-class">{{ $selectedSchedule ? ucfirst($selectedSchedule->fare_class) : '—' }}</span></div>
                        <div class="s-row"><span class="s-k">Seats Left</span><span class="s-v" id="sum-seats">{{ $selectedSchedule ? $selectedSchedule->available_seats.' available' : '—' }}</span></div>
                        <div class="s-divider"></div>
                        <div class="s-row">
                            <span class="s-k">Fare / person</span>
                            <span class="s-v" id="sum-fare" style="color:#FF6044;font-size:14px;font-weight:700;">₱{{ $selectedSchedule ? number_format($selectedSchedule->base_fare, 2) : '0.00' }}</span>
                        </div>
                        <div class="s-row"><span class="s-k">× Passengers</span><span class="s-v" id="sum-pax">1 passenger</span></div>
                        <div class="s-divider"></div>
                        <div class="s-total">
                            <span class="s-tl">Total Amount</span>
                            <span class="s-tv" id="sum-total">₱{{ $selectedSchedule ? number_format($selectedSchedule->base_fare, 2) : '0.00' }}</span>
                        </div>
                    </div>
                </div>
                <div class="note">
                    ⏱ <strong style="color:#FF6044">30-minute window</strong> — Complete payment within 30 minutes or the booking expires automatically.
                </div>
            </div>

            <div class="btn-row">
                <a href="{{ route('bookings.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-book" id="book-btn" {{ $selectedSchedule ? '' : 'disabled' }}>
                    <svg viewBox="0 0 24 24" fill="none" width="15" height="15">
                        <path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Confirm Booking
                </button>
            </div>
        </div>
    </div>
    </form>
</div>

<script>
var selectedFare  = {{ $selectedSchedule?->base_fare ?? 0 }};
var selectedSeats = {{ $selectedSchedule?->available_seats ?? 0 }};
var currentClass  = 'all';

function selectFlight(card) {
    document.querySelectorAll('[data-id]').forEach(function(c) {
        c.style.borderColor = '#2a2b2b';
        var btn = c.querySelector('button');
        if (btn) { btn.textContent = 'Select'; btn.style.background = '#FF6044'; }
        var priceBox = c.querySelector('[data-id] > div:last-child');
    });

    card.style.borderColor = '#FF6044';
    var btn = card.querySelector('button');
    if (btn) { btn.textContent = 'Selected ✓'; btn.style.background = '#4caf81'; }

    document.getElementById('selected-schedule-id').value = card.dataset.id;
    selectedFare  = parseFloat(card.dataset.fare)  || 0;
    selectedSeats = parseInt(card.dataset.seats)   || 0;

    document.getElementById('no-flight-msg').style.display  = 'none';
    document.getElementById('summary-content').style.display = 'block';
    document.getElementById('book-btn').disabled = false;

    document.getElementById('sum-name').textContent  = card.dataset.name;
    document.getElementById('sum-route').textContent = card.dataset.origin + ' → ' + card.dataset.dest;
    document.getElementById('sum-op').textContent    = card.dataset.operator;
    document.getElementById('sum-dep').textContent   = card.dataset.dep;
    document.getElementById('sum-arr').textContent   = card.dataset.arr;
    document.getElementById('sum-class').textContent = card.dataset.class.charAt(0).toUpperCase() + card.dataset.class.slice(1);
    document.getElementById('sum-seats').textContent = card.dataset.seats + ' available';
    document.getElementById('sum-fare').textContent  = '₱' + parseFloat(card.dataset.fare).toLocaleString('en-PH', {minimumFractionDigits:2});

    updateSummary();
}

function updateSummary() {
    var pax   = parseInt(document.getElementById('pax-input').value) || 1;
    var total = selectedFare * pax;
    document.getElementById('sum-pax').textContent   = pax + ' passenger' + (pax > 1 ? 's' : '');
    document.getElementById('sum-total').textContent = '₱' + total.toLocaleString('en-PH', {minimumFractionDigits:2});
}

function filterFlights() {
    var q = document.getElementById('flight-search').value.toLowerCase();
    document.querySelectorAll('[data-id]').forEach(function(card) {
        var matchSearch = !q || card.dataset.search.includes(q);
        var matchClass  = currentClass === 'all' || card.dataset.class === currentClass;
        card.style.display = (matchSearch && matchClass) ? 'flex' : 'none';
    });
}

function filterClass(cls, btn) {
    currentClass = cls;
    document.querySelectorAll('.f-chip').forEach(function(c) { c.classList.remove('active'); });
    btn.classList.add('active');
    filterFlights();
}

document.addEventListener('DOMContentLoaded', function() {
    var pre = document.querySelector('[data-id][style*="FF6044"]');
    if (pre) { updateSummary(); }
});
</script>
@endsection