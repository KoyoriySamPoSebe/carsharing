<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\DriverStatus;
use App\Models\Driver;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    protected $model = Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status'   => DriverStatus::NEW,
            'phone'    => $this->faker->unique()->phoneNumber(),
            'email'    => $this->faker->unique()->safeEmail(),
            'location' => Point::make(
                $this->faker->latitude,
                $this->faker->longitude,
                srid: 4326
            ),
            'password'          => bcrypt('password'),
            'is_blocked'        => false,
            'is_phone_verified' => false,
            'is_email_verified' => false,
        ];
    }

    public function withStatus(DriverStatus $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'            => DriverStatus::APPROVE,
            'is_phone_verified' => true,
            'is_email_verified' => true,
            'approved_at'       => now(),
        ]);
    }
}
