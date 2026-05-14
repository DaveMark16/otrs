@extends('admin.layouts.app')
@section('page-title', 'User Management')

@section('content')
<style>
  .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 24px; }
  .stat-card {
    background: var(--white); border: 1.5px solid rgba(59,42,26,.08);
    border-radius: var(--radius); padding: 20px 22px;
    position: relative; overflow: hidden;
    box-shadow: 0 2px 12px rgba(59,42,26,.05);
    transition: transform .2s, box-shadow .2s;
  }
  .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(59,42,26,.10); }
  .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background: var(--ac, var(--teal)); }
  .stat-label { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(59,42,26,.38); margin-bottom: 8px; }
  .stat-val { font-family: var(--ff-head); font-size: 2.2rem; font-weight: 900; color: var(--brown); line-height: 1; }

  /* Filters */
  .filters-bar {
    background: var(--white); border: 1.5px solid rgba(59,42,26,.08);
    border-radius: var(--radius); padding: 16px 18px;
    display: flex; gap: 10px; margin-bottom: 18px;
    flex-wrap: wrap; align-items: center;
    box-shadow: 0 2px 10px rgba(59,42,26,.04);
  }
  .filters-bar input, .filters-bar select {
    background: var(--cream); border: 1.5px solid rgba(59,42,26,.12);
    border-radius: 50px; padding: 8px 16px;
    font-size: .84rem; font-family: var(--ff-body);
    color: var(--brown); outline: none; min-width: 180px;
    transition: border-color .2s;
  }
  .filters-bar input:focus, .filters-bar select:focus { border-color: var(--teal); }
  .filters-bar input::placeholder { color: rgba(59,42,26,.3); }
  .filter-btn {
    background: var(--teal); border: none; border-radius: 50px;
    padding: 8px 22px; font-size: .84rem; font-weight: 600;
    color: var(--white); cursor: pointer; font-family: var(--ff-body);
    transition: background .18s; white-space: nowrap;
  }
  .filter-btn:hover { background: var(--teal-lt); }
  .clear-link { color: rgba(59,42,26,.4); text-decoration: none; font-size: .82rem; padding: 7px 14px; border: 1.5px solid rgba(59,42,26,.12); border-radius: 50px; transition: all .15s; }
  .clear-link:hover { color: var(--brown); border-color: rgba(59,42,26,.28); }

  /* Table */
  .table-wrap {
    background: var(--white); border: 1.5px solid rgba(59,42,26,.08);
    border-radius: var(--radius); overflow: hidden;
    box-shadow: 0 2px 16px rgba(59,42,26,.06);
  }
  table { width: 100%; border-collapse: collapse; }
  thead th {
    padding: 12px 16px; text-align: left;
    font-size: .68rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: rgba(59,42,26,.38);
    border-bottom: 1.5px solid rgba(59,42,26,.07);
    background: var(--sand); white-space: nowrap;
  }
  tbody tr { border-bottom: 1px solid rgba(59,42,26,.06); transition: background .1s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(245,237,224,.45); }
  tbody td { padding: 12px 16px; font-size: .83rem; color: rgba(59,42,26,.55); vertical-align: middle; }

  /* Pill */
  .pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; }
  .pill-green { background: rgba(45,110,110,.1);  color: var(--teal); }
  .pill-red   { background: rgba(180,60,60,.08);  color: #b44444; }
  .pill-amber { background: rgba(212,162,84,.14); color: #9a7030; }
  .pill-gray  { background: rgba(59,42,26,.07);   color: rgba(59,42,26,.45); }

  /* Avatar */
  .user-av {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold), var(--tan));
    display: flex; align-items: center; justify-content: center;
    font-family: var(--ff-head); font-size: .75rem; font-weight: 700;
    color: var(--brown); flex-shrink: 0;
  }

  /* Role badge — read-only, replaces the old role-select dropdown */
  .role-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(45,110,110,.07);
    border: 1px solid rgba(45,110,110,.18);
    border-radius: 20px; padding: 3px 10px;
    font-size: .72rem; font-weight: 700;
    color: var(--teal); white-space: nowrap;
    letter-spacing: .02em;
  }
  .role-badge svg { width: 10px; height: 10px; stroke: currentColor; fill: none; stroke-width: 2; opacity: .7; }

  /* Action buttons */
  .act-btn {
    padding: 5px 12px; border-radius: 50px;
    font-size: .75rem; font-weight: 600;
    cursor: pointer; border: 1.5px solid;
    background: transparent; text-decoration: none;
    transition: all .15s; display: inline-flex; align-items: center; gap: 4px;
    font-family: var(--ff-body); white-space: nowrap;
  }
  .act-edit   { color: var(--teal);  border-color: rgba(45,110,110,.3); }
  .act-edit:hover { background: rgba(45,110,110,.08); }
  .act-deact  { color: #9a7030; border-color: rgba(160,120,48,.3); }
  .act-deact:hover { background: rgba(160,120,48,.08); }
  .act-activ  { color: var(--teal); border-color: rgba(45,110,110,.3); }
  .act-activ:hover { background: rgba(45,110,110,.08); }
  .act-delete { color: #b44444; border-color: rgba(180,68,68,.25); }
  .act-delete:hover { background: rgba(180,68,68,.08); }

  .pagination-wrap { padding: 14px 18px; border-top: 1.5px solid rgba(59,42,26,.07); display: flex; justify-content: center; }

  @media (max-width: 768px) { .stats-row { grid-template-columns: repeat(2,1fr); } }
</style>

{{-- Stats --}}
<div class="stats-row">
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-label">Total Users</div>
    <div class="stat-val">{{ $stats['total'] }}</div>
  </div>
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-label">Active</div>
    <div class="stat-val">{{ $stats['active'] }}</div>
  </div>
  <div class="stat-card" style="--ac:#b44444">
    <div class="stat-label">Inactive</div>
    <div class="stat-val">{{ $stats['inactive'] }}</div>
  </div>
  <div class="stat-card" style="--ac:var(--gold)">
    <div class="stat-label">Admins</div>
    <div class="stat-val">{{ $stats['admins'] }}</div>
  </div>
</div>



{{-- Table --}}
<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Status</th>
        <th>Joined</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
      <tr>
        <td style="color:rgba(59,42,26,.3);font-size:.75rem;">{{ $user->id }}</td>
        <td>
          <div style="display:flex;align-items:center;gap:10px;">
            <div class="user-av">{{ strtoupper(substr($user->name,0,2)) }}</div>
            <span style="font-weight:600;color:var(--brown);">{{ $user->name }}</span>
          </div>
        </td>
        <td style="font-family:monospace;font-size:.76rem;">{{ $user->email }}</td>
        <td>{{ $user->phone ?? '—' }}</td>
        <td>
          {{-- Role is read-only — set at registration, cannot be changed --}}
          <span class="role-badge">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            {{ ucfirst($user->role) }}
          </span>
        </td>
        <td>
          <span class="pill {{ $user->status==='active'?'pill-green':'pill-red' }}">
            {{ ucfirst($user->status ?? 'active') }}
          </span>
        </td>
        <td style="font-size:.75rem;color:rgba(59,42,26,.38);">{{ $user->created_at->format('M d, Y') }}</td>
        <td>
          <div style="display:flex;gap:5px;flex-wrap:wrap;align-items:center;">
            <a href="{{ route('admin.users.edit',$user) }}" class="act-btn act-edit">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              Edit
            </a>
            <form method="POST" action="{{ route('admin.users.toggle',$user) }}" style="display:inline">
              @csrf @method('PATCH')
              @if($user->status === 'active')
                <button type="submit" class="act-btn act-deact">Deactivate</button>
              @else
                <button type="submit" class="act-btn act-activ">Activate</button>
              @endif
            </form>
            @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy',$user) }}" style="display:inline"
                  onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.')">
              @csrf @method('DELETE')
              <button class="act-btn act-delete">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
              </button>
            </form>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" style="text-align:center;padding:48px;color:rgba(59,42,26,.3);font-size:.88rem;">No users found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <div class="pagination-wrap">
    {{ $users->appends(request()->query())->links() }}
  </div>
</div>
@endsection