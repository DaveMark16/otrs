<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::withCount('schedules')->where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('origin', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%")
                  ->orWhere('operator', 'like', "%{$search}%")
                  ->orWhere('origin_country', 'like', "%{$search}%")
                  ->orWhere('destination_country', 'like', "%{$search}%");
            });
        }

        if ($request->filled('operator')) {
            $query->where('operator', $request->operator);
        }

        if ($request->filled('country')) {
            $query->where(function ($q) use ($request) {
                $q->where('origin_country', $request->country)
                  ->orWhere('destination_country', $request->country);
            });
        }

        $trips = $query->latest()->paginate(15)->withQueryString();

        $operators = Trip::where('status', 'active')
            ->whereNotNull('operator')
            ->distinct()->pluck('operator')->sort()->values();

        $countries = Trip::where('status', 'active')
            ->whereNotNull('origin_country')
            ->get()
            ->flatMap(fn($t) => [$t->origin_country, $t->destination_country])
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $totalTrips     = Trip::where('status', 'active')->count();
        $totalOperators = $operators->count();
        $totalCountries = $countries->count();

        return view('schedules.index', compact(
            'trips',
            'operators',
            'countries',
            'totalTrips',
            'totalOperators',
            'totalCountries'
        ));
    }

    public function show(Trip $trip)
    {
        $trip->load(['schedules' => function ($q) {
            $q->where('status', 'scheduled')
              ->where('departure_at', '>=', now())
              ->orderBy('departure_at');
        }]);

        return view('schedules.show', compact('trip'));
    }
}
