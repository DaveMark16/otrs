@extends('admin.layouts.app')
@section('page-title', 'Promo Management')

@section('content')
<style>
  /* ── Toolbar ── */
  .toolbar {
    display: flex; align-items: center; justify-content: space-between;
    gap: 14px; margin-bottom: 22px; flex-wrap: wrap;
  }
  .toolbar-left { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex: 1; }
  .search-wrap {
    position: relative; flex: 1; max-width: 320px;
  }
  .search-wrap svg {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    width: 15px; height: 15px; stroke: rgba(59,42,26,.3);
    fill: none; stroke-width: 1.8; stroke-linecap: round; pointer-events: none;
  }
  .search-input {
    width: 100%; padding: 9px 12px 9px 36px;
    border: 1.5px solid rgba(59,42,26,.1);
    border-radius: var(--radius-sm);
    background: var(--white); color: var(--brown);
    font-family: var(--ff-body); font-size: .84rem;
    transition: border-color .15s;
  }
  .search-input:focus { outline: none; border-color: var(--teal); }
  .filter-select {
    padding: 9px 14px;
    border: 1.5px solid rgba(59,42,26,.1);
    border-radius: var(--radius-sm);
    background: var(--white); color: var(--brown);
    font-family: var(--ff-body); font-size: .84rem;
    cursor: pointer;
  }
  .filter-select:focus { outline: none; border-color: var(--teal); }
  .btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--teal); color: var(--white);
    border: none; border-radius: 50px;
    padding: 9px 20px; font-size: .84rem; font-weight: 600;
    font-family: var(--ff-body); cursor: pointer; text-decoration: none;
    transition: background .18s, transform .15s;
    white-space: nowrap;
    box-shadow: 0 3px 12px rgba(45,110,110,.22);
  }
  .btn-primary:hover { background: var(--teal-lt); transform: translateY(-1px); }
  .btn-primary svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }

  /* ── Stats strip ── */
  .stats-strip {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 14px; margin-bottom: 22px;
  }
  .sstat {
    background: var(--white);
    border: 1.5px solid rgba(59,42,26,.07);
    border-radius: var(--radius);
    padding: 16px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: 0 2px 8px rgba(59,42,26,.04);
  }
  .sstat-icon {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .sstat-icon svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
  .sstat-label { font-size: .67rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(59,42,26,.35); margin-bottom: 3px; }
  .sstat-val { font-family: var(--ff-head); font-size: 1.5rem; font-weight: 900; color: var(--brown); line-height: 1; }

  /* ── Table panel ── */
  .panel {
    background: var(--white);
    border: 1.5px solid rgba(59,42,26,.07);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(59,42,26,.04);
  }
  .panel-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px;
    border-bottom: 1.5px solid rgba(59,42,26,.06);
  }
  .panel-title-wrap { display: flex; align-items: center; gap: 9px; }
  .panel-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
  .panel-title { font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: var(--brown); }
  .panel-count {
    font-size: .7rem; font-weight: 700; padding: 2px 8px;
    border-radius: 20px; background: rgba(59,42,26,.06); color: rgba(59,42,26,.45);
  }

  /* ── Table ── */
  .ptable { width: 100%; border-collapse: collapse; }
  .ptable thead th {
    padding: 11px 16px; font-size: .66rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: rgba(59,42,26,.32); background: rgba(245,237,224,.5);
    border-bottom: 1.5px solid rgba(59,42,26,.07);
    text-align: left; white-space: nowrap;
  }
  .ptable tbody tr {
    border-bottom: 1px solid rgba(59,42,26,.055);
    transition: background .1s;
  }
  .ptable tbody tr:last-child { border-bottom: none; }
  .ptable tbody tr:hover { background: rgba(245,237,224,.4); }
  .ptable td { padding: 13px 16px; font-size: .83rem; color: rgba(59,42,26,.65); vertical-align: middle; }

  /* ── Promo title cell ── */
  .promo-name { font-weight: 700; color: var(--brown); font-size: .88rem; margin-bottom: 2px; }
  .promo-desc-cell { font-size: .74rem; color: rgba(59,42,26,.38); }

  /* ── Code badge ── */
  .code-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(45,110,110,.07);
    border: 1px solid rgba(45,110,110,.18);
    border-radius: 8px; padding: 5px 11px;
    font-family: monospace; font-size: .82rem; font-weight: 700;
    color: var(--teal); letter-spacing: 1px; cursor: pointer;
    transition: background .15s;
  }
  .code-badge:hover { background: rgba(45,110,110,.13); }
  .code-badge svg { width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; opacity: .6; }

  /* ── Discount badge ── */
  .discount-badge {
    display: inline-block;
    background: linear-gradient(135deg, var(--gold), #e2b46a);
    color: var(--brown); font-weight: 900;
    font-size: .85rem; padding: 4px 12px;
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(212,162,84,.28);
  }

  /* ── Status pill ── */
  .pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 11px; border-radius: 20px; font-size: .7rem; font-weight: 700; white-space: nowrap; }
  .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: .6; flex-shrink: 0; }
  .pill-active   { background: rgba(45,110,110,.1);  color: #1d6060; }
  .pill-expired  { background: rgba(180,60,60,.08);  color: #b44444; }
  .pill-upcoming { background: rgba(212,162,84,.14); color: #9a7030; }

  /* ── Scope badge ── */
  .scope-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .74rem; color: rgba(59,42,26,.5);
  }
  .scope-badge svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; }

  /* ── Date range ── */
  .date-range { font-size: .78rem; color: rgba(59,42,26,.5); white-space: nowrap; }
  .date-range strong { color: var(--brown); font-weight: 600; }

  /* ── Actions ── */
  .actions { display: flex; align-items: center; gap: 6px; }
  .act-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 8px;
    border: 1.5px solid rgba(59,42,26,.1);
    background: transparent; cursor: pointer;
    color: rgba(59,42,26,.45); text-decoration: none;
    transition: all .15s;
  }
  .act-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round; }
  .act-btn:hover { border-color: var(--teal); color: var(--teal); background: rgba(45,110,110,.06); }
  .act-btn.danger:hover { border-color: #b44444; color: #b44444; background: rgba(180,68,68,.06); }

  /* ── Pagination ── */
  .pager { padding: 14px 20px; border-top: 1.5px solid rgba(59,42,26,.06); }

  /* ── Empty ── */
  .empty { padding: 60px; text-align: center; color: rgba(59,42,26,.3); }
  .empty-icon { font-size: 36px; opacity: .25; margin-bottom: 12px; }
  .empty-title { font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: rgba(59,42,26,.4); margin-bottom: 5px; }
  .empty-sub { font-size: .82rem; }

  /* ── Toast ── */
  #copy-toast {
    position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%);
    background: rgba(45,110,110,.94); color: #fff;
    padding: 9px 22px; border-radius: 30px;
    font-size: .82rem; font-weight: 600;
    opacity: 0; pointer-events: none;
    transition: opacity .2s; z-index: 999;
    box-shadow: 0 4px 16px rgba(45,110,110,.3);
  }
  #copy-toast.show { opacity: 1; }

  @media (max-width: 900px) { .stats-strip { grid-template-columns: repeat(2,1fr); } }
  @media (max-width: 600px) { .stats-strip { grid-template-columns: 1fr 1fr; } .toolbar { flex-direction: column; align-items: stretch; } }
