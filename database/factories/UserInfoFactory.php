<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_honorary' => fake()->date,
            'blood_type' => fake()->randomElement(['O(+)', 'A(+)', 'B(+)', 'AB(+)', 'O(-)', 'A(-)', 'B(-)', 'AB(-)']),
            'city' => fake()->city,
//            'user_id' => User::factory(),
        ];
    }
}
