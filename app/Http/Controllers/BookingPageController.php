<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingPageController extends Controller
{
    public function index(Request $request)
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
                  ->orWhere('origin', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%")
                  ->orWhere('operator', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fare_class')) {
            $query->where('fare_class', $request->fare_class);
        }

        if ($request->filled('origin')) {
            $origin = $request->origin;
            $query->whereHas('trip', function ($q) use ($origin) {
                $q->where('origin_country', 'like', "%{$origin}%")
                  ->orWhere('origin', 'like', "%{$origin}%");
            });
        }

        if ($request->filled('destination')) {
            $dest = $request->destination;
            $query->whereHas('trip', function ($q) use ($dest) {
                $q->where('destination_country', 'like', "%{$dest}%")
                  ->orWhere('destination', 'like', "%{$dest}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('departure_at', $request->date);
        }

        $schedules = $query->limit(60)->get();

        // Stats for the hero
        $totalFlights     = Schedule::where('status', 'scheduled')->where('departure_at', '>=', now())->count();
        $destinations     = Schedule::with('trip')->where('status', 'scheduled')->get()->pluck('trip.destination_country')->unique()->filter()->count();
        $lowestFare       = Schedule::where('status', 'scheduled')->where('departure_at', '>=', now())->min('base_fare');

        return view('booking-page', compact('schedules', 'totalFlights', 'destinations', 'lowestFare'));
    }
}