</style>

@php
  $total    = $promos->total();
  $active   = $promos->getCollection()->filter(fn($p) => $p->start_date <= now() && $p->end_date >= now())->count();
  $expired  = $promos->getCollection()->filter(fn($p) => $p->end_date < now())->count();
  $upcoming = $promos->getCollection()->filter(fn($p) => $p->start_date > now())->count();
@endphp

{{-- Stats Strip --}}
<div class="stats-strip">
  <div class="sstat">
    <div class="sstat-icon" style="background:rgba(45,110,110,.09);color:var(--teal)">
      <svg viewBox="0 0 24 24"><path d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path d="M6 6h.008v.008H6V6z"/></svg>
    </div>
    <div>
      <div class="sstat-label">Total Promos</div>
      <div class="sstat-val">{{ $total }}</div>
    </div>
  </div>
  <div class="sstat">
    <div class="sstat-icon" style="background:rgba(45,110,110,.09);color:#1d6060">
      <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
    </div>
    <div>
      <div class="sstat-label">Active</div>
      <div class="sstat-val">{{ $active }}</div>
    </div>
  </div>
  <div class="sstat">
    <div class="sstat-icon" style="background:rgba(212,162,84,.10);color:#9a7030">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
    </div>
    <div>
      <div class="sstat-label">Upcoming</div>
      <div class="sstat-val">{{ $upcoming }}</div>
    </div>
  </div>
  <div class="sstat">
    <div class="sstat-icon" style="background:rgba(180,68,68,.07);color:#b44444">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    </div>
    <div>
      <div class="sstat-label">Expired</div>
      <div class="sstat-val">{{ $expired }}</div>
    </div>
  </div>
