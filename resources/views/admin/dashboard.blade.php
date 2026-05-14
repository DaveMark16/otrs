@extends('admin.layouts.app')
@section('page-title', 'Dashboard')

@section('content')
<style>
  /* ── Layout ── */
  .dash { display: flex; flex-direction: column; gap: 22px; }

  /* ── Welcome Banner ── */
  .welcome-banner {
    background: linear-gradient(120deg, var(--teal) 0%, #1a4f4f 60%, #122e2e 100%);
    border-radius: var(--radius);
    padding: 28px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(45,110,110,.28);
  }
  .welcome-banner::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(212,162,84,.10);
    pointer-events: none;
  }
  .welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -60px; right: 120px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
    pointer-events: none;
  }
  .welcome-left { position: relative; z-index: 1; }
  .welcome-greeting {
    font-size: .8rem; font-weight: 600; letter-spacing: .13em;
    text-transform: uppercase; color: var(--gold); opacity: .9;
    margin-bottom: 6px;
  }
  .welcome-name {
    font-family: var(--ff-head); font-size: 1.75rem; font-weight: 900;
    color: #fff; line-height: 1.15; margin-bottom: 8px;
  }
  .welcome-sub { font-size: .83rem; color: rgba(255,255,255,.5); }
  .welcome-right {
    display: flex; gap: 12px; align-items: center;
    position: relative; z-index: 1;
  }
  .wstat {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 14px;
    padding: 14px 20px;
    text-align: center;
    min-width: 90px;
    backdrop-filter: blur(8px);
  }
  .wstat-val {
    font-family: var(--ff-head); font-size: 1.6rem; font-weight: 900;
    color: #fff; line-height: 1;
  }
  .wstat-label { font-size: .68rem; font-weight: 600; letter-spacing: .1em;
    text-transform: uppercase; color: rgba(255,255,255,.45); margin-top: 5px; }

  /* ── KPI Grid ── */
  .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
  .kpi {
    background: var(--white);
    border: 1.5px solid rgba(59,42,26,.07);
    border-radius: var(--radius);
    padding: 20px 22px;
    position: relative; overflow: hidden;
    box-shadow: 0 2px 10px rgba(59,42,26,.05);
    transition: transform .2s, box-shadow .2s;
  }
  .kpi:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(59,42,26,.10); }
  .kpi-accent {
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: var(--kpi-color, var(--teal));
  }
  .kpi-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px; }
  .kpi-icon {
    width: 40px; height: 40px; border-radius: 11px;
    background: var(--kpi-bg, rgba(45,110,110,.09));
    display: flex; align-items: center; justify-content: center;
    color: var(--kpi-color, var(--teal));
  }
  .kpi-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
  .kpi-badge {
    font-size: .67rem; font-weight: 700; padding: 3px 9px;
    border-radius: 20px; background: var(--kpi-bg, rgba(45,110,110,.09));
    color: var(--kpi-color, var(--teal)); letter-spacing: .04em;
  }
  .kpi-label { font-size: .68rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: rgba(59,42,26,.35); margin-bottom: 5px; }
  .kpi-value { font-family: var(--ff-head); font-size: 2rem; font-weight: 900;
    color: var(--brown); line-height: 1; }
  .kpi-sub { font-size: .72rem; color: rgba(59,42,26,.32); margin-top: 5px; }

  /* ── Status Row ── */
  .status-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .scard {
    background: var(--white);
    border: 1.5px solid rgba(59,42,26,.07);
    border-radius: var(--radius);
    padding: 18px 22px;
    display: flex; align-items: center; gap: 16px;
    box-shadow: 0 2px 10px rgba(59,42,26,.04);
  }
  .scard-bar {
    width: 4px; border-radius: 4px; height: 44px;
    background: var(--sc-color, var(--teal)); flex-shrink: 0;
  }
  .scard-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: var(--sc-bg, rgba(45,110,110,.09));
    display: flex; align-items: center; justify-content: center;
    color: var(--sc-color, var(--teal)); flex-shrink: 0;
  }
  .scard-icon svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
  .scard-info { flex: 1; min-width: 0; }
  .scard-label { font-size: .7rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: rgba(59,42,26,.35); margin-bottom: 4px; }
  .scard-val { font-family: var(--ff-head); font-size: 1.65rem; font-weight: 900; color: var(--brown); }

  /* ── Main Grid ── */
  .main-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 18px; align-items: start; }

  /* ── Panel ── */
  .panel {
    background: var(--white);
    border: 1.5px solid rgba(59,42,26,.07);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(59,42,26,.04);
  }
  .panel-head {
    display: flex; justify-content: space-between; align-items: center;
    padding: 18px 22px 16px;
    border-bottom: 1.5px solid rgba(59,42,26,.06);
  }
  .panel-title-wrap { display: flex; align-items: center; gap: 9px; }
  .panel-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
  .panel-title { font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: var(--brown); }
  .panel-count {
    font-size: .7rem; font-weight: 700; padding: 2px 8px;
    border-radius: 20px; background: rgba(59,42,26,.06);
    color: rgba(59,42,26,.45);
  }
  .panel-link {
    font-size: .78rem; font-weight: 600; color: var(--teal);
    text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
    opacity: .8; transition: opacity .15s;
  }
  .panel-link:hover { opacity: 1; }

  /* ── Bookings Table ── */
  .btable { width: 100%; border-collapse: collapse; }
  .btable thead th {
    padding: 10px 16px; font-size: .66rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: rgba(59,42,26,.32); background: rgba(245,237,224,.5);
    border-bottom: 1.5px solid rgba(59,42,26,.07);
    text-align: left; white-space: nowrap;
  }
  .btable tbody tr {
    border-bottom: 1px solid rgba(59,42,26,.055);
    transition: background .1s;
  }
  .btable tbody tr:last-child { border-bottom: none; }
  .btable tbody tr:hover { background: rgba(245,237,224,.4); }
  .btable td { padding: 12px 16px; font-size: .82rem; color: rgba(59,42,26,.6); vertical-align: middle; }

  .ref { font-family: monospace; font-size: .74rem; font-weight: 700; color: var(--teal); }
  .pax-chip { display: flex; align-items: center; gap: 9px; }
  .pax-av {
    width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--gold), var(--tan));
    display: flex; align-items: center; justify-content: center;
    font-family: var(--ff-head); font-size: .68rem; font-weight: 700; color: var(--brown);
  }
  .pax-name { font-weight: 600; color: var(--brown); font-size: .83rem; }
  .route { font-size: .8rem; color: rgba(59,42,26,.5); }
  .route-arrow { color: var(--gold); margin: 0 4px; }
  .amount { font-weight: 700; color: var(--gold); font-size: .87rem; }

  /* ── Pills ── */
  .pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: .69rem; font-weight: 700; }
  .pill-confirmed  { background: rgba(45,110,110,.1);  color: #1d6060; }
  .pill-pending    { background: rgba(212,162,84,.14); color: #9a7030; }
  .pill-cancelled  { background: rgba(180,60,60,.08);  color: #b44444; }
  .pill-ticketed   { background: rgba(45,90,180,.08);  color: #3a5aaa; }

  /* ── View btn ── */
  .view-btn {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .74rem; font-weight: 600; color: var(--teal);
    text-decoration: none; opacity: .75; transition: opacity .15s;
  }
  .view-btn:hover { opacity: 1; }
  .view-btn svg { width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }

  /* ── Right column ── */
  .right-col { display: flex; flex-direction: column; gap: 16px; }

  /* ── Quick Actions ── */
  .qa-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 16px 18px 18px; }
  .qa-btn {
    display: flex; flex-direction: column; align-items: flex-start; gap: 10px;
    background: var(--sand); border: 1.5px solid rgba(59,42,26,.08);
    border-radius: var(--radius-sm); padding: 14px 14px;
    text-decoration: none; transition: all .2s;
  }
  .qa-btn:hover { background: rgba(45,110,110,.07); border-color: rgba(45,110,110,.22); transform: translateY(-2px); box-shadow: 0 6px 18px rgba(45,110,110,.1); }
  .qa-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: var(--white); display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(59,42,26,.08);
    color: var(--qa-c, var(--teal));
  }
  .qa-icon svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
  .qa-label { font-size: .78rem; font-weight: 600; color: rgba(59,42,26,.65); line-height: 1.3; }

  /* ── Recent Users ── */
  .user-row {
    display: flex; align-items: center; gap: 11px;
    padding: 11px 20px;
    border-bottom: 1px solid rgba(59,42,26,.055);
    transition: background .1s;
  }
  .user-row:last-child { border-bottom: none; }
  .user-row:hover { background: rgba(245,237,224,.45); }
  .u-av {
    width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--gold), var(--tan));
    display: flex; align-items: center; justify-content: center;
    font-family: var(--ff-head); font-size: .8rem; font-weight: 700; color: var(--brown);
  }
  .u-info { flex: 1; min-width: 0; }
  .u-name { font-size: .85rem; font-weight: 600; color: var(--brown); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .u-email { font-size: .71rem; color: rgba(59,42,26,.38); margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

  /* ── Revenue bar ── */
  .rev-row { padding: 16px 20px 18px; }
  .rev-item { margin-bottom: 14px; }
  .rev-item:last-child { margin-bottom: 0; }
  .rev-label-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
  .rev-label-text { font-size: .78rem; font-weight: 600; color: rgba(59,42,26,.55); }
  .rev-label-val { font-size: .78rem; font-weight: 700; color: var(--brown); }
  .rev-track { height: 7px; background: rgba(59,42,26,.07); border-radius: 10px; overflow: hidden; }
  .rev-fill { height: 100%; border-radius: 10px; transition: width .6s ease; }

  /* ── Empty ── */
  .empty { padding: 40px; text-align: center; color: rgba(59,42,26,.3); font-size: .85rem; }

  /* ── Responsive ── */
  @media (max-width: 1100px) { .kpi-grid { grid-template-columns: repeat(2,1fr); } }
  @media (max-width: 900px)  { .main-grid { grid-template-columns: 1fr; } .status-row { grid-template-columns: 1fr; } }
  @media (max-width: 600px)  { .kpi-grid { grid-template-columns: 1fr 1fr; } .welcome-right { display: none; } }
</style>

<div class="dash">

  {{-- Welcome Banner --}}
  <div class="welcome-banner">
    <div class="welcome-left">
      <div class="welcome-greeting">Admin Control Center</div>
      <div class="welcome-name">Welcome back, {{ auth()->user()->name ?? 'Administrator' }}</div>
      <div class="welcome-sub">{{ now()->format('l, F j, Y') }} &mdash; Here's what's happening with OTRS today.</div>
    </div>
    <div class="welcome-right">
      <div class="wstat">
        <div class="wstat-val">{{ $stats['pending'] }}</div>
        <div class="wstat-label">Pending</div>
      </div>
      <div class="wstat">
        <div class="wstat-val">{{ $stats['total_trips'] }}</div>
        <div class="wstat-label">Active Trips</div>
      </div>
      <div class="wstat">
        <div class="wstat-val">{{ $stats['total_users'] }}</div>
        <div class="wstat-label">Users</div>
      </div>
    </div>
  </div>

  {{-- KPI Row --}}
  <div class="kpi-grid">
    <div class="kpi" style="--kpi-color:#2d6e6e; --kpi-bg:rgba(45,110,110,.09)">
      <div class="kpi-accent"></div>
      <div class="kpi-top">
        <div class="kpi-icon">
          <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <span class="kpi-badge">{{ $stats['admins'] }} admin{{ $stats['admins'] != 1 ? 's' : '' }}</span>
      </div>
      <div class="kpi-label">Total Users</div>
      <div class="kpi-value">{{ number_format($stats['total_users']) }}</div>
      <div class="kpi-sub">Registered accounts</div>
    </div>

    <div class="kpi" style="--kpi-color:#d4a254; --kpi-bg:rgba(212,162,84,.10)">
      <div class="kpi-accent"></div>
      <div class="kpi-top">
        <div class="kpi-icon">
          <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <span class="kpi-badge">All time</span>
      </div>
      <div class="kpi-label">Total Bookings</div>
      <div class="kpi-value">{{ number_format($stats['total_bookings']) }}</div>
      <div class="kpi-sub">Across all trips</div>
    </div>

    <div class="kpi" style="--kpi-color:#2d6e6e; --kpi-bg:rgba(45,110,110,.09)">
      <div class="kpi-accent"></div>
      <div class="kpi-top">
        <div class="kpi-icon">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <span class="kpi-badge">Confirmed</span>
      </div>
      <div class="kpi-label">Total Revenue</div>
      <div class="kpi-value" style="font-size:1.5rem;">&#8369;{{ number_format($stats['total_revenue'], 0) }}</div>
      <div class="kpi-sub">From confirmed bookings</div>
    </div>

    <div class="kpi" style="--kpi-color:#1a6060; --kpi-bg:rgba(26,96,96,.08)">
      <div class="kpi-accent"></div>
      <div class="kpi-top">
        <div class="kpi-icon">
          <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        </div>
        <span class="kpi-badge">Verified</span>
      </div>
      <div class="kpi-label">Paid Payments</div>
      <div class="kpi-value" style="font-size:1.5rem;">&#8369;{{ number_format($stats['paid_payments'], 0) }}</div>
      <div class="kpi-sub">Settled transactions</div>
    </div>
  </div>

  {{-- Booking Status Row --}}
  <div class="status-row">
    <div class="scard" style="--sc-color:#a07830; --sc-bg:rgba(160,120,48,.10)">
      <div class="scard-bar"></div>
      <div class="scard-icon">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
      </div>
      <div class="scard-info">
        <div class="scard-label">Pending Bookings</div>
        <div class="scard-val">{{ $stats['pending'] }}</div>
      </div>
      <a href="{{ route('admin.bookings.index', ['status'=>'pending']) }}" class="view-btn" style="align-self:center;">
        View
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    </div>

    <div class="scard" style="--sc-color:#2d6e6e; --sc-bg:rgba(45,110,110,.09)">
      <div class="scard-bar"></div>
      <div class="scard-icon">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
      </div>
      <div class="scard-info">
        <div class="scard-label">Confirmed Bookings</div>
        <div class="scard-val">{{ $stats['confirmed'] }}</div>
      </div>
      <a href="{{ route('admin.bookings.index', ['status'=>'confirmed']) }}" class="view-btn" style="align-self:center;">
        View
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    </div>

    <div class="scard" style="--sc-color:#b44444; --sc-bg:rgba(180,68,68,.08)">
      <div class="scard-bar"></div>
      <div class="scard-icon">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
      </div>
      <div class="scard-info">
        <div class="scard-label">Cancelled Bookings</div>
        <div class="scard-val">{{ $stats['cancelled'] }}</div>
      </div>
      <a href="{{ route('admin.bookings.index', ['status'=>'cancelled']) }}" class="view-btn" style="align-self:center;">
        View
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    </div>
  </div>

  {{-- Main Content Grid --}}
  <div class="main-grid">

    {{-- Recent Bookings Table --}}
    <div class="panel">
      <div class="panel-head">
        <div class="panel-title-wrap">
          <span class="panel-dot"></span>
          <span class="panel-title">Recent Bookings</span>
          <span class="panel-count">{{ $recent_bookings->count() }}</span>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="panel-link">
          View all
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      @if($recent_bookings->count())
      <table class="btable">
        <thead>
          <tr>
            <th>Reference</th>
            <th>Passenger</th>
            <th>Route</th>
            <th>Status</th>
            <th>Amount</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($recent_bookings as $b)
          <tr>
            <td><span class="ref">{{ $b->reference_no }}</span></td>
            <td>
              <div class="pax-chip">
                <div class="pax-av">{{ strtoupper(substr($b->user->name ?? 'U', 0, 2)) }}</div>
                <span class="pax-name">{{ $b->user->name ?? '—' }}</span>
              </div>
            </td>
            <td>
              <span class="route">
                {{ $b->schedule->trip->origin ?? '?' }}
                <span class="route-arrow">→</span>
                {{ $b->schedule->trip->destination ?? '?' }}
              </span>
            </td>
            <td>
              @php $bs = $b->status; @endphp
              <span class="pill pill-{{ $bs }}">{{ ucfirst($bs) }}</span>
            </td>
            <td><span class="amount">&#8369;{{ number_format($b->total_amount, 2) }}</span></td>
            <td>
              <a href="{{ route('admin.bookings.show', $b) }}" class="view-btn">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <div class="empty">No bookings yet.</div>
      @endif
    </div>

    {{-- Right Column --}}
    <div class="right-col">

      {{-- Quick Actions --}}
      <div class="panel">
        <div class="panel-head">
          <div class="panel-title-wrap">
            <span class="panel-dot" style="background:var(--teal)"></span>
            <span class="panel-title">Quick Actions</span>
          </div>
        </div>
        <div class="qa-grid">
          <a href="{{ route('admin.bookings.index', ['status'=>'pending']) }}" class="qa-btn">
            <div class="qa-icon" style="--qa-c:#a07830">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
            </div>
            <span class="qa-label">Pending<br>Bookings</span>
          </a>
          <a href="{{ route('admin.users.index') }}" class="qa-btn">
            <div class="qa-icon" style="--qa-c:var(--teal)">
              <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span class="qa-label">Manage<br>Users</span>
          </a>
          <a href="{{ route('admin.trips.create') }}" class="qa-btn">
            <div class="qa-icon" style="--qa-c:#c49a6c">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            </div>
            <span class="qa-label">Add<br>New Trip</span>
          </a>
          <a href="{{ route('admin.payments.index') }}" class="qa-btn">
            <div class="qa-icon" style="--qa-c:var(--teal)">
              <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
            </div>
            <span class="qa-label">View<br>Payments</span>
          </a>
          <a href="{{ route('admin.schedules.index') }}" class="qa-btn">
            <div class="qa-icon" style="--qa-c:#2d6e6e">
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <span class="qa-label">Manage<br>Schedules</span>
          </a>
          <a href="{{ route('admin.promos.index') }}" class="qa-btn">
            <div class="qa-icon" style="--qa-c:#d4a254">
              <svg viewBox="0 0 24 24"><path d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path d="M6 6h.008v.008H6V6z"/></svg>
            </div>
            <span class="qa-label">Manage<br>Promos</span>
          </a>
        </div>
      </div>

      {{-- Revenue Breakdown --}}
      <div class="panel">
        <div class="panel-head">
          <div class="panel-title-wrap">
            <span class="panel-dot" style="background:var(--gold)"></span>
            <span class="panel-title">Booking Breakdown</span>
          </div>
        </div>
        <div class="rev-row">
          @php
            $total = max($stats['total_bookings'], 1);
            $bars = [
              ['label' => 'Confirmed', 'val' => $stats['confirmed'], 'color' => '#2d6e6e'],
              ['label' => 'Pending',   'val' => $stats['pending'],   'color' => '#d4a254'],
              ['label' => 'Cancelled', 'val' => $stats['cancelled'], 'color' => '#b44444'],
            ];
          @endphp
          @foreach($bars as $bar)
          <div class="rev-item">
            <div class="rev-label-row">
              <span class="rev-label-text">{{ $bar['label'] }}</span>
              <span class="rev-label-val">{{ $bar['val'] }} <span style="font-weight:400;color:rgba(59,42,26,.35)">({{ round($bar['val']/$total*100) }}%)</span></span>
            </div>
            <div class="rev-track">
              <div class="rev-fill" style="width:{{ round($bar['val']/$total*100) }}%; background:{{ $bar['color'] }};"></div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Recent Users --}}
      <div class="panel">
        <div class="panel-head">
          <div class="panel-title-wrap">
            <span class="panel-dot" style="background:var(--teal)"></span>
            <span class="panel-title">Recent Users</span>
          </div>
          <a href="{{ route('admin.users.index') }}" class="panel-link">
            View all
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
        </div>
        @forelse($recent_users as $u)
        <div class="user-row">
          <div class="u-av">{{ strtoupper(substr($u->name, 0, 2)) }}</div>
          <div class="u-info">
            <div class="u-name">{{ $u->name }}</div>
            <div class="u-email">{{ $u->email }}</div>
          </div>
          <span class="pill {{ in_array($u->role, ['admin','superadmin']) ? 'pill-confirmed' : 'pill-pending' }}">
            {{ ucfirst($u->role) }}
          </span>
        </div>
        @empty
          <div class="empty">No users yet.</div>
        @endforelse
      </div>

    </div>{{-- end right-col --}}
  </div>{{-- end main-grid --}}

</div>{{-- end dash --}}
@endsection