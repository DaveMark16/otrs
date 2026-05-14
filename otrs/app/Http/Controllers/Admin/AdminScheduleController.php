<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Trip;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with('trip');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('trip', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('origin', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%")
                  ->orWhere('operator', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fare_class')) {
            $query->where('fare_class', $request->fare_class);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->orderBy('departure_at', 'asc')->paginate(15)->withQueryString();

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $trips = Trip::where('status', 'active')->orderBy('name')->get();
        return view('admin.schedules.create', compact('trips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id'         => 'required|exists:trips,id',
            'departure_at'    => 'required|date|after:now',
            'arrival_at'      => 'required|date|after:departure_at',
            'capacity'        => 'required|integer|min:1|max:1000',
            'fare_class'      => 'required|in:economy,business,first',
            'base_fare'       => 'required|numeric|min:0',
            'status'          => 'required|in:scheduled,cancelled,completed',
        ]);

        $validated['available_seats'] = $validated['capacity'];

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $trips = Trip::where('status', 'active')->orderBy('name')->get();
        return view('admin.schedules.edit', compact('schedule', 'trips'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'trip_id'         => 'required|exists:trips,id',
            'departure_at'    => 'required|date',
            'arrival_at'      => 'required|date|after:departure_at',
            'capacity'        => 'required|integer|min:1|max:1000',
            'available_seats' => 'required|integer|min:0|max:'.$request->capacity,
            'fare_class'      => 'required|in:economy,business,first',
            'base_fare'       => 'required|numeric|min:0',
            'status'          => 'required|in:scheduled,cancelled,completed',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted.');
    }
}