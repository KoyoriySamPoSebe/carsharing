<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\RentObserver;
use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $vehicle_id
 * @property string $cost_total
 * @property string $status
 * @property bool $is_allowed_zone_left
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $finished_at
 * @property string|null $location_start
 * @property string|null $location_end
 * @property int|null $driver_id
 * @property-read \App\Models\Driver|null $driver
 * @property-read \App\Models\Vehicle $vehicle
 * @method static \Database\Factories\RentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereCostTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereIsAllowedZoneLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereLocationEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereLocationStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereVehicleId($value)
 * @property string|null $offer_id
 * @property array|null $context
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rent whereOfferId($value)
 * @mixin \Eloquent
 */
#[ObservedBy([RentObserver::class])]
class Rent extends Model
{
    use HasFactory;
    use HasPostgisColumns;

    protected $table = 'rents';

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'offer_id',
        'cost_total',
        'status',
        'is_allowed_zone_left',
        'location_start',
        'location_end',
        'is_active',
        'finished_at',
        'context',
    ];

    protected array $dates = [
        'created_at',
        'updated_at',
        'finished_at',
    ];

    protected $casts = [
        'context'              => 'array',
        'is_allowed_zone_left' => 'boolean',
        'is_active'            => 'boolean',
    ];

    protected array $postgisColumns = [
        'location_start' => [
            'type' => 'geography',
            'srid' => 4326,
        ],
        'location_end' => [
            'type' => 'geography',
            'srid' => 4326,
        ],
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
