<?php

declare(strict_types=1);

namespace App\Traits;

use Clickbar\Magellan\Data\Geometries\Point;
use InvalidArgumentException;

trait GeographicPoints
{
    /**
     * @throws InvalidArgumentException
     */
    private function validateAndCreatePoint(mixed $location): Point
    {
        if (!is_string($location)) {
            throw new InvalidArgumentException('Location must be a string in format "latitude,longitude"');
        }

        $coordinates = array_map('trim', explode(',', $location));

        if (count($coordinates) !== 2) {
            throw new InvalidArgumentException('Location must contain exactly two coordinates');
        }

        if (!is_numeric($coordinates[0]) || !is_numeric($coordinates[1])) {
            throw new InvalidArgumentException('Coordinates must be numeric values');
        }

        $latitude = (float) $coordinates[0];
        $longitude = (float) $coordinates[1];

        if ($latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException('Latitude must be between -90 and 90 degrees');
        }

        if ($longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException('Longitude must be between -180 and 180 degrees');
        }

        return Point::make(
            $latitude,
            $longitude,
            srid: 4326
        );
    }
}
