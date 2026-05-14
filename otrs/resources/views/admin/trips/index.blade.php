@extends('admin.layouts.app')
@section('page-title', 'Trip Management')

@section('content')
<style>
  .page-header { display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px; }
  .page-title  { font-family:var(--ff-head);font-size:1.4rem;font-weight:900;color:var(--brown); }
  .page-sub    { font-size:.8rem;color:rgba(59,42,26,.4);margin-top:3px; }

  .btn-primary { background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:10px 22px;font-size:.86rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .18s,transform .15s;box-shadow:0 4px 14px rgba(45,110,110,.25);font-family:var(--ff-body); }
  .btn-primary:hover { background:var(--teal-lt);transform:translateY(-1px); }

  /* Filters */
  .filters-bar { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:16px 18px;display:flex;gap:10px;margin-bottom:18px;align-items:center;flex-wrap:wrap;box-shadow:0 2px 10px rgba(59,42,26,.04); }
  .filters-bar input,.filters-bar select { background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:50px;padding:8px 16px;font-size:.84rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s; }
  .filters-bar input { flex:1;min-width:200px; }
  .filters-bar input:focus,.filters-bar select:focus { border-color:var(--teal); }
  .filters-bar input::placeholder { color:rgba(59,42,26,.3); }
  .filter-btn { background:var(--teal);border:none;border-radius:50px;padding:8px 22px;font-size:.84rem;font-weight:600;color:var(--white);cursor:pointer;font-family:var(--ff-body);transition:background .18s;white-space:nowrap; }
  .filter-btn:hover { background:var(--teal-lt); }
  .clear-link { color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;padding:7px 14px;border:1.5px solid rgba(59,42,26,.12);border-radius:50px;transition:all .15s;white-space:nowrap; }
  .clear-link:hover { color:var(--brown);border-color:rgba(59,42,26,.28); }

  /* Flash */
  .flash-success { background:rgba(45,110,110,.06);border:1.5px solid rgba(45,110,110,.2);border-radius:var(--radius-sm);padding:12px 16px;color:var(--teal);font-size:.84rem;margin-bottom:18px;display:flex;align-items:center;gap:8px; }

  /* Table */
  .table-wrap { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 16px rgba(59,42,26,.06); }
  table { width:100%;border-collapse:collapse; }
  thead th { padding:12px 16px;text-align:left;font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);border-bottom:1.5px solid rgba(59,42,26,.07);background:var(--sand);white-space:nowrap; }
  thead th.center { text-align:center; }
  tbody tr { border-bottom:1px solid rgba(59,42,26,.06);transition:background .1s; }
  tbody tr:last-child { border-bottom:none; }
  tbody tr:hover { background:rgba(245,237,224,.45); }
  tbody td { padding:12px 16px;font-size:.83rem;color:rgba(59,42,26,.55);vertical-align:middle; }
  tbody td.center { text-align:center; }

  /* Pills */
  .pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:700; }
  .pill-green { background:rgba(45,110,110,.1);color:var(--teal); }
  .pill-gray  { background:rgba(59,42,26,.07);color:rgba(59,42,26,.45); }
  .pill-blue  { background:rgba(45,110,110,.08);color:var(--teal); }
  .pill-amber { background:rgba(212,162,84,.14);color:#9a7030; }
  .pill-tan   { background:rgba(196,154,108,.14);color:#8a5c2a; }

  /* Action buttons */
  .act-btn { padding:5px 13px;border-radius:50px;font-size:.75rem;font-weight:600;cursor:pointer;border:1.5px solid;background:transparent;text-decoration:none;transition:all .15s;font-family:var(--ff-body);display:inline-flex;align-items:center;gap:4px;white-space:nowrap; }
  .act-edit   { color:var(--teal);border-color:rgba(45,110,110,.3); }
  .act-edit:hover { background:rgba(45,110,110,.08); }
  .act-delete { color:#b44444;border-color:rgba(180,68,68,.25); }
  .act-delete:hover { background:rgba(180,68,68,.08); }

  .pag-wrap { padding:14px 18px;border-top:1.5px solid rgba(59,42,26,.07);display:flex;justify-content:center; }

  /* Route display */
  .route-cell { display:flex;align-items:center;gap:6px; }
  .route-origin { font-weight:600;color:var(--brown);font-size:.85rem; }
  .route-arrow  { color:rgba(59,42,26,.25);font-size:.8rem; }
  .route-dest   { font-weight:600;color:var(--teal);font-size:.85rem; }

  @media(max-width:768px){table{font-size:.75rem;}}
</style>

<div class="page-header">
  <div>
    <div class="page-title">Trip Management</div>
    <div class="page-sub">Manage country-to-country trips</div>
  </div>
  <a href="{{ route('admin.trips.create') }}" class="btn-primary">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Trip
  </a>
</div>

@if(session('success'))
  <div class="flash-success">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
  </div>
@endif

<form method="GET" action="{{ route('admin.trips.index') }}">
  <div class="filters-bar">
    <input type="text" name="search" placeholder="Search country or operator…" value="{{ request('search') }}">
    <select name="type">
      <option value="">All Types</option>
      <option value="air"  {{ request('type')==='air'  ?'selected':'' }}>Air</option>
      <option value="land" {{ request('type')==='land' ?'selected':'' }}>Land</option>
      <option value="sea"  {{ request('type')==='sea'  ?'selected':'' }}>Sea</option>
    </select>
    <select name="status">
      <option value="">All Status</option>
      <option value="active"   {{ request('status')==='active'   ?'selected':'' }}>Active</option>
      <option value="inactive" {{ request('status')==='inactive' ?'selected':'' }}>Inactive</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
    @if(request()->hasAny(['search','type','status']))
      <a href="{{ route('admin.trips.index') }}" class="clear-link">Clear</a>
    @endif
  </div>
</form>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Route</th>
        <th>Type</th>
        <th>Operator</th>
        <th class="center">Max Pax</th>
        <th class="center">Schedules</th>
        <th>Status</th>
        <th>Added</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($trips as $trip)
      <tr>
        <td style="color:rgba(59,42,26,.3);font-size:.75rem;">{{ $trip->id }}</td>
        <td>
          <div class="route-cell">
            <span class="route-origin">{{ $trip->origin_country }}</span>
            <span class="route-arrow">→</span>
            <span class="route-dest">{{ $trip->destination_country }}</span>
          </div>
        </td>
        <td>
          <span class="pill {{ $trip->type==='air'?'pill-blue':($trip->type==='sea'?'pill-amber':'pill-tan') }}">
            {{ ucfirst($trip->type) }}
          </span>
        </td>
        <td>{{ $trip->operator ?? '—' }}</td>
        <td class="center" style="font-weight:700;color:var(--brown);">{{ number_format($trip->max_passengers) }}</td>
        <td class="center" style="font-weight:700;color:var(--brown);">{{ $trip->schedules_count }}</td>
        <td>
          <span class="pill {{ $trip->status==='active'?'pill-green':'pill-gray' }}">
            {{ ucfirst($trip->status) }}
          </span>
        </td>
        <td style="font-size:.75rem;color:rgba(59,42,26,.35);">{{ $trip->created_at->format('M d, Y') }}</td>
        <td>
          <div style="display:flex;gap:5px;align-items:center;">
            <a href="{{ route('admin.trips.edit', $trip) }}" class="act-btn act-edit">Edit</a>
            <form method="POST" action="{{ route('admin.trips.destroy', $trip) }}"
                  onsubmit="return confirm('Delete this trip and all its schedules?')">
              @csrf @method('DELETE')
              <button type="submit" class="act-btn act-delete">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9" style="text-align:center;padding:52px;color:rgba(59,42,26,.3);font-size:.88rem;">
          No trips found.
          <a href="{{ route('admin.trips.create') }}" style="color:var(--teal);text-decoration:none;margin-left:4px;font-weight:600;">Add one →</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  @if($trips->hasPages())
    <div class="pag-wrap">{{ $trips->appends(request()->query())->links() }}</div>
  @endif
</div>
@endsection