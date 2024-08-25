<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransportFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Basic dGVzdDMzMzoyMmNiZWVkMmJjMTkyMDhhMzA5YzEyZTg2NDc0NzMyNTFmOTlkMGM2MTNjNjViYTM0NDJmMzhjYzcwYzljMGQ4NDU0YzIwMGMyM2UyMzdmYTVhZDVjYzUxMWRjNTNjN2ExNzM1NDhlZTEzM2RkMjA5OTI4ZWFkNDlkMmRl',
        ])->postJson('/api/calculate-price', [
            'addresses' => [
                [
                    'country' => 'DE',
                    'zip' => '40210',
                    'city' => 'Düsseldorf'
                ],
                [
                    'country' => 'DE',
                    'zip' => '01067',
                    'city' => 'Dresden'
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['vehicle_type', 'price']
        ]);
    }
}
