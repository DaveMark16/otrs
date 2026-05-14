<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tickets = Ticket::with(['booking.schedule.trip'])
            ->whereHas('booking', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        $stats = [
            'total'     => Ticket::whereHas('booking', fn($q) => $q->where('user_id', $user->id))->count(),
            'active'    => Ticket::whereHas('booking', fn($q) => $q->where('user_id', $user->id))
                            ->where('status', 'issued')->count(),
            'used'      => Ticket::whereHas('booking', fn($q) => $q->where('user_id', $user->id))
                            ->where('status', 'used')->count(),
            'cancelled' => Ticket::whereHas('booking', fn($q) => $q->where('user_id', $user->id))
                            ->where('status', 'cancelled')->count(),
        ];

        return view('tickets.index', compact('tickets', 'stats'));
    }

    public function cancel(Ticket $ticket)
    {
        // Only allow the ticket owner to cancel
        if ($ticket->booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancellation if status is 'issued'
        if ($ticket->status !== 'issued') {
            return back()->with('error', 'This ticket cannot be cancelled.');
        }

        // Update ticket status
        $ticket->update(['status' => 'cancelled']);

        // Also update the related booking status
        $ticket->booking->update(['status' => 'cancelled']);

        // Optionally restore available seats
        if ($ticket->booking->schedule) {
            $ticket->booking->schedule->increment('available_seats', $ticket->booking->passenger_count);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket cancelled successfully.');
    }
}