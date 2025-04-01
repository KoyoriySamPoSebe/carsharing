<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DriverStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Vehicle>
 * @property int $id
 * @property DriverStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property string $phone
 * @property string $email
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string $password
 * @property bool $is_blocked
 * @property bool $is_phone_verified
 * @property bool $is_email_verified
 * @property int|null $last_rent_id
 * @property int|null $active_rent_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Rent|null $activeRent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DriverDocuments> $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\Rent|null $lastRent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rent> $rents
 * @property-read int|null $rents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Database\Factories\DriverFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereActiveRentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereIsEmailVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereIsPhoneVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereLastRentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver withoutTrashed()
 * @property string|null $location
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Driver whereLocation($value)
 * @mixin \Eloquent
 */
class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'status',
        'phone',
        'email',
        'location',
        'password',
        'is_blocked',
        'is_phone_verified',
        'is_email_verified',
        'last_rent_id',
        'active_rent_id',
    ];

    protected array $postgisColumns = [
        'location' => [
            'type' => 'point',
            'srid' => 4326,
        ],
    ];

    protected $casts = [
        'status'            => DriverStatus::class,
        'approved_at'       => 'datetime',
        'is_blocked'        => 'boolean',
        'is_phone_verified' => 'boolean',
        'is_email_verified' => 'boolean',
        'latitude'          => 'decimal:8',
        'longitude'         => 'decimal:8',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(DriverDocuments::class);
    }

    public function lastRent(): BelongsTo
    {
        return $this->belongsTo(Rent::class, 'last_rent_id');
    }

    public function activeRent(): BelongsTo
    {
        return $this->belongsTo(Rent::class, 'active_rent_id');
    }

    public function vehicles(): HasManyThrough
    {
        return $this->hasManyThrough(
            Vehicle::class,
            Rent::class,
        );
    }

    public function currentVehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function lastVehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function rents(): HasMany
    {
        return $this->hasMany(Rent::class);
    }
}
