<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Trip;
use Illuminate\Http\Request;

class AdminPromoController extends Controller
{
    // ── Index ────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Promo::withCount('trips');

        if ($s = $request->search) {
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('promo_code', 'like', "%{$s}%");
            });
        }

        if ($status = $request->status) {
            match ($status) {
                'active'   => $query->active(),
                'expired'  => $query->expired(),
                'upcoming' => $query->upcoming(),
                default    => null,
            };
        }

        $promos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.promos.index', compact('promos'));
    }

    // ── Create ───────────────────────────────────────────────────────
    public function create()
    {
        $trips = Trip::where('status', 'active')->orderBy('origin')->orderBy('destination')->get();
        return view('admin.promos.create', compact('trips'));
    }

    // ── Store ────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'promo_code'     => 'nullable|string|max:20|unique:promos,promo_code',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'applies_to_all' => 'nullable|boolean',
            'trip_ids'       => 'nullable|array',
            'trip_ids.*'     => 'exists:trips,id',
        ]);

        if ($data['discount_type'] === 'percentage' && $data['discount_value'] > 100) {
            return back()->withErrors(['discount_value' => 'Percentage cannot exceed 100.'])->withInput();
        }

        $data['applies_to_all'] = $request->boolean('applies_to_all');

        $promo = Promo::create($data);

        if (!$data['applies_to_all'] && !empty($data['trip_ids'])) {
            $promo->trips()->sync($data['trip_ids']);
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo "' . $promo->title . '" created successfully.');
    }

    // ── Show ─────────────────────────────────────────────────────────
    public function show(Promo $promo)
    {
        $promo->load('trips');
        return view('admin.promos.show', compact('promo'));
    }

    // ── Edit ─────────────────────────────────────────────────────────
    public function edit(Promo $promo)
    {
        $trips = Trip::where('status', 'active')->orderBy('origin')->orderBy('destination')->get();
        $promo->load('trips');
        return view('admin.promos.edit', compact('promo', 'trips'));
    }

    // ── Update ───────────────────────────────────────────────────────
    public function update(Request $request, Promo $promo)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'promo_code'     => 'required|string|max:20|unique:promos,promo_code,' . $promo->id,
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'applies_to_all' => 'nullable|boolean',
            'trip_ids'       => 'nullable|array',
            'trip_ids.*'     => 'exists:trips,id',
        ]);

        if ($data['discount_type'] === 'percentage' && $data['discount_value'] > 100) {
            return back()->withErrors(['discount_value' => 'Percentage cannot exceed 100.'])->withInput();
        }

        $data['applies_to_all'] = $request->boolean('applies_to_all');

        $promo->update($data);

        if ($data['applies_to_all']) {
            $promo->trips()->detach();
        } else {
            $promo->trips()->sync($data['trip_ids'] ?? []);
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo "' . $promo->title . '" updated successfully.');
    }

    // ── Destroy ──────────────────────────────────────────────────────
    public function destroy(Promo $promo)
    {
        $title = $promo->title;
        $promo->trips()->detach();
        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo "' . $title . '" deleted.');
    }
}