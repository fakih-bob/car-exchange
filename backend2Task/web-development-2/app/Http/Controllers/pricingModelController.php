<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Pricing_model;

class pricingModelController extends Controller
{
    public function showForm()
    {
        $drivers = Driver::all(); // Optional: allow selecting driver
        return view('client.calculate_price', compact('drivers'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'distance' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'length' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        $pricing = Pricing_model::where('driver_id', $request->driver_id)->first();

        if (!$pricing) {
            return back()->with('error', 'Pricing model not found for selected driver.');
        }

        $volume = $request->height * $request->width * $request->length;
        $volumeCharge = $volume * $pricing->per_volume_rate;
        $weightCharge = $request->weight * $pricing->per_weight_rate;

        if ($request->distance <= $pricing->short_distance_limit) {
            $distanceCharge = $pricing->short_distance_price;
        } else {
            $distanceCharge = $request->distance * $pricing->long_distance_rate;
        }

        $total = $distanceCharge + $volumeCharge + $weightCharge;

        return back()->with('total', $total)->withInput();
    }
}
