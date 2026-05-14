<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.schedule.trip']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('booking', function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total_paid' => Payment::where('status', 'paid')->sum('amount'),
            'pending'    => Payment::where('status', 'pending')->count(),
            'failed'     => Payment::where('status', 'failed')->count(),
            'refunded'   => Payment::where('status', 'refunded')->sum('amount'),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function verify(Payment $payment)
    {
        $payment->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);
        // Also confirm the booking
        if ($payment->booking) {
            $payment->booking->update(['status' => 'confirmed']);
        }
        return back()->with('success', 'Payment verified and booking confirmed.');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed,refunded',
        ]);
        $payment->update(['status' => $request->status]);
        return back()->with('success', "Payment status updated to {$request->status}.");
    }
}
