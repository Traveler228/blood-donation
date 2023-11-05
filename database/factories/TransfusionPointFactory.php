<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransfusionPoint>
 */
class TransfusionPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city'=>fake()->city,
            'full_address'=>fake()->address,
            'geolocation'=>json_encode(['location' => ['x', 'y']]),
        ];
    }
}
