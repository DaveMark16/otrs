<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $payments = Payment::with(['booking.schedule.trip'])
            ->whereHas('booking', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        $stats = [
            'total_paid' => Payment::whereHas('booking', fn($q) => $q->where('user_id', $user->id))
                            ->where('status', 'paid')->sum('amount'),
            'pending'    => Payment::whereHas('booking', fn($q) => $q->where('user_id', $user->id))
                            ->where('status', 'pending')->count(),
            'failed'     => Payment::whereHas('booking', fn($q) => $q->where('user_id', $user->id))
                            ->where('status', 'failed')->count(),
            'refunded'   => Payment::whereHas('booking', fn($q) => $q->where('user_id', $user->id))
                            ->where('status', 'refunded')->sum('amount'),
        ];

        return view('payments.index', compact('payments', 'stats'));
    }

    public function show(Payment $payment)
    {
        if ($payment->booking->user_id !== auth()->id()) {
            abort(403);
        }
        $payment->load(['booking.schedule.trip', 'booking.user', 'booking.tickets']);
        return view('payments.show', compact('payment'));
    }

    public function refund(Request $request, Payment $payment)
    {
        // Only the payment owner can request refund
        if ($payment->booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Only paid payments can be refunded
        if ($payment->status !== 'paid') {
            return back()->with('error', 'Only completed payments can be refunded.');
        }

        $request->validate([
            'refund_reason' => 'required|string|min:10|max:500',
        ]);

        // Process refund
        $payment->update([
            'status'        => 'refunded',
            'refund_date'   => now(),
            'refund_reason' => $request->refund_reason,
            'refund_ref'    => 'REF-' . strtoupper(uniqid()),
        ]);

        // Cancel the associated booking and tickets
        $booking = $payment->booking;
        $booking->update(['status' => 'cancelled']);
        $booking->tickets()->update(['status' => 'cancelled']);

        // Restore available seats
        if ($booking->schedule) {
            $booking->schedule->increment('available_seats', $booking->passenger_count);
        }

        return redirect()->route('payments.index')
            ->with('success', 'Refund processed successfully. Reference: ' . $payment->refund_ref);
    }
}