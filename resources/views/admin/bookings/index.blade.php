@extends('admin.layouts.app')
@section('page-title', 'Booking Management')

@section('content')
<style>
/* ── Variables from landing page ── */
:root {
  --sand: #f5ede0; --cream: #faf6f0; --brown: #3b2a1a;
  --tan: #c49a6c; --gold: #d4a254; --gold-lt: #e2b46a;
  --teal: #2d6e6e; --teal-lt: #3d8f8f; --white: #ffffff;
  --radius: 16px; --radius-sm: 10px;
  --ff-head: 'Playfair Display', Georgia, serif;
  --ff-body: 'DM Sans', sans-serif;
}

/* Stats row */
.bm-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
.bm-stat {
  background: var(--white); border: 1.5px solid rgba(59,42,26,.09);
  border-radius: var(--radius); padding: 20px 22px;
  position: relative; overflow: hidden; cursor: pointer;
  text-decoration: none; display: block;
  transition: transform .2s, box-shadow .2s, border-color .2s;
  box-shadow: 0 2px 12px rgba(59,42,26,.05);
}
.bm-stat:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(59,42,26,.11); }
.bm-stat::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--ac, var(--teal)); }
.bm-stat.active-filter { border-color: var(--ac, var(--teal)); }
.bm-stat-label { font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(59,42,26,.4); margin-bottom: 8px; }
.bm-stat-val { font-family: var(--ff-head); font-size: 2rem; font-weight: 900; color: var(--brown); line-height: 1; }
.bm-stat-sub { font-size: .73rem; color: rgba(59,42,26,.38); margin-top: 5px; }

/* Header */
.bm-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
.bm-title { font-family: var(--ff-head); font-size: 1.4rem; font-weight: 900; color: var(--brown); }
.bm-sub { font-size: .8rem; color: rgba(59,42,26,.45); margin-top: 3px; }
.bm-new-btn {
  background: var(--teal); color: var(--white);
  padding: .55rem 1.3rem; border-radius: 50px;
  font-size: .85rem; font-weight: 600;
  display: inline-flex; align-items: center; gap: .4rem;
  transition: background .18s, transform .15s;
  box-shadow: 0 4px 14px rgba(45,110,110,.25);
  text-decoration: none;
}
.bm-new-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }

