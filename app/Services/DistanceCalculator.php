<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
class DistanceCalculator
{
    /**
     * @throws \Exception
     */
    public function calculate(array $addresses): float
    {
        $totalDistance = 0;

        for ($i = 0; $i < count($addresses) - 1; $i++) {
            $origin = $this->formatAddress($addresses[$i]);
            $destination = $this->formatAddress($addresses[$i + 1]);

            $response = Http::get('https://maps.googleapis.com/maps/api/directions/json', [
                'origin' => $origin,
                'destination' => $destination,
                'key' => env('GOOGLE_MAPS_API_KEY'),
            ]);

            if ($response->successful()) {
                $distance = $response->json()['routes'][0]['legs'][0]['distance']['value'] / 1000;
                $totalDistance += $distance;
            } else {
                throw new \Exception('Failed to get data from Google Directions API');
            }
        }

        return $totalDistance;
    }

    private function formatAddress(array $address): string
    {
        return "{$address['city']}, {$address['zip']}, {$address['country']}";
    }
}
