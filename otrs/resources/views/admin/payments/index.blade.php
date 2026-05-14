@extends('admin.layouts.app')
@section('page-title', 'Payment Management')

@section('content')
<style>
  .stats-row { display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px; }
  .stat-card { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:20px 22px;position:relative;overflow:hidden;box-shadow:0 2px 12px rgba(59,42,26,.05);transition:transform .2s,box-shadow .2s; }
  .stat-card:hover { transform:translateY(-3px);box-shadow:0 10px 28px rgba(59,42,26,.10); }
  .stat-card::before { content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--ac,var(--teal)); }
  .stat-label { font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:8px; }
  .stat-val { font-family:var(--ff-head);font-size:2rem;font-weight:900;color:var(--brown);line-height:1; }
  .stat-sub { font-size:.72rem;color:rgba(59,42,26,.35);margin-top:5px; }

  .page-header { display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:10px; }
  .page-title { font-family:var(--ff-head);font-size:1.4rem;font-weight:900;color:var(--brown); }
  .page-sub { font-size:.8rem;color:rgba(59,42,26,.4);margin-top:3px; }

  .filters-bar { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:16px 18px;display:flex;gap:10px;margin-bottom:18px;align-items:center;flex-wrap:wrap;box-shadow:0 2px 10px rgba(59,42,26,.04); }
  .filters-bar input,.filters-bar select { background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:50px;padding:8px 16px;font-size:.84rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s; }
  .filters-bar input { flex:1;min-width:220px; }
  .filters-bar input:focus,.filters-bar select:focus { border-color:var(--teal); }
  .filters-bar input::placeholder { color:rgba(59,42,26,.3); }
  .filter-btn { background:var(--teal);border:none;border-radius:50px;padding:8px 22px;font-size:.84rem;font-weight:600;color:var(--white);cursor:pointer;font-family:var(--ff-body);transition:background .18s; }
  .filter-btn:hover { background:var(--teal-lt); }
  .clear-link { color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;padding:7px 14px;border:1.5px solid rgba(59,42,26,.12);border-radius:50px;transition:all .15s; }
  .clear-link:hover { color:var(--brown);border-color:rgba(59,42,26,.28); }

  .table-wrap { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 16px rgba(59,42,26,.06); }
  table { width:100%;border-collapse:collapse; }
  thead th { padding:12px 16px;text-align:left;font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);border-bottom:1.5px solid rgba(59,42,26,.07);background:var(--sand);white-space:nowrap; }
  tbody tr { border-bottom:1px solid rgba(59,42,26,.06);transition:background .1s; }
  tbody tr:last-child { border-bottom:none; }
  tbody tr:hover { background:rgba(245,237,224,.45); }
  tbody td { padding:12px 16px;font-size:.83rem;color:rgba(59,42,26,.55);vertical-align:middle; }

  .pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:700; }
  .pill-green { background:rgba(45,110,110,.1);color:var(--teal); }
  .pill-amber { background:rgba(212,162,84,.14);color:#9a7030; }
  .pill-red   { background:rgba(180,60,60,.08);color:#b44444; }
  .pill-blue  { background:rgba(45,110,110,.08);color:var(--teal); }
  .pill-gray  { background:rgba(59,42,26,.07);color:rgba(59,42,26,.45); }

  .ref-badge { font-family:monospace;font-size:.73rem;font-weight:700;color:var(--teal); }

  .user-av { width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--tan));display:flex;align-items:center;justify-content:center;font-family:var(--ff-head);font-size:.72rem;font-weight:700;color:var(--brown);flex-shrink:0; }
  .user-chip { display:flex;align-items:center;gap:9px; }

  .act-btn { padding:5px 13px;border-radius:50px;font-size:.75rem;font-weight:600;cursor:pointer;border:1.5px solid;background:transparent;text-decoration:none;transition:all .15s;font-family:var(--ff-body);display:inline-flex;align-items:center;gap:4px;white-space:nowrap; }
  .act-verify { color:var(--teal);border-color:rgba(45,110,110,.3); }
  .act-verify:hover { background:rgba(45,110,110,.08); }

  .status-mini { background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:8px;padding:4px 10px;font-size:.75rem;font-family:var(--ff-body);color:var(--brown);outline:none;cursor:pointer;transition:border-color .2s; }
  .status-mini:focus { border-color:var(--teal); }

  .pag-wrap { padding:14px 18px;border-top:1.5px solid rgba(59,42,26,.07);display:flex;align-items:center;flex-wrap:wrap;gap:12px; }
  .pag-info { flex:1;font-size:.77rem;color:rgba(59,42,26,.35); }

  @media(max-width:768px){ .stats-row { grid-template-columns:repeat(2,1fr); } }
</style>

<div class="page-header">
  <div>
    <div class="page-title">Payment Management</div>
    <div class="page-sub">Verify and track all payment transactions</div>
  </div>
</div>

{{-- Stats --}}
<div class="stats-row">
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-label">Total Paid</div>
    <div class="stat-val" style="font-size:1.5rem;">&#8369;{{ number_format($stats['total_paid'],0) }}</div>
    <div class="stat-sub">Verified payments</div>
  </div>
  <div class="stat-card" style="--ac:#a07830">
    <div class="stat-label">Pending</div>
    <div class="stat-val">{{ $stats['pending'] }}</div>
    <div class="stat-sub">Awaiting verification</div>
  </div>
  <div class="stat-card" style="--ac:#b44444">
    <div class="stat-label">Failed</div>
    <div class="stat-val">{{ $stats['failed'] }}</div>
    <div class="stat-sub">Failed transactions</div>
  </div>
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-label">Refunded</div>
    <div class="stat-val" style="font-size:1.5rem;">&#8369;{{ number_format($stats['refunded'],0) }}</div>
    <div class="stat-sub">Total refunds issued</div>
  </div>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.payments.index') }}">
  <div class="filters-bar">
    <input type="text" name="search" placeholder="Search by ref no or passenger…" value="{{ request('search') }}">
    <select name="status">
      <option value="">All Status</option>
      <option value="pending"  {{ request('status')==='pending'?'selected':'' }}>Pending</option>
      <option value="paid"     {{ request('status')==='paid'?'selected':'' }}>Paid</option>
      <option value="failed"   {{ request('status')==='failed'?'selected':'' }}>Failed</option>
      <option value="refunded" {{ request('status')==='refunded'?'selected':'' }}>Refunded</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
    @if(request()->hasAny(['search','status']))
      <a href="{{ route('admin.payments.index') }}" class="clear-link">Clear</a>
    @endif
  </div>
</form>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>Booking Ref</th>
        <th>Passenger</th>
        <th>Route</th>
        <th>Method</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Transaction Ref</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($payments as $payment)
      <tr>
        <td><span class="ref-badge">{{ $payment->booking->reference_no ?? '—' }}</span></td>
        <td>
          <div class="user-chip">
            <div class="user-av">{{ strtoupper(substr($payment->booking->user->name ?? 'U', 0, 2)) }}</div>
            <div>
              <div style="font-weight:600;color:var(--brown);font-size:.83rem;">{{ $payment->booking->user->name ?? '—' }}</div>
              <div style="font-size:.71rem;color:rgba(59,42,26,.35);">{{ $payment->booking->user->email ?? '' }}</div>
            </div>
          </div>
        </td>
        <td style="font-size:.79rem;">
          {{ $payment->booking->schedule->trip->origin ?? '?' }} →
          {{ $payment->booking->schedule->trip->destination ?? '?' }}
        </td>
        <td>{{ ucfirst($payment->method ?? '—') }}</td>
        <td style="font-family:monospace;font-weight:700;color:var(--gold);">&#8369;{{ number_format($payment->amount,2) }}</td>
        <td>
          @php $ps = $payment->status; @endphp
          <span class="pill {{ $ps==='paid'?'pill-green':($ps==='pending'?'pill-amber':($ps==='refunded'?'pill-blue':'pill-red')) }}">
            {{ ucfirst($ps) }}
          </span>
        </td>
        <td style="font-family:monospace;font-size:.72rem;color:rgba(59,42,26,.35);">{{ $payment->transaction_ref ?? '—' }}</td>
        <td style="font-size:.75rem;color:rgba(59,42,26,.35);">{{ $payment->created_at->format('M d, Y') }}</td>
        <td>
          <div style="display:flex;gap:5px;align-items:center;flex-wrap:wrap;">
            @if($payment->status === 'pending')
            <form method="POST" action="{{ route('admin.payments.verify',$payment) }}"
                  onsubmit="return confirm('Verify this payment and confirm the booking?')" style="display:inline">
              @csrf @method('PATCH')
              <button class="act-btn act-verify">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Verify
              </button>
            </form>
            @endif
            <form method="POST" action="{{ route('admin.payments.status',$payment) }}" style="display:inline">
              @csrf @method('PATCH')
              <select name="status" class="status-mini" onchange="this.form.submit()">
                @foreach(['pending','paid','failed','refunded'] as $opt)
                  <option value="{{ $opt }}" {{ $payment->status===$opt?'selected':'' }}>{{ ucfirst($opt) }}</option>
                @endforeach
              </select>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="9" style="text-align:center;padding:52px;color:rgba(59,42,26,.3);font-size:.88rem;">No payments found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <div class="pag-wrap">
    <span class="pag-info">Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }} payments</span>
    {{ $payments->links() }}
  </div>
</div>
@endsection