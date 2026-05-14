@extends('layouts.user')
@section('title', $trip->name . ' — Schedules')

@section('content')
<style>
.breadcrumb{font-size:12px;color:#555;margin-bottom:20px}
.breadcrumb a{color:#888;text-decoration:none}
.breadcrumb a:hover{color:#FF6044}
.breadcrumb span{color:#FF6044}

/* ── Route Hero Banner ── */
.route-banner{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:16px;padding:28px 32px;margin-bottom:20px;position:relative;overflow:hidden}
.route-banner::before{content:'';position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:radial-gradient(circle,rgba(255,96,68,.08),transparent 70%);pointer-events:none}
.rb-meta{font-size:11px;color:#555;margin-bottom:16px;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.rb-meta-pill{padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600}
.rb-air{background:rgba(55,138,221,.15);color:#378add}
.rb-op{background:rgba(76,175,129,.15);color:#4caf81}
.rb-count{background:rgba(255,96,68,.12);color:#FF6044}

.rb-route{display:flex;align-items:center;gap:0}
.rb-end{flex:1}
.rb-city{font-size:32px;font-weight:900;color:#fff;letter-spacing:-1px;line-height:1}
.rb-country{font-size:13px;color:#FF6044;font-weight:700;margin-top:6px;display:flex;align-items:center;gap:4px}
.rb-country-flag{font-size:16px}

.rb-mid{flex:0 0 auto;padding:0 24px;text-align:center}
.rb-arrow-wrap{display:flex;align-items:center;gap:6px;margin-bottom:4px}
.rb-line{flex:1;height:1px;background:linear-gradient(90deg,transparent,#444,transparent)}
.rb-plane{font-size:22px;color:#FF6044}
.rb-airline{font-size:11px;color:#444;white-space:nowrap}

/* ── Filter chips ── */
.filter-bar{display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;align-items:center}
.f-chip{background:transparent;border:0.5px solid #2a2b2b;border-radius:20px;padding:5px 14px;font-size:11px;color:#888;cursor:pointer;font-family:sans-serif;transition:all .15s}
.f-chip:hover{border-color:#555;color:#ccc}
.f-chip.active{background:#FF6044;border-color:#FF6044;color:#fff}

/* ── Schedule cards ── */
.sched-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:14px}
.sched-card{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:12px;overflow:hidden;transition:all .2s}
.sched-card:hover{border-color:#444;transform:translateY(-2px)}

.sc-header{padding:14px 16px;border-bottom:0.5px solid #222;display:flex;align-items:center;justify-content:space-between}
.sc-date{font-size:13px;font-weight:600;color:#fff}
.sc-dow{font-size:11px;color:#555;margin-top:2px}
.sc-class{padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600}
.sc-eco{background:rgba(76,175,129,.15);color:#4caf81}
.sc-biz{background:rgba(239,159,39,.15);color:#ef9f27}
.sc-first{background:rgba(55,138,221,.15);color:#378add}

.sc-body{padding:16px}

/* Mini route inside card */
.sc-mini-route{display:flex;align-items:center;gap:8px;margin-bottom:12px;padding:10px 12px;background:#111;border-radius:8px}
.sc-mini-end{flex:1}
.sc-mini-city{font-size:13px;font-weight:700;color:#fff}
.sc-mini-country{font-size:10px;color:#FF6044;margin-top:2px;font-weight:600}
.sc-mini-time{font-size:11px;color:#555;margin-top:1px}
.sc-mini-mid{text-align:center;flex:0 0 auto;padding:0 6px}
.sc-mini-plane{font-size:13px;color:#444}
.sc-mini-dur{font-size:10px;color:#444;margin-top:2px}

.sc-meta{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.sc-meta-item{text-align:center}
.sc-meta-val{font-size:13px;font-weight:600;color:#ccc}
.sc-meta-lbl{font-size:10px;color:#555;margin-top:1px}
.sc-meta-val.warn{color:#ffc444}
.sc-meta-val.sold{color:#555}

.sc-price{display:flex;justify-content:space-between;align-items:center;padding-top:10px;border-top:0.5px solid #222}
.sc-price-amount{font-size:22px;font-weight:700;color:#FF6044;font-family:monospace}
.sc-price-per{font-size:10px;color:#555;margin-top:2px}
.sc-book-btn{background:#FF6044;color:#fff;border:none;border-radius:8px;padding:9px 18px;font-size:12px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-block;transition:.15s}
.sc-book-btn:hover{background:#e5532e}
.sc-sold{background:#1e1f1f;color:#444;border:0.5px solid #2a2b2b;border-radius:8px;padding:9px 18px;font-size:12px;font-weight:600;cursor:not-allowed;display:inline-block}

.empty{text-align:center;padding:60px;color:#555}
.empty-icon{font-size:48px;opacity:.15;margin-bottom:12px}
</style>

<div class="breadcrumb">
    <a href="{{ route('schedules.index') }}">✈ Trips & Schedules</a> → <span>{{ $trip->name }}</span>
</div>

{{-- ── Route Hero Banner ── --}}
<div class="route-banner">
    <div class="rb-meta">
        <span class="rb-meta-pill rb-air">✈ {{ ucfirst($trip->type ?? 'Air') }}</span>
        @if($trip->operator)
            <span class="rb-meta-pill rb-op">{{ $trip->operator }}</span>
        @endif
        <span class="rb-meta-pill rb-count">{{ $trip->schedules->count() }} schedule(s) available</span>
    </div>

    <div class="rb-route">
        <div class="rb-end">
            <div class="rb-city">{{ $trip->origin }}</div>
            <div class="rb-country">
                <span class="rb-country-flag">🌍</span>
                {{ $trip->origin_country ?? 'Unknown Country' }}
            </div>
        </div>

        <div class="rb-mid">
            <div class="rb-arrow-wrap">
                <div class="rb-line"></div>
                <div class="rb-plane">✈</div>
                <div class="rb-line"></div>
            </div>
            <div class="rb-airline">{{ $trip->operator ?? '' }}</div>
        </div>

        <div class="rb-end" style="text-align:right">
            <div class="rb-city">{{ $trip->destination }}</div>
            <div class="rb-country" style="justify-content:flex-end">
                {{ $trip->destination_country ?? 'Unknown Country' }}
                <span class="rb-country-flag">🌍</span>
            </div>
        </div>
    </div>
</div>

{{-- ── Class Filters ── --}}
<div class="filter-bar">
    <span style="font-size:11px;color:#555;margin-right:4px">Filter by class:</span>
    <button type="button" class="f-chip active" onclick="filterClass('all',this)">All Classes</button>
    <button type="button" class="f-chip" onclick="filterClass('economy',this)">Economy</button>
    <button type="button" class="f-chip" onclick="filterClass('business',this)">Business</button>
    <button type="button" class="f-chip" onclick="filterClass('first',this)">First Class</button>
</div>

{{-- ── Schedule Cards ── --}}
@if($trip->schedules->count() > 0)
<div class="sched-grid" id="sched-grid">
    @foreach($trip->schedules as $schedule)
    @php
        $dep   = $schedule->departure_at->format('h:i A');
        $arr   = $schedule->arrival_at->format('h:i A');
        $date  = $schedule->departure_at->format('M d, Y');
        $dow   = $schedule->departure_at->format('l');
        $mins  = $schedule->departure_at->diffInMinutes($schedule->arrival_at);
        $dur   = floor($mins/60).'h '.($mins%60).'m';
        $fc    = $schedule->fare_class;
        $fcCls = $fc==='business' ? 'sc-biz' : ($fc==='first' ? 'sc-first' : 'sc-eco');
        $sold  = $schedule->available_seats <= 0;
    @endphp
    <div class="sched-card" data-class="{{ $fc }}">
        <div class="sc-header">
            <div>
                <div class="sc-date">{{ $date }}</div>
                <div class="sc-dow">{{ $dow }}</div>
            </div>
            <span class="sc-class {{ $fcCls }}">{{ ucfirst($fc) }}</span>
        </div>

        <div class="sc-body">

            {{-- Mini route with countries --}}
            <div class="sc-mini-route">
                <div class="sc-mini-end">
                    <div class="sc-mini-city">{{ $trip->origin }}</div>
                    <div class="sc-mini-country">🌍 {{ $trip->origin_country ?? '—' }}</div>
                    <div class="sc-mini-time">{{ $dep }}</div>
                </div>
                <div class="sc-mini-mid">
                    <div class="sc-mini-plane">✈</div>
                    <div class="sc-mini-dur">{{ $dur }}</div>
                </div>
                <div class="sc-mini-end" style="text-align:right">
                    <div class="sc-mini-city">{{ $trip->destination }}</div>
                    <div class="sc-mini-country">🌍 {{ $trip->destination_country ?? '—' }}</div>
                    <div class="sc-mini-time">{{ $arr }}</div>
                </div>
            </div>

            {{-- Seat & status meta --}}
            <div class="sc-meta">
                <div class="sc-meta-item">
                    <div class="sc-meta-val">{{ $schedule->capacity }}</div>
                    <div class="sc-meta-lbl">Capacity</div>
                </div>
                <div class="sc-meta-item">
                    <div class="sc-meta-val {{ $sold ? 'sold' : ($schedule->available_seats < 20 ? 'warn' : '') }}">
                        {{ $schedule->available_seats }}
                    </div>
                    <div class="sc-meta-lbl">Seats Left</div>
                </div>
                <div class="sc-meta-item">
                    <div class="sc-meta-val" style="color:#4caf81">{{ ucfirst($schedule->status) }}</div>
                    <div class="sc-meta-lbl">Status</div>
                </div>
            </div>

            {{-- Price + Book --}}
            <div class="sc-price">
                <div>
                    <div class="sc-price-amount">₱{{ number_format($schedule->base_fare, 0) }}</div>
                    <div class="sc-price-per">per person</div>
                </div>
                @if($sold)
                    <span class="sc-sold">Sold Out</span>
                @else
                    <a href="{{ route('bookings.create', ['schedule_id' => $schedule->id]) }}" class="sc-book-btn">
                        Book This Flight →
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@else
<div class="empty">
    <div class="empty-icon">✈</div>
    <div style="font-size:15px;font-weight:600;margin-bottom:6px">No upcoming schedules</div>
    <div style="font-size:12px;color:#444">No available future schedules for this trip.</div>
    <a href="{{ route('schedules.index') }}" style="display:inline-block;margin-top:16px;color:#FF6044;text-decoration:none;font-size:13px">← Back to all flights</a>
</div>
@endif

<script>
function filterClass(cls, btn) {
    document.querySelectorAll('.f-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.sched-card').forEach(card => {
        card.style.display = (cls === 'all' || card.dataset.class === cls) ? '' : 'none';
    });
}
</script>
@endsection