/* Toolbar */
.bm-toolbar { display: flex; gap: 10px; margin-bottom: 16px; align-items: center; flex-wrap: wrap; }
.bm-filter-chips { display: flex; gap: 6px; flex-wrap: wrap; }
.chip {
  padding: 5px 14px; border-radius: 50px;
  font-size: .78rem; font-weight: 600;
  border: 1.5px solid rgba(59,42,26,.12);
  background: var(--white); color: rgba(59,42,26,.5);
  cursor: pointer; text-decoration: none;
  transition: all .15s;
}
.chip:hover { border-color: var(--teal); color: var(--teal); }
.chip.active { background: var(--teal); color: var(--white); border-color: var(--teal); }
.chip.chip-pending.active  { background: #a07830; border-color: #a07830; }
.chip.chip-confirmed.active { background: var(--teal); border-color: var(--teal); }
.chip.chip-cancelled.active { background: #b44444; border-color: #b44444; }
.chip.chip-ticketed.active  { background: var(--brown); border-color: var(--brown); }

/* Search */
.search-wrap { position: relative; flex: 1; min-width: 220px; max-width: 380px; }
.bm-search {
  width: 100%; background: var(--white);
  border: 1.5px solid rgba(59,42,26,.12);
  border-radius: 50px; padding: 8px 16px 8px 38px;
  font-size: .85rem; font-family: var(--ff-body);
  color: var(--brown); outline: none;
  transition: border-color .2s;
}
.bm-search:focus { border-color: var(--teal); }
.bm-search::placeholder { color: rgba(59,42,26,.3); }
.search-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: rgba(59,42,26,.3); pointer-events: none; }
.bm-btn {
  background: var(--teal); color: var(--white);
  border: none; border-radius: 50px;
  padding: 8px 20px; font-size: .85rem;
  font-weight: 600; cursor: pointer; font-family: var(--ff-body);
  transition: background .18s; white-space: nowrap;
}
.bm-btn:hover { background: var(--teal-lt); }
.bm-clear {
  color: rgba(59,42,26,.45); text-decoration: none;
  padding: 7px 14px; border: 1.5px solid rgba(59,42,26,.12);
  border-radius: 50px; font-size: .83rem;
  transition: all .15s; white-space: nowrap;
}
.bm-clear:hover { color: var(--brown); border-color: rgba(59,42,26,.3); }

/* Table */
.bm-wrap {
  background: var(--white); border: 1.5px solid rgba(59,42,26,.08);
  border-radius: var(--radius); overflow: hidden;
  box-shadow: 0 2px 16px rgba(59,42,26,.06);
}
.bm-table { width: 100%; border-collapse: collapse; }
.bm-table thead th {
  padding: 12px 16px; text-align: left;
  font-size: .68rem; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  color: rgba(59,42,26,.38);
  border-bottom: 1.5px solid rgba(59,42,26,.07);
  background: var(--sand); white-space: nowrap;
}
.bm-table tbody tr { border-bottom: 1px solid rgba(59,42,26,.06); transition: background .1s; }
.bm-table tbody tr:last-child { border-bottom: none; }
.bm-table tbody tr:hover { background: rgba(245,237,224,.5); }
.bm-table tbody td { padding: 12px 16px; font-size: .83rem; color: rgba(59,42,26,.6); vertical-align: middle; }

/* Pills */
.pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; letter-spacing: .04em; }
.pill-green    { background: rgba(45,110,110,.1);  color: var(--teal); }
.pill-amber    { background: rgba(212,162,84,.14); color: #9a7030; }
.pill-red      { background: rgba(180,60,60,.08);  color: #b44444; }
.pill-gray     { background: rgba(59,42,26,.07);   color: rgba(59,42,26,.5); }
.pill-blue     { background: rgba(45,110,110,.08); color: var(--teal); }

/* Action buttons */
.act-btn {
  padding: 5px 12px; border-radius: 50px;
  font-size: .75rem; font-weight: 600;
  cursor: pointer; border: 1.5px solid;
  background: transparent; text-decoration: none;
  transition: all .15s; display: inline-flex;
  align-items: center; gap: 3px; font-family: var(--ff-body);
  white-space: nowrap;
}
.act-view    { color: var(--teal);  border-color: rgba(45,110,110,.3); }
.act-view:hover { background: rgba(45,110,110,.08); }
.act-approve { color: #2e7d52; border-color: rgba(46,125,82,.3); }
.act-approve:hover { background: rgba(46,125,82,.08); }
.act-reject  { color: #b44444; border-color: rgba(180,68,68,.3); }
.act-reject:hover { background: rgba(180,68,68,.08); }
.act-delete  { color: #b44444; border-color: rgba(180,68,68,.2); }
.act-delete:hover { background: rgba(180,68,68,.08); }

/* Ref badge */
.ref-badge { font-family: monospace; font-size: .72rem; font-weight: 700; color: var(--teal); letter-spacing: .02em; }

/* User chip */
.user-chip { display: flex; align-items: center; gap: 9px; }
.user-av {
  width: 28px; height: 28px; border-radius: 50%;
  background: linear-gradient(135deg, var(--gold), var(--tan));
  display: flex; align-items: center; justify-content: center;
  font-family: var(--ff-head); font-size: .72rem; font-weight: 700;
  color: var(--brown); flex-shrink: 0;
}

/* Footer */
.bm-footer {
  display: flex; align-items: center; padding: 14px 18px;
  border-top: 1.5px solid rgba(59,42,26,.07);
  font-size: .78rem; color: rgba(59,42,26,.38);
  gap: 16px; flex-wrap: wrap;
}
.bm-footer span { flex: 1; min-width: 120px; }

/* Empty */
.bm-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 64px 20px; gap: 12px; }
.bm-empty-icon { font-size: 36px; opacity: .2; }
.bm-empty-text { color: rgba(59,42,26,.4); font-size: .88rem; }

/* Pagination override */
.pagination { display: flex; gap: 4px; list-style: none; }
.page-item .page-link {
  padding: 5px 11px; border-radius: 8px;
  font-size: .78rem; font-weight: 600;
  border: 1.5px solid rgba(59,42,26,.12);
  color: rgba(59,42,26,.5); background: var(--white);
  text-decoration: none; transition: all .15s;
}
.page-item .page-link:hover { border-color: var(--teal); color: var(--teal); }
.page-item.active .page-link { background: var(--teal); border-color: var(--teal); color: var(--white); }
.page-item.disabled .page-link { opacity: .35; pointer-events: none; }

@media (max-width: 768px) {
  .bm-stats { grid-template-columns: repeat(2, 1fr); }
  .bm-table { font-size: .75rem; }
}
</style>

{{-- Header --}}
<div class="bm-header">
  <div>
    <div class="bm-title">Booking Management</div>
    <div class="bm-sub">Review, approve and manage user reservations</div>
  </div>

</div>

{{-- Stat cards --}}
<div class="bm-stats">
  <a href="{{ route('admin.bookings.index') }}" class="bm-stat {{ $status==='all'?'active-filter':'' }}" style="--ac:var(--teal)">
    <div class="bm-stat-label">Total Bookings</div>
    <div class="bm-stat-val">{{ $counts['all'] }}</div>
    <div class="bm-stat-sub">All time</div>
  </a>
  <a href="{{ route('admin.bookings.index',['status'=>'pending']) }}" class="bm-stat {{ $status==='pending'?'active-filter':'' }}" style="--ac:#a07830">
    <div class="bm-stat-label">Pending</div>
    <div class="bm-stat-val">{{ $counts['pending'] }}</div>
    <div class="bm-stat-sub">Awaiting payment</div>
  </a>
  <a href="{{ route('admin.bookings.index',['status'=>'confirmed']) }}" class="bm-stat {{ $status==='confirmed'?'active-filter':'' }}" style="--ac:var(--teal)">
    <div class="bm-stat-label">Confirmed</div>
    <div class="bm-stat-val">{{ $counts['confirmed'] }}</div>
    <div class="bm-stat-sub">Ready to travel</div>
  </a>
  <a href="{{ route('admin.bookings.index',['status'=>'cancelled']) }}" class="bm-stat {{ $status==='cancelled'?'active-filter':'' }}" style="--ac:#b44444">
    <div class="bm-stat-label">Cancelled</div>
    <div class="bm-stat-val">{{ $counts['cancelled'] }}</div>
    <div class="bm-stat-sub">Cancelled trips</div>
  </a>
</div>

{{-- Toolbar: filter chips + search --}}
<form method="GET" action="{{ route('admin.bookings.index') }}">
<div class="bm-toolbar">
  <div class="bm-filter-chips">
    <a href="{{ route('admin.bookings.index') }}" class="chip {{ $status==='all'?'active':'' }}">All</a>
    <a href="{{ route('admin.bookings.index',['status'=>'pending','search'=>request('search')]) }}" class="chip chip-pending {{ $status==='pending'?'active':'' }}">Pending</a>
    <a href="{{ route('admin.bookings.index',['status'=>'confirmed','search'=>request('search')]) }}" class="chip chip-confirmed {{ $status==='confirmed'?'active':'' }}">Confirmed</a>
    <a href="{{ route('admin.bookings.index',['status'=>'ticketed','search'=>request('search')]) }}" class="chip chip-ticketed {{ $status==='ticketed'?'active':'' }}">Ticketed</a>
    <a href="{{ route('admin.bookings.index',['status'=>'cancelled','search'=>request('search')]) }}" class="chip chip-cancelled {{ $status==='cancelled'?'active':'' }}">Cancelled</a>
  </div>
  <div style="flex:1"></div>
  <input type="hidden" name="status" value="{{ $status }}">
  <div class="search-wrap">
    <span class="search-icon">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    </span>
    <input class="bm-search" type="text" name="search" placeholder="Search reference, route…" value="{{ request('search') }}">
  </div>
  <button type="submit" class="bm-btn">Search</button>
  @if(request()->filled('search'))
    <a href="{{ route('admin.bookings.index',['status'=>$status]) }}" class="bm-clear">Clear</a>
  @endif
</div>
</form>

{{-- Table --}}
<div class="bm-wrap">
  @if($bookings->count())
  <table class="bm-table">
    <thead>
      <tr>
        <th>Reference No</th>
        <th>Route</th>
        <th>Departure</th>
        <th>Class</th>
        <th>Pax</th>
        <th>Total</th>
        <th>Status</th>
        <th>Booked</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bookings as $booking)
      <tr>
        <td><span class="ref-badge">{{ $booking->reference_no }}</span></td>
        <td>
          @if($booking->schedule?->trip)
            <div style="font-weight:600;color:var(--brown);font-size:.85rem;">
              {{ $booking->schedule->trip->origin }} → {{ $booking->schedule->trip->destination }}
            </div>
            <div style="font-size:.73rem;color:rgba(59,42,26,.4);margin-top:2px;">
              {{ $booking->schedule->trip->origin_country ?? '' }}
              @if($booking->schedule->trip->destination_country ?? null)
                → {{ $booking->schedule->trip->destination_country }}
              @endif
            </div>
          @else —
          @endif
        </td>
        <td>
          @if($booking->schedule)
            <div style="font-weight:600;color:var(--brown);font-size:.83rem;">{{ \Carbon\Carbon::parse($booking->schedule->departure_at)->format('M d, Y') }}</div>
            <div style="font-size:.73rem;color:rgba(59,42,26,.38);">{{ \Carbon\Carbon::parse($booking->schedule->departure_at)->format('h:i A') }}</div>
          @else —
          @endif
        </td>
        <td>
          <span style="background:rgba(59,42,26,.06);color:rgba(59,42,26,.55);border-radius:6px;padding:3px 9px;font-size:.73rem;font-weight:600;">
            {{ ucfirst($booking->class ?? 'Economy') }}
          </span>
        </td>
        <td style="text-align:center;font-weight:700;color:var(--brown);">{{ $booking->passenger_count }}</td>
        <td style="font-weight:700;color:var(--gold);font-size:.88rem;">₱{{ number_format($booking->total_amount,2) }}</td>
        <td>
          @php $s = $booking->status; @endphp
          <span class="pill {{ $s==='confirmed'?'pill-green':($s==='pending'?'pill-amber':($s==='cancelled'?'pill-red':($s==='ticketed'?'pill-blue':'pill-gray'))) }}">
            {{ ucfirst($s) }}
          </span>
        </td>
        <td style="font-size:.75rem;color:rgba(59,42,26,.38);">{{ $booking->created_at->format('M d, Y') }}</td>
        <td>
          <div style="display:flex;gap:5px;flex-wrap:wrap;align-items:center;">
            <a href="{{ route('admin.bookings.show',$booking) }}" class="act-btn act-view">View</a>
            @if($booking->status==='pending')

              <form method="POST" action="{{ route('admin.bookings.reject',$booking) }}" style="display:inline"
                    onsubmit="return confirm('Cancel booking {{ $booking->reference_no }}?')">
                @csrf @method('PATCH')
                <button class="act-btn act-reject">Cancel</button>
              </form>
            @endif
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="bm-footer">
    <span>Showing {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }} of {{ $bookings->total() }} results</span>
    {{ $bookings->appends(request()->query())->links() }}
  </div>
  @else
  <div class="bm-empty">
    <div class="bm-empty-icon">📋</div>
    <div class="bm-empty-text">No {{ $status!=='all'?$status:'' }} bookings found.</div>
    @if($status!=='all')
      <a href="{{ route('admin.bookings.index') }}" class="bm-btn" style="margin-top:4px;">View all bookings</a>
    @endif
  </div>
  @endif
</div>
@endsection