<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Promo;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = Booking::with(['schedule.trip', 'promo'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $counts = [
            'total'     => Booking::where('user_id', $user->id)->count(),
            'pending'   => Booking::where('user_id', $user->id)->where('status', 'pending')->count(),
            'confirmed' => Booking::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('user_id', $user->id)->where('status', 'cancelled')->count(),
        ];

        return view('bookings.index', compact('bookings', 'counts'));
    }

    public function create(Request $request)
    {
        $query = Schedule::with('trip')
            ->where('status', 'scheduled')
            ->where('departure_at', '>=', now())
            ->orderBy('departure_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('trip', function ($q) use ($search) {
                $q->where('origin_country', 'like', "%{$search}%")
                  ->orWhere('destination_country', 'like', "%{$search}%")
                  ->orWhere('operator', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fare_class')) {
            $query->where('fare_class', $request->fare_class);
        }

        $schedules = $query->limit(50)->get();

        $selectedSchedule = null;
        if ($request->filled('schedule_id')) {
            $selectedSchedule = Schedule::with('trip')->find($request->schedule_id);
        }

        return view('bookings.create', compact('schedules', 'selectedSchedule'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id'     => 'required|exists:schedules,id',
            'passenger_count' => 'required|integer|min:1|max:150',
            'contact_email'   => 'required|email',
            'promo_code'      => 'nullable|string|max:30',
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);

        if ($schedule->available_seats < $validated['passenger_count']) {
            return back()->withErrors(['passenger_count' => 'Not enough seats available.'])->withInput();
        }

        $originalAmount = $schedule->base_fare * $validated['passenger_count'];
        $discountAmount = 0;
        $promoId        = null;

        // ── Promo code validation & discount calculation ──────────────
        if (!empty($validated['promo_code'])) {
            $result = $this->applyPromoCode(
                $validated['promo_code'],
                $originalAmount,
                $schedule->trip_id
            );

            if (!$result['valid']) {
                return back()->withErrors(['promo_code' => $result['message']])->withInput();
            }

            $discountAmount = $result['discount'];
            $promoId        = $result['promo_id'];
        }

        $finalAmount = max(0, $originalAmount - $discountAmount);

        Booking::create([
            'user_id'         => Auth::id(),
            'schedule_id'     => $validated['schedule_id'],
            'reference_no'    => 'BK-' . strtoupper(uniqid()),
            'status'          => 'pending',
            'original_amount' => $originalAmount,
            'discount_amount' => $discountAmount,
            'total_amount'    => $finalAmount,
            'passenger_count' => $validated['passenger_count'],
            'contact_email'   => $validated['contact_email'],
            'expires_at'      => now()->addMinutes(30),
            'promo_id'        => $promoId,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully!' . ($discountAmount > 0 ? ' Promo discount applied.' : ''));
    }

    /**
     * Validate a promo code and calculate the discount.
     * Returns ['valid' => bool, 'discount' => float, 'promo_id' => int|null, 'message' => string]
     */
    private function applyPromoCode(string $code, float $amount, int $tripId): array
    {
        $promo = Promo::where('promo_code', strtoupper($code))->first();

        if (!$promo) {
            return ['valid' => false, 'discount' => 0, 'promo_id' => null, 'message' => 'Promo code not found.'];
        }

        if ($promo->status === 'expired') {
            return ['valid' => false, 'discount' => 0, 'promo_id' => null, 'message' => 'This promo code has expired.'];
        }

        if ($promo->status === 'upcoming') {
            return ['valid' => false, 'discount' => 0, 'promo_id' => null, 'message' => 'This promo code is not active yet. Starts on ' . $promo->start_date->format('M d, Y') . '.'];
        }

        // Check trip applicability
        if (!$promo->applies_to_all) {
            $applicable = $promo->trips()->where('trips.id', $tripId)->exists();
            if (!$applicable) {
                return ['valid' => false, 'discount' => 0, 'promo_id' => null, 'message' => 'This promo code is not valid for the selected trip.'];
            }
        }

        // Calculate discount
        if ($promo->discount_type === 'percentage') {
            $discount = round($amount * ($promo->discount_value / 100), 2);
        } else {
            $discount = min((float) $promo->discount_value, $amount);
        }

        return [
            'valid'    => true,
            'discount' => $discount,
            'promo_id' => $promo->id,
            'message'  => 'Promo applied!',
        ];
    }

    /**
     * AJAX endpoint: validate a promo code and return discount info as JSON.
     */
    public function checkPromo(Request $request)
    {
        $request->validate([
            'promo_code'  => 'required|string',
            'amount'      => 'required|numeric|min:0',
            'trip_id'     => 'required|integer',
        ]);

        $result = $this->applyPromoCode(
            $request->promo_code,
            (float) $request->amount,
            (int) $request->trip_id
        );

        if ($result['valid']) {
            $promo = Promo::where('promo_code', strtoupper($request->promo_code))->first();
            return response()->json([
                'valid'       => true,
                'discount'    => $result['discount'],
                'promo_id'    => $result['promo_id'],
                'label'       => $promo->formatted_discount . ' off',
                'message'     => 'Promo code applied!',
            ]);
        }

        return response()->json(['valid' => false, 'message' => $result['message']], 422);
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        $booking->load(['schedule.trip', 'tickets', 'payment', 'promo']);
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        if ($booking->status === 'cancelled') abort(403);

        $schedules = Schedule::with('trip')
            ->where('status', 'scheduled')
            ->where('departure_at', '>=', now())
            ->orderBy('departure_at')
            ->get();

        return view('bookings.edit', compact('booking', 'schedules'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);

        $availableSeats = $booking->schedule->available_seats;

        $validated = $request->validate([
            'passenger_count' => "required|integer|min:1|max:{$availableSeats}",
            'contact_email'   => 'required|email',
        ], [
            'passenger_count.max' => "Only {$availableSeats} seat(s) available.",
        ]);

        $originalAmount  = $booking->schedule->base_fare * $validated['passenger_count'];
        $discountAmount  = 0;

        // Re-apply existing promo if still valid
        if ($booking->promo_id) {
            $promo = Promo::find($booking->promo_id);
            if ($promo && $promo->status === 'active') {
                if ($promo->discount_type === 'percentage') {
                    $discountAmount = round($originalAmount * ($promo->discount_value / 100), 2);
                } else {
                    $discountAmount = min((float) $promo->discount_value, $originalAmount);
                }
            }
        }

        $booking->update([
            'passenger_count' => $validated['passenger_count'],
            'contact_email'   => $validated['contact_email'],
            'original_amount' => $originalAmount,
            'discount_amount' => $discountAmount,
            'total_amount'    => max(0, $originalAmount - $discountAmount),
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking updated.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('bookings.index')->with('success', 'Booking cancelled.');
    }

    public function pay(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) abort(403);

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Payment is only available after your booking has been approved by an admin.');
        }

        $booking->load(['schedule.trip', 'user']);
        $booking->update(['status' => 'ticketed']);

        $booking->payment()->create([
            'method'          => 'gcash',
            'amount'          => $booking->total_amount,
            'currency'        => 'PHP',
            'status'          => 'paid',
            'attempts'        => 1,
            'transaction_ref' => 'TXN-' . strtoupper(uniqid()),
            'paid_at'         => now(),
        ]);

        if ($booking->schedule) {
            $booking->schedule->decrement('available_seats', $booking->passenger_count);
        }

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

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Payment successful! Your booking is confirmed and ticket(s) have been issued.');
    }

    public function receipt(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        $booking->load(['schedule.trip', 'tickets', 'payment', 'promo']);
        return view('bookings.receipt', compact('booking'));
    }
}