@extends('admin.layouts.app')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #1a1b1b;
        border: 1px solid #2a2b2b;
        border-radius: 8px;
        padding: 15px;
    }
    .stat-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
    }
    .stat-val {
        font-size: 28px;
        font-weight: bold;
        color: #fff;
    }
    .table-wrap {
        background: #1a1b1b;
        border: 1px solid #2a2b2b;
        border-radius: 8px;
        padding: 15px;
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #2a2b2b;
    }
    .pill {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
    }
    .pill-amber {
        background: rgba(239,159,39,0.2);
        color: #ef9f27;
    }
    .pill-green {
        background: rgba(76,175,129,0.2);
        color: #4caf81;
    }
    .pill-red {
        background: rgba(226,75,74,0.2);
        color: #e24b4a;
    }
    a {
        color: #FF6044;
        text-decoration: none;
    }
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }
    .action-card {
        background: #1a1b1b;
        border: 1px solid #2a2b2b;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        text-decoration: none;
        transition: 0.2s;
    }
    .action-card:hover {
        border-color: #FF6044;
        transform: translateY(-2px);
    }
    .action-card i {
        font-size: 24px;
        color: #FF6044;
        margin-bottom: 8px;
        display: inline-block;
    }
    .action-card span {
        display: block;
        color: #ccc;
        font-size: 13px;
        font-weight: 500;
    }
</style>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Users</div>
        <div class="stat-val">{{ $stats['total_users'] ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Bookings</div>
        <div class="stat-val">{{ $stats['total_bookings'] ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-val">{{ $stats['pending'] ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Confirmed</div>
        <div class="stat-val">{{ $stats['confirmed'] ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Cancelled</div>
        <div class="stat-val">{{ $stats['cancelled'] ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Revenue</div>
        <div class="stat-val">₱{{ number_format($stats['total_revenue'] ?? 0, 2) }}</div>
    </div>
</div>

<div class="table-wrap">
    <h3>Recent Bookings</h3>
    @if(isset($recent_bookings) && $recent_bookings->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Ref No</th>
                <th>Passenger</th>
                <th>Route</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recent_bookings as $booking)
            <tr>
                <td>{{ $booking->reference_no }}</td>
                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                <td>{{ $booking->schedule->trip->origin ?? '?' }} → {{ $booking->schedule->trip->destination ?? '?' }}</td>
                <td>₱{{ number_format($booking->total_amount, 2) }}</td>
                <td>
                    <span class="pill 
                        @if($booking->status == 'pending') pill-amber
                        @elseif($booking->status == 'confirmed') pill-green
                        @else pill-red
                        @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>
                <td><a href="{{ route('admin.bookings.show', $booking) }}">View</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>No recent bookings.</p>
    @endif
</div>

<div class="quick-actions">
    <a href="{{ route('admin.bookings.index') }}" class="action-card">
        <i class="fas fa-ticket-alt"></i>
        <span>Manage Bookings</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="action-card">
        <i class="fas fa-users"></i>
        <span>Manage Users</span>
    </a>
    <a href="{{ route('admin.payments.index') }}" class="action-card">
        <i class="fas fa-credit-card"></i>
        <span>Payments</span>
    </a>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection