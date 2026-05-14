<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    /**
     * Step 1 — Browse all trips with their upcoming schedules.
     * Admin picks a schedule to book.
     */
    public function bookTrip(Request $request)
    {
        $query = Trip::with(['schedules' => function ($q) {
            $q->where('status', 'scheduled')
              ->where('departure_at', '>=', now())
              ->orderBy('departure_at');
        }])->where('status', 'active');

        if ($s = $request->search) {
            $query->where(function ($q) use ($s) {
                $q->where('origin_country', 'like', "%{$s}%")
                  ->orWhere('destination_country', 'like', "%{$s}%")
                  ->orWhere('operator', 'like', "%{$s}%");
            });
        }

        if ($type = $request->type) {
            $query->where('type', $type);
        }

        $trips = $query->orderBy('origin_country')->paginate(12)->withQueryString();

        return view('admin.bookings.book-trip', compact('trips'));
    }

    /**
     * Step 2 — Show the booking form for a specific schedule.
     * Admin selects a user and fills in passenger details.
     */
    public function bookTripForm(Schedule $schedule)
    {
        $schedule->load('trip');
        $users = User::whereNotIn('role', ['admin', 'superadmin'])
                     ->where('status', 'active')
                     ->orderBy('name')
                     ->get(['id', 'name', 'email']);

        return view('admin.bookings.book-trip-form', compact('schedule', 'users'));
    }

    /**
     * Step 3 — Create the booking on behalf of the selected user.
     */
    public function bookTripStore(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'passenger_count' => 'required|integer|min:1|max:' . $schedule->available_seats,
            'contact_email'   => 'required|email',
        ], [
            'passenger_count.max' => "Only {$schedule->available_seats} seat(s) available.",
        ]);

        if ($schedule->available_seats < $validated['passenger_count']) {
            return back()->withErrors(['passenger_count' => 'Not enough seats available.'])->withInput();
        }

        $totalAmount = $schedule->base_fare * $validated['passenger_count'];

        $booking = Booking::create([
            'user_id'         => $validated['user_id'],
            'schedule_id'     => $schedule->id,
            'status'          => 'confirmed',   // Admin-created bookings are pre-approved
            'original_amount' => $totalAmount,
            'discount_amount' => 0,
            'total_amount'    => $totalAmount,
            'passenger_count' => $validated['passenger_count'],
            'contact_email'   => $validated['contact_email'],
            'expires_at'      => now()->addHours(24),
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', "Booking {$booking->reference_no} created and confirmed. The user can now proceed to payment.");
    }

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
        $booking->update(['status' => 'rejected']);
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
            'status' => 'required|in:pending,confirmed,cancelled,expired,ticketed,rejected',
        ]);

        $newStatus = $request->status;
        $booking->update(['status' => $newStatus]);

        if ($newStatus === 'ticketed' && $booking->tickets()->count() === 0) {
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