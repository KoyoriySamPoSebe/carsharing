<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Rent;
use App\Models\Vehicle;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rent>
 */
class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Rent::class;

    public function definition(): array
    {
        $statuses = ['reserve', 'prepare', 'driving', 'parking', 'finished', 'failed'];
        $hasEndLocation = $this->faker->boolean(70);

        return [
            'vehicle_id'           => Vehicle::factory(),
            'driver_id'            => Driver::factory(),
            'cost_total'           => $this->faker->randomFloat(2, 100, 1000),
            'status'               => $statuses[array_rand($statuses)],
            'is_allowed_zone_left' => $this->faker->boolean,
            'is_active'            => $this->faker->boolean,
            'finished_at'          => $this->faker->optional()->dateTime,
            'location_start'       => Point::make(
                $this->faker->latitude,
                $this->faker->longitude,
                srid: 4326
            ),
            'location_end' => $hasEndLocation ? Point::make(
                $this->faker->latitude,
                $this->faker->longitude,
                srid: 4326
            ) : null,
        ];
    }

    public function withoutDriver(): static
    {
        return $this->state(fn (array $attributes) => [
            'driver_id' => null,
        ]);
    }

    public function withRandomDriver(): static
    {
        return $this->state(function (array $attributes) {
            $driverIds = Driver::pluck('id')->toArray();

            return [
                'driver_id' => !empty($driverIds) ? fake()->randomElement($driverIds) : null,
            ];
        });
    }
}
