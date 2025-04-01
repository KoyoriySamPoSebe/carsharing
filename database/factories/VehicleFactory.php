<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Vehicle;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number'                => $this->faker->regexify('[A-Z]{2}-[0-9]{3}-[A-Z]'),
            'vin'                   => strtoupper($this->faker->regexify('[A-Z0-9]{17}')),
            'is_clean'              => $this->faker->boolean,
            'is_available_for_rent' => $this->faker->boolean,
            'is_door_opened'        => $this->faker->boolean,
            'is_in_parking'         => $this->faker->boolean,
            'rating'                => $this->faker->numberBetween(1, 5),
            'fuel_in_tank'          => $this->faker->numberBetween(0, 100),
            'location'              => Point::make(
                $this->faker->latitude,
                $this->faker->longitude,
                srid: 4326
            ),
        ];
    }
}
