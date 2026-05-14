<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Redirect admins to their own panel — they should not see the user dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $totalBookings = Booking::where('user_id', $user->id)->count();

        $activeTickets = Ticket::whereHas('booking', fn($q) => $q->where('user_id', $user->id))
                        ->where('status', 'issued')->count();

        $pendingPayments = Booking::where('user_id', $user->id)
                            ->where('status', 'pending')->count();

        $totalSpent = Booking::where('user_id', $user->id)
                      ->where('status', 'confirmed')->sum('total_amount');

        $recentBookings = Booking::with(['schedule.trip'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $upcomingTrips = Booking::with(['schedule.trip'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'ticketed'])
            ->whereHas('schedule', fn($q) => $q->where('departure_at', '>=', now()))
            ->orderBy(
                Schedule::select('departure_at')
                    ->whereColumn('schedules.id', 'bookings.schedule_id')
            )
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBookings',
            'activeTickets',
            'pendingPayments',
            'totalSpent',
            'recentBookings',
            'upcomingTrips'
        ));
    }
}
