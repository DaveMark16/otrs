@extends('layouts.user')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #1a1b1b;
        border: 1px solid #2a2b2b;
        border-radius: 16px;
        padding: 20px;
        transition: 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #FF6044;
    }
    .stat-label {
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: bold;
        color: #fff;
    }
    .stat-sub {
        font-size: 11px;
        color: #555;
        margin-top: 5px;
    }
    .page-header {
        margin-bottom: 20px;
    }
    .page-title {
        font-size: 24px;
        font-weight: bold;
        color: #fff;
    }
    .table-container {
        background: #1a1b1b;
        border: 1px solid #2a2b2b;
        border-radius: 16px;
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        background: #141515;
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 600;
        color: #888;
        text-transform: uppercase;
        border-bottom: 1px solid #2a2b2b;
    }
    td {
        padding: 12px 16px;
        border-bottom: 1px solid #1e1f1f;
        color: #ccc;
        font-size: 13px;
    }
    tr:hover td {
        background: #1e1f1f;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 40px;
        font-size: 11px;
        font-weight: 500;
    }
    .status-issued {
        background: rgba(76,175,129,0.15);
        color: #4caf81;
    }
    .status-used {
        background: rgba(55,138,221,0.15);
        color: #378add;
    }
    .status-cancelled {
        background: rgba(226,75,74,0.15);
        color: #e24b4a;
    }
    .empty-state {
        text-align: center;
        padding: 60px;
        color: #888;
    }
    .pagination {
        padding: 15px;
        border-top: 1px solid #2a2b2b;
        display: flex;
        justify-content: center;
    }
    .action-link {
        color: #FF6044;
        text-decoration: none;
        margin-right: 10px;
    }
    .action-link:hover {
        text-decoration: underline;
    }
    .cancel-link {
        color: #e24b4a;
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 13px;
    }
    .cancel-link:hover {
        text-decoration: underline;
    }
</style>

<div class="max-w-7xl mx-auto">
    <div class="page-header">
        <h1 class="page-title">Ticket History</h1>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Tickets</div>
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-sub">All time</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Tickets</div>
            <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
            <div class="stat-sub">Valid for travel</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Used Tickets</div>
            <div class="stat-value">{{ $stats['used'] ?? 0 }}</div>
            <div class="stat-sub">Already travelled</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Cancelled</div>
            <div class="stat-value">{{ $stats['cancelled'] ?? 0 }}</div>
            <div class="stat-sub">Refunded / void</div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="table-container">
        @if($tickets->count() > 0)
        <table>
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
                <tr>
                    <td>{{ $ticket->ticket_no ?? '—' }}</td>
                    <td>{{ $ticket->passenger_name ?? $ticket->booking->user->name ?? '—' }}</td>
                    <td>
                        <div style="color:#ccc;font-weight:500">
                            {{ $ticket->booking->schedule->trip->origin ?? '?' }}
                            @if($ticket->booking->schedule->trip->origin_country ?? null)
                                <span style="color:#FF6044;font-size:10px">, {{ $ticket->booking->schedule->trip->origin_country }}</span>
                            @endif
                            →
                            {{ $ticket->booking->schedule->trip->destination ?? '?' }}
                            @if($ticket->booking->schedule->trip->destination_country ?? null)
                                <span style="color:#FF6044;font-size:10px">, {{ $ticket->booking->schedule->trip->destination_country }}</span>
                            @endif
                        </div>
                    </td>
                    <td>{{ $ticket->booking->schedule->departure_at ? $ticket->booking->schedule->departure_at->format('M d, Y h:i A') : '—' }}</td>
                    <td>{{ $ticket->seat_no ?? '—' }}</td>
                    <td>{{ ucfirst($ticket->fare_class) }}</td>
                    <td>
                        <span class="status-badge status-{{ $ticket->status }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </td>
                    <td>{{ $ticket->issued_at ? $ticket->issued_at->format('M d, Y') : '—' }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a href="#" class="action-link">View</a>
                            @if($ticket->status === 'issued')
                                <form method="POST" action="{{ route('tickets.cancel', $ticket) }}" style="display:inline" onsubmit="return confirm('Cancel this ticket? This action cannot be undone.')">
                                    @csrf
                                    <button type="submit" class="cancel-link">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $tickets->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-ticket-alt" style="font-size: 48px; opacity: 0.3; margin-bottom: 10px; display: block;"></i>
            <p>No tickets found. Complete a booking to generate a ticket.</p>
        </div>
        @endif
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection