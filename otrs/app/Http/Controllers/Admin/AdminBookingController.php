<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query  = Booking::with(['user', 'schedule.trip']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all'       => Booking::count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'rejected'  => Booking::where('status', 'rejected')->count(),
            'expired'   => Booking::where('status', 'expired')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'counts', 'status'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'schedule.trip', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Approve: set to confirmed so the user can proceed to payment.
     * Seats are decremented and tickets are generated only after the user pays.
     */
    public function approve(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        return back()->with('success', "Booking {$booking->reference_no} has been approved. The user can now proceed to payment.");
    }

    /**
     * Reject: set to rejected (distinct from cancelled).
     * After this, Approve button is hidden; Delete remains available.
     */
    public function reject(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', "Booking {$booking->reference_no} has been rejected.");
    }

    /**
     * Manual status update — blocked if already confirmed.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        // Prevent status changes on confirmed bookings via this route
        if ($booking->status === 'confirmed') {
            return back()->with('error', 'Confirmed bookings cannot be changed via status update.');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,expired,ticketed',
        ]);

        $newStatus = $request->status;
        $booking->update(['status' => $newStatus]);

        if (in_array($newStatus, ['ticketed', 'confirmed']) && $booking->tickets()->count() === 0) {
            $booking->load(['schedule', 'user']);
            $fareClass     = $booking->schedule->fare_class ?? 'economy';
            $passengerName = $booking->user->name ?? 'Passenger';
            $count         = $booking->passenger_count ?? 1;
            for ($i = 1; $i <= $count; $i++) {
                \App\Models\Ticket::create([
                    'booking_id'     => $booking->id,
                    'ticket_no'      => 'TKT-' . strtoupper(uniqid()),
                    'passenger_name' => $passengerName . ($count > 1 ? " (Pax {$i})" : ''),
                    'seat_no'        => null,
                    'fare_class'     => $fareClass,
                    'status'         => 'issued',
                    'issued_at'      => now(),
                ]);
            }
        }

        return back()->with('success', "Booking status updated to {$newStatus}.");
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}