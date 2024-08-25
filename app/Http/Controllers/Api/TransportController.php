<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculatePriceRequest;
use App\Models\VehicleType;
use App\Services\DistanceCalculator;

class TransportController extends Controller
{
    protected DistanceCalculator $distanceCalculator;

    public function __construct(DistanceCalculator $distanceCalculator)
    {
        $this->distanceCalculator = $distanceCalculator;
    }

    /**
     * @throws \Exception
     */
    public function calculatePrice(CalculatePriceRequest $request)
    {
        $data = $request->validated();

        try {
            $distance = $this->distanceCalculator->calculate($data['addresses']);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

        $prices = $this->calculateVehiclePrices($distance);
        return response()->json($prices);
    }
    private function calculateVehiclePrices(float $distance): array
    {
        $vehicleTypes = VehicleType::all();
        $prices = [];
        foreach ($vehicleTypes as $vehicle) {
            $price = max($distance * $vehicle->cost_km, $vehicle->minimum);
            $prices[] = [
                'vehicle_type' => $vehicle->number,
                'price' => number_format($price, 2, '.', '')
            ];
        }
        return $prices;
    }
}
