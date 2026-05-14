<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total_users'    => User::count(),
            'admins'         => User::where('role', 'admin')->orWhere('role', 'superadmin')->count(),
            'total_bookings' => Booking::count(),
            'pending'        => Booking::where('status', 'pending')->count(),
            'confirmed'      => Booking::where('status', 'confirmed')->count(),
            'cancelled'      => Booking::where('status', 'cancelled')->count(),
            'total_trips'    => Trip::count(),
            'total_revenue'  => Booking::where('status', 'confirmed')->sum('total_amount'),
            'paid_payments'  => Payment::where('status', 'paid')->sum('amount'),
        ];

        $recent_bookings = Booking::with(['user', 'schedule.trip'])
            ->latest()
            ->take(8)
            ->get();

        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'recent_users'));
    }
}
