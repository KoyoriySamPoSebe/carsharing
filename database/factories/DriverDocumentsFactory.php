<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\DocumentType;
use App\Models\Driver;
use App\Models\DriverDocuments;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DriverDocuments>
 */
class DriverDocumentsFactory extends Factory
{
    protected $model = DriverDocuments::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'driver_id' => Driver::factory(),
            'type'      => $this->faker->randomElement(DocumentType::cases()),
            'link'      => $this->faker->imageUrl(),
            'comment'   => $this->faker->optional()->sentence(),
        ];
    }
}
