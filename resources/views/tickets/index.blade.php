@extends('layouts.user')
@section('page-title', 'My Tickets')

@section('content')
<style>
/* ── Page header ────────────────────────────────────── */
.page-eyebrow { font-size:.67rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:6px;display:flex;align-items:center;gap:7px; }
.page-eyebrow::before { content:'';display:block;width:28px;height:2px;background:var(--gold);border-radius:2px; }
.page-title { font-family:var(--ff-head);font-size:1.85rem;font-weight:900;color:var(--brown);line-height:1.15;margin-bottom:4px; }
.page-title em { color:var(--teal);font-style:italic; }
.page-subtitle { font-size:.82rem;color:rgba(59,42,26,.42);margin-bottom:26px; }

/* ── Stats grid ─────────────────────────────────────── */
.stats-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px; }
.stat-card {
  background:var(--white);
  border:1.5px solid rgba(59,42,26,.08);
  border-radius:var(--radius);
  padding:20px 22px;
  position:relative;
  overflow:hidden;
  transition:transform .2s,box-shadow .2s;
  box-shadow:0 2px 12px rgba(59,42,26,.05);
}
.stat-card:hover { transform:translateY(-3px);box-shadow:0 10px 28px rgba(59,42,26,.10); }
.stat-card::before { content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--ac,var(--teal)); }
.stat-icon-wrap { width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:14px; }
.stat-icon-wrap svg { width:17px;height:17px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round; }
.stat-label { font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:6px; }
.stat-value { font-family:var(--ff-head);font-size:2rem;font-weight:900;color:var(--brown);line-height:1; }
.stat-sub   { font-size:.72rem;color:rgba(59,42,26,.35);margin-top:5px; }

/* ── Table panel ────────────────────────────────────── */
.table-panel {
  background:var(--white);
  border:1.5px solid rgba(59,42,26,.08);
  border-radius:var(--radius);
  overflow:hidden;
  box-shadow:0 2px 14px rgba(59,42,26,.05);
}
.panel-head {
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 24px;
  border-bottom:1.5px solid rgba(59,42,26,.07);
}
.panel-title-wrap { display:flex;align-items:center;gap:8px; }
.panel-dot  { width:8px;height:8px;border-radius:50%;background:var(--gold);flex-shrink:0; }
.panel-title { font-family:var(--ff-head);font-size:1.05rem;font-weight:700;color:var(--brown); }
.panel-count { font-size:.72rem;font-weight:700;letter-spacing:.06em;background:rgba(45,110,110,.08);color:var(--teal);border:1px solid rgba(45,110,110,.18);border-radius:20px;padding:3px 10px; }

/* ── Filter tabs ────────────────────────────────────── */
.filter-bar { display:flex;align-items:center;gap:6px;padding:14px 24px;border-bottom:1.5px solid rgba(59,42,26,.07);flex-wrap:wrap; }
.filter-btn {
  padding:5px 14px;border-radius:20px;font-size:.75rem;font-weight:600;
  border:1.5px solid rgba(59,42,26,.12);background:transparent;
  color:rgba(59,42,26,.45);cursor:pointer;font-family:var(--ff-body);
  transition:all .15s;
}
.filter-btn:hover { border-color:rgba(45,110,110,.25);color:var(--teal); }
.filter-btn.active { background:rgba(45,110,110,.08);border-color:rgba(45,110,110,.25);color:var(--teal); }

/* ── Table ──────────────────────────────────────────── */
.ticket-table { width:100%;border-collapse:collapse; }
.ticket-table thead th {
  padding:11px 16px;
  font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:rgba(59,42,26,.35);
  border-bottom:1.5px solid rgba(59,42,26,.07);
  background:var(--sand);
  text-align:left;white-space:nowrap;
}
.ticket-table thead th:last-child { text-align:right; }
.ticket-table tbody tr { border-bottom:1px solid rgba(59,42,26,.06);transition:background .1s; }
.ticket-table tbody tr:last-child { border-bottom:none; }
.ticket-table tbody tr:hover td { background:rgba(245,237,224,.45); }
.ticket-table tbody td { padding:13px 16px;font-size:.82rem;color:rgba(59,42,26,.55);vertical-align:middle; }
.ticket-table tbody td:last-child { text-align:right; }

/* ── Ticket number ──────────────────────────────────── */
.ticket-no { font-family:monospace;font-size:.78rem;font-weight:700;color:var(--teal); }

/* ── Passenger chip ─────────────────────────────────── */
.pax-chip { display:flex;align-items:center;gap:9px; }
.pax-av   { width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--tan));display:inline-flex;align-items:center;justify-content:center;font-family:var(--ff-head);font-size:.72rem;font-weight:700;color:var(--brown);flex-shrink:0; }
.pax-name { font-size:.82rem;font-weight:600;color:var(--brown); }

/* ── Route cell ─────────────────────────────────────── */
.route-main { font-weight:600;color:var(--brown);font-size:.83rem; }
.route-sub  { font-size:.7rem;color:var(--teal);margin-top:1px; }

