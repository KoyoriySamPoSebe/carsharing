<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Rent;
use Illuminate\Database\Seeder;

class RentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['reserve', 'prepare', 'driving', 'parking', 'finished', 'failed'];

        for ($i = 0; $i < 50; $i++) {
            Rent::factory()->create([
                'status' => $statuses[$i % count($statuses)],
            ]);
        }

        Rent::factory()
            ->count(20)
            ->create();

        if ($drivers = Driver::all()) {
            foreach ($drivers as $driver) {
                Rent::factory()
                    ->count(2)
                    ->create([
                        'driver_id' => $driver->id,
                    ]);
            }
        }

        if ($driverIds = Driver::pluck('id')->toArray()) {
            Rent::factory()
                ->count(10)
                ->create([
                    'driver_id' => fn () => fake()->randomElement($driverIds),
                ]);
        }
    }
}
