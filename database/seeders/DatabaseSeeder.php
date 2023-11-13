<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BloodType;
use App\Models\Donation;
use App\Models\TransfusionPoint;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $bloodType = ['O(+)', 'A(+)', 'B(+)', 'AB(+)', 'O(-)', 'A(-)', 'B(-)', 'AB(-)'];
        foreach ($bloodType as $item) {
            BloodType::factory()
                ->create([
                    'type' => $item,
                ]);
        }

        $transfusionPoints = TransfusionPoint::factory(30)->create();

        $users = User::factory(100)
            ->hasUserInfo()
            ->create();

        Donation::factory(400)->create();

        foreach ($users as $user) {
            $transfusionPointsId = $transfusionPoints->random(rand(1, 5))->pluck('id');
            $user->transfusionPoints()->attach($transfusionPointsId);
        }

        $bloodTypes = BloodType::all();

        foreach ($transfusionPoints as $item) {
            $bloodTypesId = $bloodTypes->random(rand(7, 8))->pluck('id');
            $item->bloodTypes()->attach($bloodTypesId, ['quantity' => rand(1000, 10000)]);
        }
    }
}
