<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type'=>fake()->randomElement(['whole blood', 'blood plasma', 'blood cells']),
            'date'=>fake()->date,
            'confirming_document'=>Str::random(15),
            'user_id'=>User::get()->random()->id,
        ];
    }
}
