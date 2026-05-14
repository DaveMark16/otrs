@extends('layouts.user')
@section('title', 'Available Flights')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.page-title{font-size:18px;font-weight:700;color:#fff}
.page-sub{font-size:11px;color:#555;margin-top:2px}
.stats-row{display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap}
.stat-chip{background:#1a1b1b;border:1px solid #2a2b2b;border-radius:8px;padding:10px 16px;font-size:12px;color:#666}
.stat-chip strong{color:#FF6044;font-size:16px;display:block}
.filters{background:#1a1b1b;border:1px solid #2a2b2b;border-radius:10px;padding:12px 14px;display:flex;gap:10px;margin-bottom:16px;align-items:center;flex-wrap:wrap}
.filters input,.filters select{background:#0e0f0f;border:0.5px solid #2a2b2b;border-radius:8px;padding:7px 12px;font-size:13px;color:#ccc;outline:none}
.filters input:focus,.filters select:focus{border-color:#FF6044}
.filters button{background:#FF6044;border:none;border-radius:8px;padding:8px 16px;font-size:13px;font-weight:600;color:#fff;cursor:pointer}
.cards-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:14px}
.fcard{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:14px;overflow:hidden;transition:all .2s;text-decoration:none;display:block}
.fcard:hover{border-color:#FF6044;transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.4)}
.fcard-top{padding:12px 16px 0;display:flex;align-items:center;justify-content:space-between}
.airline-row{display:flex;align-items:center;gap:8px}
.airline-icon{width:30px;height:30px;background:#111;border:0.5px solid #2a2b2b;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.flight-type{padding:3px 9px;border-radius:20px;font-size:10px;font-weight:600;background:rgba(55,138,221,.15);color:#378add}
.fcard-route{padding:16px 16px 12px;display:flex;align-items:center}
.route-end{flex:1}
.route-city{font-size:20px;font-weight:800;color:#fff;line-height:1;letter-spacing:-.3px}
.route-country{font-size:11px;color:#FF6044;margin-top:4px;font-weight:600}
.route-mid{flex:0 0 auto;padding:0 12px;text-align:center}
.route-arrow-line{display:flex;align-items:center;gap:4px;margin-bottom:4px}
.arrow-line{flex:1;height:1px;background:linear-gradient(90deg,#2a2b2b,#444,#2a2b2b)}
.arrow-plane{font-size:14px;color:#FF6044}
.route-scheds{font-size:10px;color:#444}
.fcard-footer{padding:10px 16px 14px;display:flex;align-items:center;justify-content:space-between;border-top:0.5px solid #1e1f1f;margin-top:2px}
.pill{display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:10px;font-weight:600}
.pill-green{background:rgba(76,175,129,.15);color:#4caf81}
.pill-gray{background:rgba(136,135,128,.15);color:#888}
.view-btn{padding:6px 14px;border-radius:7px;font-size:11px;background:#FF6044;color:#fff;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:4px}
.empty-wrap{text-align:center;padding:60px;background:#1a1b1b;border:1px solid #2a2b2b;border-radius:12px;color:#555}
.pag-wrap{margin-top:20px;display:flex;justify-content:center}
</style>

<div class="page-header">
    <div>
        <div class="page-title">✈️ Available Flights</div>
        <div class="page-sub">Browse and book available air trips</div>
    </div>
</div>

<div class="stats-row">
    <div class="stat-chip"><strong>{{ $totalTrips }}</strong>Total Flights</div>
    <div class="stat-chip"><strong>{{ $totalOperators }}</strong>Airlines</div>
    <div class="stat-chip"><strong>{{ $totalCountries }}</strong>Countries</div>
</div>

<form method="GET" class="filters">
    <input type="text" name="search" placeholder="Search destination, origin, airline…" value="{{ request('search') }}" style="flex:1;min-width:200px">
    <select name="operator">
        <option value="">All Airlines</option>
        @foreach($operators as $op)
            <option value="{{ $op }}" {{ request('operator')===$op ? 'selected' : '' }}>{{ $op }}</option>
        @endforeach
    </select>
    <select name="country">
        <option value="">All Countries</option>
        @foreach($countries as $c)
            <option value="{{ $c }}" {{ request('country')===$c ? 'selected' : '' }}>{{ $c }}</option>
        @endforeach
    </select>
    <button type="submit">Filter</button>
    @if(request()->hasAny(['search','operator','country']))
        <a href="{{ route('schedules.index') }}" style="color:#FF6044;text-decoration:none;font-size:12px">Clear</a>
    @endif
</form>

@if($trips->count())
<div class="cards-grid">
    @foreach($trips as $trip)
    <a href="{{ route('schedules.show', $trip->id) }}" class="fcard">

        <div class="fcard-top">
            <div class="airline-row">
                <div class="airline-icon">✈</div>
                <div>
                    <div style="font-size:12px;font-weight:600;color:#ccc">{{ $trip->name }}</div>
                    <div style="font-size:11px;color:#555">{{ $trip->operator ?? 'Unknown Airline' }}</div>
                </div>
            </div>
            <span class="flight-type">{{ ucfirst($trip->type ?? 'Air') }}</span>
        </div>

        <div class="fcard-route">
            <div class="route-end">
                <div class="route-city">{{ $trip->origin }}</div>
                <div class="route-country">🌍 {{ $trip->origin_country ?? '—' }}</div>
            </div>

            <div class="route-mid">
                <div class="route-arrow-line">
                    <div class="arrow-line"></div>
                    <div class="arrow-plane">✈</div>
                    <div class="arrow-line"></div>
                </div>
                <div class="route-scheds">{{ $trip->schedules_count ?? 0 }} flight(s)</div>
            </div>

            <div class="route-end" style="text-align:right">
                <div class="route-city">{{ $trip->destination }}</div>
                <div class="route-country">🌍 {{ $trip->destination_country ?? '—' }}</div>
            </div>
        </div>

        <div class="fcard-footer">
            <span class="pill {{ $trip->status === 'active' ? 'pill-green' : 'pill-gray' }}">
                {{ ucfirst($trip->status) }}
            </span>
            <span class="view-btn">View Schedules →</span>
        </div>

    </a>
    @endforeach
</div>

<div class="pag-wrap">{{ $trips->appends(request()->query())->links() }}</div>

@else
<div class="empty-wrap">
    <div style="font-size:40px;opacity:.15;margin-bottom:12px">✈</div>
    <div style="font-size:14px;font-weight:600;color:#666;margin-bottom:6px">No flights found</div>
    <div style="font-size:12px">Try adjusting your filters or <a href="{{ route('schedules.index') }}" style="color:#FF6044;text-decoration:none">browse all flights</a>.</div>
</div>
@endif

@endsection
