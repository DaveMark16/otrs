<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Book a Flight – OTRS</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
<style>
/* ── Reset & Base ──────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Inter', system-ui, sans-serif;
    background: #0d0e0e;
    color: #ccc;
    min-height: 100vh;
}
a { text-decoration: none; color: inherit; }

/* ── Nav ───────────────────────────────────────────────── */
.nav {
    position: sticky; top: 0; z-index: 100;
    background: rgba(13,14,14,.95);
    backdrop-filter: blur(16px);
    border-bottom: 0.5px solid #1e1f1f;
    padding: 0 5vw;
    height: 60px;
    display: flex; align-items: center; justify-content: space-between;
}
.nav-brand { display: flex; align-items: center; gap: 10px; }
.nav-logo-box {
    width: 32px; height: 32px;
    background: #FF6044; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
}
.nav-title { font-size: 15px; font-weight: 600; color: #fff; }
.nav-title span { color: #FF6044; }
.nav-links { display: flex; align-items: center; gap: 8px; }
.nav-link {
    font-size: 13px; color: #888; padding: 7px 14px;
    border-radius: 7px; transition: .15s;
}
.nav-link:hover { color: #ccc; background: rgba(255,255,255,.05); }
.nav-cta {
    background: #FF6044; color: #fff;
    font-size: 13px; font-weight: 500;
    padding: 8px 18px; border-radius: 8px;
    transition: .15s;
}
.nav-cta:hover { background: #e5532e; }

/* ── Hero ──────────────────────────────────────────────── */
.hero {
    background: linear-gradient(135deg, #0d0e0e 0%, #111213 50%, #0a0b0b 100%);
    padding: 64px 5vw 48px;
    border-bottom: 0.5px solid #1e1f1f;
    position: relative; overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute; top: -60px; right: -60px;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(255,96,68,.08) 0%, transparent 70%);
    pointer-events: none;
}
.hero-label {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,96,68,.1); border: 0.5px solid rgba(255,96,68,.3);
    border-radius: 20px; padding: 5px 12px;
    font-size: 11px; color: #FF6044; font-weight: 500;
    letter-spacing: .5px; text-transform: uppercase;
    margin-bottom: 18px;
}
.hero h1 {
    font-size: clamp(28px, 4vw, 46px);
    font-weight: 700; color: #fff;
    line-height: 1.2; margin-bottom: 14px;
}
.hero h1 span { color: #FF6044; }
.hero-sub {
    font-size: 14px; color: #555; max-width: 480px;
    line-height: 1.7; margin-bottom: 32px;
}
.hero-stats {
    display: flex; gap: 32px; flex-wrap: wrap;
}
.stat-item {}
.stat-num { font-size: 22px; font-weight: 700; color: #fff; font-family: monospace; }
.stat-lbl { font-size: 11px; color: #555; margin-top: 3px; }

/* ── Search Panel ──────────────────────────────────────── */
.search-section {
    padding: 28px 5vw;
    background: #0d0e0e;
    border-bottom: 0.5px solid #1e1f1f;
}
.search-card {
    background: #141515;
    border: 0.5px solid #222;
    border-radius: 14px;
    padding: 20px 22px;
    max-width: 1000px;
}
.search-title {
    font-size: 12px; color: #555;
    text-transform: uppercase; letter-spacing: 1px;
    margin-bottom: 16px;
}
.search-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr auto;
    gap: 10px;
    align-items: end;
}
.s-group { display: flex; flex-direction: column; gap: 5px; }
.s-label { font-size: 10px; color: #666; text-transform: uppercase; letter-spacing: .5px; }
.s-input {
    background: #0d0e0e;
    border: 0.5px solid #222;
    border-radius: 8px;
    padding: 10px 13px;
    font-size: 13px; color: #ccc;
    outline: none; font-family: inherit;
    transition: .15s; width: 100%;
}
.s-input:focus { border-color: #FF6044; }
.s-input::placeholder { color: #444; }
.s-input option { background: #141515; }
.btn-search {
    background: #FF6044; color: #fff; border: none;
    border-radius: 8px; padding: 10px 22px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; white-space: nowrap;
    transition: .15s; font-family: inherit;
    display: flex; align-items: center; gap: 8px;
    height: 42px;
}
.btn-search:hover { background: #e5532e; }
.btn-reset {
    background: transparent; color: #555; border: 0.5px solid #222;
    border-radius: 8px; padding: 10px 16px;
    font-size: 12px; cursor: pointer; font-family: inherit;
    transition: .15s; height: 42px;
}
.btn-reset:hover { color: #ccc; border-color: #444; }

/* ── Class Filters ─────────────────────────────────────── */
.filter-bar {
    padding: 16px 5vw;
    background: #0d0e0e;
    border-bottom: 0.5px solid #1e1f1f;
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
}
.filter-label { font-size: 11px; color: #444; margin-right: 4px; }
.f-chip {
    background: transparent; border: 0.5px solid #222;
    border-radius: 20px; padding: 5px 14px;
    font-size: 11px; color: #666; cursor: pointer;
    font-family: inherit; transition: .15s;
}
.f-chip:hover { border-color: #444; color: #999; }
.f-chip.active { background: #FF6044; border-color: #FF6044; color: #fff; }
.result-count { margin-left: auto; font-size: 11px; color: #444; }

/* ── Flights Grid ──────────────────────────────────────── */
.flights-section { padding: 24px 5vw 60px; }
.flights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 14px;
}

/* ── Flight Card ───────────────────────────────────────── */
.flight-card {
    background: #141515;
    border: 0.5px solid #222;
    border-radius: 12px;
    overflow: hidden;
    transition: .2s;
    cursor: default;
}
.flight-card:hover {
    border-color: #333;
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0,0,0,.4);
}

.fc-header {
    padding: 14px 16px 12px;
    border-bottom: 0.5px solid #1a1b1b;
    display: flex; align-items: center; justify-content: space-between;
}
.fc-airline { display: flex; align-items: center; gap: 9px; }
.fc-icon {
    width: 34px; height: 34px;
    background: #1c1d1d; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; border: 0.5px solid #222; flex-shrink: 0;
}
.fc-name { font-size: 13px; font-weight: 600; color: #fff; }
.fc-op { font-size: 11px; color: #555; margin-top: 2px; }
.fc-class-badge {
    font-size: 10px; padding: 3px 9px;
    border-radius: 20px; font-weight: 500;
}
.badge-eco { background: rgba(76,175,129,.12); color: #4caf81; }
.badge-biz { background: rgba(239,159,39,.12); color: #ef9f27; }
.badge-first { background: rgba(55,138,221,.12); color: #378add; }

.fc-route {
    padding: 16px;
    display: flex; align-items: center; gap: 10px;
}
.fc-city-block { flex: 1; }
.fc-city { font-size: 18px; font-weight: 700; color: #fff; font-family: monospace; }
.fc-country { font-size: 10px; color: #FF6044; font-weight: 600; margin-top: 2px; }
.fc-time { font-size: 12px; color: #555; margin-top: 4px; }
.fc-mid { flex: 1; text-align: center; }
.fc-line {
    display: flex; align-items: center; justify-content: center; gap: 4px;
    color: #333; font-size: 11px; margin-bottom: 4px;
}
.fc-line::before, .fc-line::after {
    content: '';
    height: 0.5px; flex: 1; background: #2a2b2b;
}
.fc-dur { font-size: 10px; color: #555; }
.fc-dest { text-align: right; }

.fc-footer {
    padding: 12px 16px;
    border-top: 0.5px solid #1a1b1b;
    display: flex; align-items: center; justify-content: space-between;
}
.fc-meta { display: flex; gap: 8px; flex-wrap: wrap; }
.fc-tag {
    font-size: 10px; padding: 3px 8px;
    border-radius: 20px; background: rgba(255,255,255,.04);
    color: #555;
}
.fc-tag-warn { background: rgba(255,196,68,.08); color: #ffc444; }
.fc-price-block { text-align: right; }
.fc-price-lbl { font-size: 9px; color: #444; text-transform: uppercase; letter-spacing: 1px; }
.fc-price { font-size: 22px; font-weight: 700; color: #FF6044; font-family: monospace; }
.fc-per { font-size: 10px; color: #444; }

.btn-book-now {
    display: block; width: 100%;
    background: #FF6044; color: #fff; border: none;
    padding: 11px; font-size: 13px; font-weight: 600;
    cursor: pointer; font-family: inherit;
    transition: .15s; text-align: center;
    border-top: 0.5px solid rgba(255,96,68,.3);
}
.btn-book-now:hover { background: #e5532e; }

/* ── Empty State ───────────────────────────────────────── */
.empty-state {
    grid-column: 1 / -1;
    text-align: center; padding: 64px 24px; color: #444;
}
.empty-icon { font-size: 48px; opacity: .15; margin-bottom: 16px; }
.empty-title { font-size: 16px; font-weight: 600; color: #555; margin-bottom: 8px; }
.empty-sub { font-size: 13px; }

/* ── Auth Modal ─────────────────────────────────────────── */
.modal-overlay {
    position: fixed; inset: 0; z-index: 1000;
    background: rgba(0,0,0,.75);
    backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none; transition: opacity .2s;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }
.modal {
    background: #141515;
    border: 0.5px solid #2a2b2b;
    border-radius: 16px;
    padding: 28px;
    width: 100%; max-width: 380px;
    transform: translateY(16px); transition: transform .2s;
    position: relative;
}
.modal-overlay.open .modal { transform: translateY(0); }
.modal-close {
    position: absolute; top: 14px; right: 14px;
    background: none; border: none; color: #555;
    font-size: 18px; cursor: pointer; line-height: 1;
    padding: 4px 8px; border-radius: 6px; transition: .15s;
}
.modal-close:hover { color: #ccc; background: rgba(255,255,255,.06); }
.modal-icon {
    width: 48px; height: 48px;
    background: rgba(255,96,68,.12); border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 16px;
}
.modal h2 { font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 6px; }
.modal-sub { font-size: 13px; color: #555; margin-bottom: 20px; line-height: 1.6; }
.modal-flight-info {
    background: #0d0e0e; border: 0.5px solid #222;
    border-radius: 10px; padding: 14px;
    margin-bottom: 20px; font-size: 12px;
}
.mfi-row { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 0.5px solid #151515; }
.mfi-row:last-child { border-bottom: none; }
.mfi-k { color: #555; }
.mfi-v { color: #ccc; font-weight: 500; text-align: right; }
.modal-btns { display: flex; flex-direction: column; gap: 8px; }
.btn-login {
    background: #FF6044; color: #fff; border: none;
    border-radius: 9px; padding: 12px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; font-family: inherit;
    transition: .15s; text-align: center; display: block;
}
.btn-login:hover { background: #e5532e; }
.btn-register {
    background: transparent; color: #888;
    border: 0.5px solid #2a2b2b;
    border-radius: 9px; padding: 12px;
    font-size: 13px; font-weight: 500;
    cursor: pointer; font-family: inherit;
    transition: .15s; text-align: center; display: block;
}
.btn-register:hover { border-color: #555; color: #ccc; }
.modal-note {
    font-size: 11px; color: #444; text-align: center; margin-top: 12px;
}

/* ── Footer ─────────────────────────────────────────────── */
.footer {
    border-top: 0.5px solid #1a1b1b;
    padding: 20px 5vw;
    display: flex; align-items: center; justify-content: space-between;
    font-size: 11px; color: #444;
}
.footer-brand { display: flex; align-items: center; gap: 8px; }

/* ── Responsive ─────────────────────────────────────────── */
@media (max-width: 768px) {
    .search-grid { grid-template-columns: 1fr 1fr; }
    .search-grid .btn-search, .search-grid .s-group:last-of-type { grid-column: 1 / -1; }
    .nav-links .nav-link { display: none; }
    .hero h1 { font-size: 26px; }
    .hero-stats { gap: 20px; }
    .flights-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<!-- Nav -->
<nav class="nav">
    <div class="nav-brand">
        <div class="nav-logo-box">
            <svg viewBox="0 0 24 24" fill="none" width="17" height="17">
                <path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <span class="nav-title">OT<span>RS</span></span>
    </div>
    <div class="nav-links">
        <a href="{{ route('home') }}" class="nav-link">Home</a>
        <a href="#flights" class="nav-link">Flights</a>
        @auth
            <a href="{{ route('bookings.index') }}" class="nav-cta">My Bookings</a>
        @else
            <a href="{{ route('login') }}" class="nav-link">Login</a>
            <a href="{{ route('register') }}" class="nav-cta">Sign Up</a>
        @endauth
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-label">
        <svg viewBox="0 0 24 24" fill="none" width="12" height="12">
            <path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z" stroke="#FF6044" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Live Flight Availability
    </div>
    <h1>Book Your<br><span>Next Flight</span></h1>
    <p class="hero-sub">Browse all available schedules, compare fares, and secure your seat in seconds. No hidden fees.</p>
    <div class="hero-stats">
        <div class="stat-item">
            <div class="stat-num">{{ $totalFlights }}</div>
            <div class="stat-lbl">Available Flights</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ $destinations }}</div>
            <div class="stat-lbl">Destinations</div>
        </div>
        @if($lowestFare)
        <div class="stat-item">
            <div class="stat-num">₱{{ number_format($lowestFare, 0) }}</div>
            <div class="stat-lbl">Lowest Fare</div>
        </div>
        @endif
    </div>
</section>

<!-- Search -->
<section class="search-section" id="search">
    <div class="search-card">
        <div class="search-title">🔍 Search Flights</div>
        <form method="GET" action="{{ route('booking-page') }}">
            <div class="search-grid">
                <div class="s-group">
                    <label class="s-label">From</label>
                    <input type="text" name="origin" class="s-input"
                        placeholder="Origin city or country"
                        value="{{ request('origin') }}" />
                </div>
                <div class="s-group">
                    <label class="s-label">To</label>
                    <input type="text" name="destination" class="s-input"
                        placeholder="Destination city or country"
                        value="{{ request('destination') }}" />
                </div>
                <div class="s-group">
                    <label class="s-label">Date</label>
                    <input type="date" name="date" class="s-input"
                        value="{{ request('date') }}"
                        min="{{ date('Y-m-d') }}" />
                </div>
                <div class="s-group">
                    <label class="s-label">Class</label>
                    <select name="fare_class" class="s-input">
                        <option value="">All Classes</option>
                        <option value="economy" {{ request('fare_class') === 'economy' ? 'selected' : '' }}>Economy</option>
                        <option value="business" {{ request('fare_class') === 'business' ? 'selected' : '' }}>Business</option>
                        <option value="first" {{ request('fare_class') === 'first' ? 'selected' : '' }}>First Class</option>
                    </select>
                </div>
                <div style="display:flex;gap:6px;align-items:flex-end">
                    <button type="submit" class="btn-search">
                        <svg viewBox="0 0 24 24" fill="none" width="14" height="14">
                            <circle cx="11" cy="11" r="8" stroke="#fff" stroke-width="2"/>
                            <path d="M21 21l-4.35-4.35" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Search
                    </button>
                    @if(request()->hasAny(['origin','destination','date','fare_class']))
                    <a href="{{ route('booking-page') }}" class="btn-reset">Clear</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Filter Chips -->
<div class="filter-bar" id="flights">
    <span class="filter-label">Filter:</span>
    <button type="button" class="f-chip active" onclick="filterClass('all', this)">All Classes</button>
    <button type="button" class="f-chip" onclick="filterClass('economy', this)">Economy</button>
    <button type="button" class="f-chip" onclick="filterClass('business', this)">Business</button>
    <button type="button" class="f-chip" onclick="filterClass('first', this)">First Class</button>
    <span class="result-count" id="result-count">{{ $schedules->count() }} flight{{ $schedules->count() !== 1 ? 's' : '' }} found</span>
</div>

<!-- Flights Grid -->
<section class="flights-section">
    <div class="flights-grid" id="flights-grid">
        @forelse($schedules as $schedule)
        @php
            $dep   = $schedule->departure_at->format('h:i A');
            $arr   = $schedule->arrival_at->format('h:i A');
            $date  = $schedule->departure_at->format('M d, Y');
            $mins  = $schedule->departure_at->diffInMinutes($schedule->arrival_at);
            $dur   = floor($mins/60).'h '.($mins%60).'m';
            $fc    = $schedule->fare_class;
            $badgeCls = $fc === 'business' ? 'badge-biz' : ($fc === 'first' ? 'badge-first' : 'badge-eco');
            $seatWarn = $schedule->available_seats < 20;
        @endphp
        <div class="flight-card"
            data-class="{{ $fc }}"
            data-search="{{ strtolower($schedule->trip->name.' '.$schedule->trip->origin.' '.$schedule->trip->destination.' '.($schedule->trip->operator ?? '').' '.($schedule->trip->origin_country ?? '').' '.($schedule->trip->destination_country ?? '')) }}">

            <!-- Header -->
            <div class="fc-header">
                <div class="fc-airline">
                    <div class="fc-icon">✈</div>
                    <div>
                        <div class="fc-name">{{ $schedule->trip->origin_country ?? $schedule->trip->origin }} → {{ $schedule->trip->destination_country ?? $schedule->trip->destination }}</div>
                        <div class="fc-op">{{ $schedule->trip->operator ?? 'OTRS Airlines' }}</div>
                    </div>
                </div>
                <span class="fc-class-badge {{ $badgeCls }}">{{ ucfirst($fc) }}</span>
            </div>

            <!-- Route -->
            <div class="fc-route">
                <div class="fc-city-block">
                    <div class="fc-city">{{ strtoupper(substr($schedule->trip->origin, 0, 3)) }}</div>
                    <div class="fc-country">{{ $schedule->trip->origin_country ?? '' }}</div>
                    <div class="fc-time">{{ $dep }}</div>
                </div>
                <div class="fc-mid">
                    <div class="fc-line">✈</div>
                    <div class="fc-dur">{{ $dur }}</div>
                </div>
                <div class="fc-city-block fc-dest">
                    <div class="fc-city">{{ strtoupper(substr($schedule->trip->destination, 0, 3)) }}</div>
                    <div class="fc-country">{{ $schedule->trip->destination_country ?? '' }}</div>
                    <div class="fc-time">{{ $arr }}</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="fc-footer">
                <div class="fc-meta">
                    <span class="fc-tag">📅 {{ $date }}</span>
                    <span class="fc-tag {{ $seatWarn ? 'fc-tag-warn' : '' }}">
                        {{ $seatWarn ? '⚠' : '' }} {{ $schedule->available_seats }} seats left
                    </span>
                </div>
                <div class="fc-price-block">
                    <div class="fc-price-lbl">From</div>
                    <div class="fc-price">₱{{ number_format($schedule->base_fare, 0) }}</div>
                    <div class="fc-per">per person</div>
                </div>
            </div>

            <!-- CTA -->
            <button class="btn-book-now" onclick="handleBook(
                {{ $schedule->id }},
                '{{ addslashes($schedule->trip->origin_country ?? $schedule->trip->origin) }} → {{ addslashes($schedule->trip->destination_country ?? $schedule->trip->destination) }}',
                '{{ addslashes($schedule->trip->operator ?? 'OTRS Airlines') }}',
                '{{ $date }} {{ $dep }}',
                '{{ $arr }}',
                '{{ ucfirst($fc) }}',
                '₱{{ number_format($schedule->base_fare, 0) }}',
                {{ $schedule->available_seats }}
            )">
                Book This Flight →
            </button>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">✈</div>
            <div class="empty-title">No flights found</div>
            <div class="empty-sub">Try adjusting your search filters or check back later for new schedules.</div>
        </div>
        @endforelse
    </div>
</section>

<!-- Auth Modal -->
<div class="modal-overlay" id="modal-overlay" onclick="closeModal(event)">
    <div class="modal" id="modal">
        <button class="modal-close" onclick="closeModalDirect()">×</button>
        <div class="modal-icon">✈</div>
        <h2>Sign in to Book</h2>
        <p class="modal-sub">You need an account to complete your booking. It's free and takes less than a minute.</p>

        <div class="modal-flight-info" id="modal-flight-info">
            <div class="mfi-row"><span class="mfi-k">Route</span><span class="mfi-v" id="mfi-route">—</span></div>
            <div class="mfi-row"><span class="mfi-k">Airline</span><span class="mfi-v" id="mfi-op">—</span></div>
            <div class="mfi-row"><span class="mfi-k">Departure</span><span class="mfi-v" id="mfi-dep">—</span></div>
            <div class="mfi-row"><span class="mfi-k">Arrival</span><span class="mfi-v" id="mfi-arr">—</span></div>
            <div class="mfi-row"><span class="mfi-k">Class</span><span class="mfi-v" id="mfi-class">—</span></div>
            <div class="mfi-row"><span class="mfi-k">Fare</span><span class="mfi-v" id="mfi-fare" style="color:#FF6044;font-weight:700">—</span></div>
            <div class="mfi-row"><span class="mfi-k">Seats Available</span><span class="mfi-v" id="mfi-seats">—</span></div>
        </div>

        <div class="modal-btns">
            <a href="" class="btn-login" id="modal-login-btn">Login & Book This Flight</a>
            <a href="{{ route('register') }}" class="btn-register">Create a Free Account</a>
        </div>
        <p class="modal-note">Already have a booking? <a href="{{ route('login') }}" style="color:#FF6044">Login here</a></p>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="footer-brand">
        <div style="width:22px;height:22px;background:#FF6044;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px">✈</div>
        <span>OTRS – Online Tour Reservation System</span>
    </div>
    <span>© {{ date('Y') }} OTRS. All rights reserved.</span>
</footer>

<script>
var currentClass = 'all';

function filterClass(cls, btn) {
    currentClass = cls;
    document.querySelectorAll('.f-chip').forEach(function(c) { c.classList.remove('active'); });
    btn.classList.add('active');
    applyFilters();
}

function applyFilters() {
    var cards = document.querySelectorAll('.flight-card');
    var visible = 0;
    cards.forEach(function(card) {
        var matchClass = currentClass === 'all' || card.dataset.class === currentClass;
        card.style.display = matchClass ? '' : 'none';
        if (matchClass) visible++;
    });
    document.getElementById('result-count').textContent = visible + ' flight' + (visible !== 1 ? 's' : '') + ' found';
}

var pendingScheduleId = null;

function handleBook(scheduleId, route, op, dep, arr, cls, fare, seats) {
    @auth
    // Logged in — go directly to booking page with this schedule pre-selected
    window.location.href = '{{ route("bookings.create") }}?schedule_id=' + scheduleId;
    @else
    // Not logged in — show the modal
    pendingScheduleId = scheduleId;
    document.getElementById('mfi-route').textContent  = route;
    document.getElementById('mfi-op').textContent     = op;
    document.getElementById('mfi-dep').textContent    = dep;
    document.getElementById('mfi-arr').textContent    = arr;
    document.getElementById('mfi-class').textContent  = cls;
    document.getElementById('mfi-fare').textContent   = fare + ' / person';
    document.getElementById('mfi-seats').textContent  = seats + ' available';

    // Build login URL that redirects back to booking page with the selected schedule
    var loginUrl = '{{ route("login") }}?redirect={{ urlencode(route("bookings.create")) }}%3Fschedule_id%3D' + scheduleId;
    document.getElementById('modal-login-btn').href = loginUrl;

    document.getElementById('modal-overlay').classList.add('open');
    @endauth
}

function closeModal(e) {
    if (e.target === document.getElementById('modal-overlay')) {
        closeModalDirect();
    }
}

function closeModalDirect() {
    document.getElementById('modal-overlay').classList.remove('open');
}

// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModalDirect();
});
</script>
</body>
</html>
