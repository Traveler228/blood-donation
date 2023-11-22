<?php

namespace Database\Factories;

use App\Models\DonationType;
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
            'type_id' => DonationType::get()->random()->id,
            'date'=> fake()->date,
            'confirming_document'=> fake()->unique()->asciify('***************'),
            'user_id'=> User::get()->random()->id,
        ];
    }
}
