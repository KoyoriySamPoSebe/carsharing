<?php

declare(strict_types=1);

namespace App\Models;

use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $number
 * @property string|null $vin
 * @property bool $is_clean
 * @property bool $is_available_for_rent
 * @property bool $is_door_opened
 * @property bool $is_in_parking
 * @property int $rating
 * @property int $fuel_in_tank
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $location
 * @property-read \App\Models\Driver|null $currentDriver
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Driver> $drivers
 * @property-read int|null $drivers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rent> $rents
 * @property-read int|null $rents_count
 * @method static \Database\Factories\VehicleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereFuelInTank($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereIsAvailableForRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereIsClean($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereIsDoorOpened($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereIsInParking($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle withoutTrashed()
 * @mixin \Eloquent
 */
class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasPostgisColumns;

    protected $fillable = [
        'number',
        'vin',
        'is_clean',
        'is_available_for_rent',
        'is_door_opened',
        'is_in_parking',
        'rating',
        'fuel_in_tank',
        'location',
    ];

    protected array $postgisColumns = [
        'location' => [
            'type' => 'geography',
            'srid' => 4326,
        ],
    ];

    public function rents(): HasMany
    {
        return $this->hasMany(Rent::class);
    }

    public function drivers(): HasManyThrough
    {
        return $this->hasManyThrough(
            Driver::class,
            Rent::class,
        );
    }

    public function currentDriver(): HasOneThrough
    {
        return $this->hasOneThrough(
            Driver::class,
            Rent::class,
            'vehicle_id',
            'active_rent_id',
            'id',
            'id'
        );
    }
}
