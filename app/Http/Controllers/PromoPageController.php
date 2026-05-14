<?php

namespace App\Http\Controllers;

use App\Models\Promo;

class PromoPageController extends Controller
{
    public function index()
    {
        $promos = Promo::active()
            ->with('trips')
            ->orderBy('end_date')
            ->get();

        return view('promos.index', compact('promos'));
    }
}
