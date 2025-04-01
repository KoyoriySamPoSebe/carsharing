<?php

declare(strict_types=1);

namespace App\DTO;

use Clickbar\Magellan\Data\Geometries\Point;

readonly class CreateRentDTO
{
    public function __construct(
        public int $vehicleId,
        public int $driverId,
        public Point $locationStart,
        public string $offerId,
        public array $context
    ) {
    }
}