</div>

{{-- Toolbar --}}
<div class="toolbar">
  <div class="toolbar-left">
    <form method="GET" action="{{ route('admin.promos.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;flex:1;">
      <div class="search-wrap">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input class="search-input" type="text" name="search" placeholder="Search title or code…" value="{{ request('search') }}">
      </div>
      <select class="filter-select" name="status" onchange="this.form.submit()">
        <option value="">All Status</option>
        <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
        <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
        <option value="expired"  {{ request('status') === 'expired'  ? 'selected' : '' }}>Expired</option>
      </select>
      @if(request('search') || request('status'))
        <a href="{{ route('admin.promos.index') }}" style="padding:9px 14px;font-size:.82rem;color:rgba(59,42,26,.45);text-decoration:none;align-self:center;">Clear</a>
      @endif
    </form>
  </div>
  <a href="{{ route('admin.promos.create') }}" class="btn-primary">
    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Promo
  </a>
</div>

{{-- Table Panel --}}
<div class="panel">
  <div class="panel-head">
    <div class="panel-title-wrap">
      <span class="panel-dot"></span>
      <span class="panel-title">Promo Codes</span>
      <span class="panel-count">{{ $promos->total() }}</span>
    </div>
  </div>

  @if($promos->isEmpty())
    <div class="empty">
      <div class="empty-icon">🏷️</div>
      <div class="empty-title">No promos found</div>
      <div class="empty-sub">Create your first promo code to get started.</div>
    </div>
  @else
  <table class="ptable">
    <thead>
      <tr>
        <th>Promo</th>
        <th>Code</th>
        <th>Discount</th>
        <th>Status</th>
        <th>Scope</th>
        <th>Date Range</th>
        <th>Trips</th>
        <th style="text-align:right">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($promos as $promo)
      @php
        $now = now();
        $status = $promo->end_date < $now ? 'expired' : ($promo->start_date > $now ? 'upcoming' : 'active');
      @endphp
      <tr>
        <td>
          <div class="promo-name">{{ $promo->title }}</div>
          @if($promo->description)
            <div class="promo-desc-cell">{{ Str::limit($promo->description, 50) }}</div>
          @endif
        </td>
        <td>
          <span class="code-badge" onclick="copyCode('{{ $promo->promo_code }}')">
            {{ $promo->promo_code }}
            <svg viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
          </span>
        </td>
        <td>
          <span class="discount-badge">
            {{ $promo->discount_type === 'percentage' ? $promo->discount_value . '%' : '₱' . number_format($promo->discount_value, 2) }}
          </span>
        </td>
        <td><span class="pill pill-{{ $status }}">{{ ucfirst($status) }}</span></td>
        <td>
          @if($promo->applies_to_all)
            <span class="scope-badge">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
              All Trips
            </span>
          @else
            <span class="scope-badge">
              <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
              Selected
            </span>
          @endif
        </td>
        <td>
          <div class="date-range">
            <strong>{{ $promo->start_date->format('M d') }}</strong> – <strong>{{ $promo->end_date->format('M d, Y') }}</strong>
          </div>
        </td>
        <td style="text-align:center;font-weight:700;color:var(--teal);">
          {{ $promo->trips_count ?? 0 }}
        </td>
        <td>
          <div class="actions" style="justify-content:flex-end">
            <a href="{{ route('admin.promos.show', $promo) }}" class="act-btn" title="View">
              <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </a>
            <a href="{{ route('admin.promos.edit', $promo) }}" class="act-btn" title="Edit">
              <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
            </a>
            <form method="POST" action="{{ route('admin.promos.destroy', $promo) }}" onsubmit="return confirm('Delete promo «{{ $promo->title }}»?')">
              @csrf @method('DELETE')
              <button type="submit" class="act-btn danger" title="Delete">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
              </button>
            </form>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @if($promos->hasPages())
    <div class="pager">{{ $promos->links() }}</div>
  @endif
  @endif
</div>

{{-- Copy toast --}}
<div id="copy-toast">✓ Code copied!</div>

<script>
function copyCode(code) {
  navigator.clipboard.writeText(code).then(() => {
    const t = document.getElementById('copy-toast');
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2000);
  });
}
</script>
@endsection