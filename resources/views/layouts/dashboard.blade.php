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
    .row2 {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }
    .panel {
        background: #1a1b1b;
        border: 1px solid #2a2b2b;
        border-radius: 16px;
        padding: 20px;
    }
    .panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .panel-title {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
    }
    .panel-link {
        font-size: 12px;
        color: #FF6044;
        text-decoration: none;
    }
    .booking-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #2a2b2b;
    }
    .booking-item:last-child {
        border-bottom: none;
    }
    .booking-route {
        font-weight: 500;
        color: #ccc;
    }
    .booking-date {
        font-size: 11px;
        color: #888;
    }
    .booking-status {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 12px;
        background: rgba(76,175,129,0.15);
        color: #4caf81;
    }
    .quick-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .quick-btn {
        background: #222;
        border: 1px solid #2a2b2b;
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        text-decoration: none;
        transition: 0.2s;
    }
    .quick-btn:hover {
        border-color: #FF6044;
    }
    .quick-label {
        font-size: 11px;
        color: #888;
        margin-top: 5px;
    }
    .upcoming-item {
        padding: 10px 0;
        border-bottom: 1px solid #2a2b2b;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .upcoming-item:last-child {
        border-bottom: none;
    }
    .upcoming-route {
        font-weight: 500;
        color: #ccc;
    }
    .upcoming-date {
        font-size: 11px;
        color: #888;
    }
    .upcoming-badge {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 12px;
        background: rgba(76,175,129,0.15);
        color: #4caf81;
    }
    .empty-text {
        text-align: center;
        padding: 20px;
        color: #888;
    }
</style>

<div class="max-w-7xl mx-auto">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Bookings</div>
            <div class="stat-value">{{ $totalBookings }}</div>
            <div class="stat-sub">+3 this month</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Tickets</div>
            <div class="stat-value">{{ $activeTickets }}</div>
            <div class="stat-sub">{{ $upcomingTrips->count() }} upcoming</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending Payment</div>
            <div class="stat-value">{{ $pendingPayments }}</div>
            <div class="stat-sub">Expires soon</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Spent</div>
            <div class="stat-value">₱{{ number_format($totalSpent, 2) }}</div>
            <div class="stat-sub">+₱1,200 vs last month</div>
        </div>
    </div>

    <div class="row2">
        <div class="panel">
            <div class="panel-head">
                <span class="panel-title">Recent Bookings</span>
                <a href="{{ route('bookings.index') }}" class="panel-link">View all</a>
            </div>
            @forelse($recentBookings as $booking)
            <div class="booking-item">
                <div>
                    <div class="booking-route">{{ $booking->schedule->trip->origin ?? '?' }} → {{ $booking->schedule->trip->destination ?? '?' }}</div>
                    <div class="booking-date">{{ $booking->schedule->departure_at ? $booking->schedule->departure_at->format('M d, Y · h:i A') : '—' }}</div>
                </div>
                <div class="booking-status">{{ ucfirst($booking->status) }}</div>
            </div>
            @empty
            <div class="empty-text">No recent bookings.</div>
            @endforelse
        </div>

        <div class="panel">
            <div class="panel-head">
                <span class="panel-title">Quick Actions</span>
            </div>
            <div class="quick-grid">
                <a href="{{ route('schedules.index') }}" class="quick-btn">
                    <i class="fas fa-search"></i>
                    <div class="quick-label">Search Trips</div>
                </a>
                <a href="{{ route('tickets.index') }}" class="quick-btn">
                    <i class="fas fa-ticket-alt"></i>
                    <div class="quick-label">My Tickets</div>
                </a>
                <a href="#" class="quick-btn">
                    <i class="fas fa-credit-card"></i>
                    <div class="quick-label">Pay Now</div>
                </a>
                <a href="#" class="quick-btn">
                    <i class="fas fa-headset"></i>
                    <div class="quick-label">Support</div>
                </a>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <span class="panel-title">Upcoming Trips</span>
            <a href="{{ route('schedules.index') }}" class="panel-link">View schedule</a>
        </div>
        @forelse($upcomingTrips as $trip)
        <div class="upcoming-item">
            <div>
                <div class="upcoming-route">{{ $trip->schedule->trip->origin ?? '?' }} → {{ $trip->schedule->trip->destination ?? '?' }}</div>
                <div class="upcoming-date">{{ $trip->schedule->departure_at ? $trip->schedule->departure_at->format('M d, Y · h:i A') : '—' }}</div>
            </div>
            <div class="upcoming-badge">{{ ucfirst($trip->status) }}</div>
        </div>
        @empty
        <div class="empty-text">No upcoming trips.</div>
        @endforelse
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection