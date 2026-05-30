<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingPackage;
use Inertia\Inertia;
use Inertia\Response;

class PricingPackageController extends Controller
{
    /**
     * Display a listing of the pricing packages on dashboard.
     */
    public function index(): Response
    {
        $packages = PricingPackage::orderBy('order_index')
            ->get();

        return Inertia::render('dashboard/PricingPackages', [
            'packages' => $packages,
        ]);
    }

    /**
     * Store a newly created pricing package in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'price' => 'required|string|max:255',
            'slashed_price' => 'nullable|string|max:255',
            'features' => 'required|array',
            'is_popular' => 'required|boolean',
            'wa_text' => 'nullable|string',
            'order_index' => 'required|integer',
        ]);

        PricingPackage::create($validated);

        return redirect()->back();
    }

    /**
     * Update the specified pricing package in database.
     */
    public function update(Request $request, PricingPackage $pricingPackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'price' => 'required|string|max:255',
            'slashed_price' => 'nullable|string|max:255',
            'features' => 'required|array',
            'is_popular' => 'required|boolean',
            'wa_text' => 'nullable|string',
            'order_index' => 'required|integer',
        ]);

        $pricingPackage->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified pricing package from database.
     */
    public function destroy(PricingPackage $pricingPackage)
    {
        $pricingPackage->delete();

        return redirect()->back();
    }
}