/* ── Seat badge ─────────────────────────────────────── */
.seat-badge { display:inline-block;background:var(--sand);border:1.5px solid rgba(59,42,26,.1);border-radius:6px;padding:2px 8px;font-size:.72rem;font-weight:700;color:rgba(59,42,26,.5);font-family:monospace; }

/* ── Class pill ─────────────────────────────────────── */
.class-pill { display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:.7rem;font-weight:700;background:rgba(45,110,110,.07);color:var(--teal); }

/* ── Status pill ────────────────────────────────────── */
.pill { display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;font-size:.7rem;font-weight:700; }
.pill::before { content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0; }
.pill-issued    { background:rgba(45,110,110,.1);  color:var(--teal);  }
.pill-issued::before    { background:var(--teal); }
.pill-used      { background:rgba(45,110,110,.08); color:var(--teal);  }
.pill-used::before      { background:var(--teal-lt); }
.pill-cancelled { background:rgba(180,60,60,.08);  color:#b44444;      }
.pill-cancelled::before { background:#b44444; }

/* ── Action links ───────────────────────────────────── */
.action-group { display:inline-flex;align-items:center;gap:8px;justify-content:flex-end; }
.act-view { font-size:.78rem;font-weight:600;color:var(--teal);text-decoration:none;opacity:.85;transition:opacity .15s; }
.act-view:hover { opacity:1; }
.act-cancel { font-size:.78rem;font-weight:600;color:#b44444;background:none;border:none;cursor:pointer;font-family:var(--ff-body);opacity:.75;transition:opacity .15s;padding:0; }
.act-cancel:hover { opacity:1; }
.act-sep { color:rgba(59,42,26,.18);font-size:.7rem; }

/* ── Empty state ────────────────────────────────────── */
.empty-state { padding:60px 20px;text-align:center; }
.empty-icon  { width:56px;height:56px;border-radius:16px;background:rgba(45,110,110,.08);display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;color:var(--teal); }
.empty-icon svg { width:24px;height:24px;stroke:currentColor;fill:none;stroke-width:1.5; }
.empty-title { font-family:var(--ff-head);font-size:1.1rem;font-weight:700;color:var(--brown);margin-bottom:6px; }
.empty-sub   { font-size:.82rem;color:rgba(59,42,26,.38);margin-bottom:18px; }
.btn-cta { display:inline-flex;align-items:center;gap:7px;background:var(--teal);color:var(--white);padding:10px 22px;border-radius:50px;font-size:.84rem;font-weight:600;text-decoration:none;box-shadow:0 4px 14px rgba(45,110,110,.25);transition:all .18s; }
.btn-cta svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2; }
.btn-cta:hover { background:var(--teal-lt);transform:translateY(-1px); }

/* ── Pagination ─────────────────────────────────────── */
.pagination-wrap { padding:16px 24px;border-top:1.5px solid rgba(59,42,26,.07);display:flex;justify-content:center; }
.pagination-wrap .pagination { display:flex;gap:4px;align-items:center; }
.pagination-wrap .page-item .page-link {
  display:inline-flex;align-items:center;justify-content:center;
  width:32px;height:32px;border-radius:8px;font-size:.8rem;font-weight:600;
  color:rgba(59,42,26,.5);background:transparent;border:1.5px solid transparent;
  text-decoration:none;transition:all .15s;
}
.pagination-wrap .page-item.active .page-link { background:var(--teal);color:var(--white);border-color:var(--teal); }
.pagination-wrap .page-item .page-link:hover:not(.active) { background:var(--sand);border-color:rgba(59,42,26,.12);color:var(--brown); }
.pagination-wrap .page-item.disabled .page-link { opacity:.3;cursor:default; }

/* ── Responsive ─────────────────────────────────────── */
@media(max-width:768px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px) { .stats-grid { grid-template-columns:1fr 1fr; } }
</style>

{{-- Page header --}}
<div class="page-eyebrow">Your Travel Hub</div>
<h1 class="page-title">Ticket <em>History</em></h1>
<p class="page-subtitle">All your issued, active, and past travel tickets.</p>

{{-- Stats --}}
<div class="stats-grid">
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-icon-wrap" style="background:rgba(45,110,110,.1);color:var(--teal)">
      <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
    </div>
    <div class="stat-label">Total Tickets</div>
    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
    <div class="stat-sub">All time</div>
  </div>
  <div class="stat-card" style="--ac:var(--gold)">
    <div class="stat-icon-wrap" style="background:rgba(212,162,84,.12);color:var(--gold)">
      <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
    </div>
    <div class="stat-label">Active Tickets</div>
    <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
    <div class="stat-sub">Valid for travel</div>
  </div>
  <div class="stat-card" style="--ac:var(--teal-lt)">
    <div class="stat-icon-wrap" style="background:rgba(45,110,110,.08);color:var(--teal-lt)">
      <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
    </div>
    <div class="stat-label">Used Tickets</div>
    <div class="stat-value">{{ $stats['used'] ?? 0 }}</div>
    <div class="stat-sub">Already travelled</div>
  </div>
  <div class="stat-card" style="--ac:#b44444">
    <div class="stat-icon-wrap" style="background:rgba(180,60,60,.08);color:#b44444">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    </div>
    <div class="stat-label">Cancelled</div>
    <div class="stat-value">{{ $stats['cancelled'] ?? 0 }}</div>
    <div class="stat-sub">Refunded / void</div>
  </div>
</div>

{{-- Tickets table --}}
<div class="table-panel">
  <div class="panel-head">
    <div class="panel-title-wrap">
      <div class="panel-dot"></div>
      <div class="panel-title">All Tickets</div>
    </div>
    @if($tickets->count() > 0)
      <span class="panel-count">{{ $tickets->total() }} ticket{{ $tickets->total() !== 1 ? 's' : '' }}</span>
    @endif
  </div>

  {{-- Filter tabs --}}
  <div class="filter-bar">
    <button class="filter-btn active" onclick="filterTickets('all', this)">All</button>
    <button class="filter-btn" onclick="filterTickets('issued', this)">Issued</button>
    <button class="filter-btn" onclick="filterTickets('used', this)">Used</button>
    <button class="filter-btn" onclick="filterTickets('cancelled', this)">Cancelled</button>
  </div>

  @if($tickets->count() > 0)
  <div style="overflow-x:auto;">
    <table class="ticket-table" id="ticket-table">
      <thead>
        <tr>
          <th>Ticket No</th>
          <th>Passenger</th>
          <th>Route</th>
          <th>Departure</th>
          <th>Seat</th>
          <th>Class</th>
          <th>Status</th>
          <th>Issued At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tickets as $ticket)
        @php
          $trip     = $ticket->booking->schedule->trip ?? null;
          $schedule = $ticket->booking->schedule ?? null;
          $origin   = $trip->origin ?? '?';
          $dest     = $trip->destination ?? '?';
          $originC  = $trip->origin_country ?? null;
          $destC    = $trip->destination_country ?? null;
          $paxName  = $ticket->passenger_name ?? $ticket->booking->user->name ?? '—';
          $initials = strtoupper(substr($paxName, 0, 2));
        @endphp
        <tr data-status="{{ $ticket->status }}">
          {{-- Ticket No --}}
          <td><span class="ticket-no">{{ $ticket->ticket_no ?? '—' }}</span></td>

          {{-- Passenger --}}
          <td>
            <div class="pax-chip">
              <div class="pax-av">{{ $initials }}</div>
              <span class="pax-name">{{ $paxName }}</span>
            </div>
          </td>

          {{-- Route --}}
          <td>
            <div class="route-main">
              {{ $origin }}
              @if($originC)<span style="font-size:.7rem;color:var(--teal);font-weight:500;">, {{ $originC }}</span>@endif
              →
              {{ $dest }}
              @if($destC)<span style="font-size:.7rem;color:var(--teal);font-weight:500;">, {{ $destC }}</span>@endif
            </div>
          </td>

          {{-- Departure --}}
          <td>
            @if($schedule && $schedule->departure_at)
              <div style="font-weight:600;color:var(--brown);font-size:.82rem;">{{ $schedule->departure_at->format('M d, Y') }}</div>
              <div style="font-size:.72rem;color:rgba(59,42,26,.38);">{{ $schedule->departure_at->format('h:i A') }}</div>
            @else
              —
            @endif
          </td>

          {{-- Seat --}}
          <td><span class="seat-badge">{{ $ticket->seat_no ?? '—' }}</span></td>

          {{-- Class --}}
          <td><span class="class-pill">{{ ucfirst($ticket->fare_class ?? 'Economy') }}</span></td>

          {{-- Status --}}
          <td>
            <span class="pill pill-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span>
          </td>

          {{-- Issued At --}}
          <td style="color:rgba(59,42,26,.42);font-size:.78rem;">
            {{ $ticket->issued_at ? $ticket->issued_at->format('M d, Y') : '—' }}
          </td>

          {{-- Actions --}}
          <td>
            <div class="action-group">
              <a href="{{ route('tickets.show', $ticket) }}" class="act-view">View</a>
              @if($ticket->status === 'issued')
                <span class="act-sep">·</span>
                <form method="POST" action="{{ route('tickets.cancel', $ticket) }}" style="display:inline"
                      onsubmit="return confirm('Cancel this ticket? This cannot be undone.')">
                  @csrf
                  <button type="submit" class="act-cancel">Cancel</button>
                </form>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($tickets->hasPages())
  <div class="pagination-wrap">
    {{ $tickets->links() }}
  </div>
  @endif

  @else
  {{-- Empty state --}}
  <div class="empty-state">
    <div class="empty-icon">
      <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
    </div>
    <div class="empty-title">No tickets yet</div>
    <p class="empty-sub">Complete a booking and payment to generate your first ticket.</p>
    <a href="{{ route('bookings.create') }}" class="btn-cta">
      <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
      Book a Trip
    </a>
  </div>
  @endif
</div>

<script>
function filterTickets(status, btn) {
  // Update active button
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  // Filter rows
  document.querySelectorAll('#ticket-table tbody tr').forEach(function(row) {
    if (status === 'all' || row.dataset.status === status) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}
</script>
@endsection