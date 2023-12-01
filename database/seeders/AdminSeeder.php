<?php

namespace Database\Seeders;

use App\Models\BloodType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'surname' => 'admin',
            'name' => 'admin',
            'patronymic' => null,
            'date_of_birth' => null,
            'city' => null,
            'is_honorary' => null,
            'blood_id' => null,
            'login' => 'admin',
            'email' =>  'admin@mail.ru',
            'role' =>  User::ROLE[0],
            'password' => Hash::make('admin'),
        ]);
    }
}
