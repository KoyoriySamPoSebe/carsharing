<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $driver_id
 * @property DocumentType $type
 * @property string $link
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Driver $driver
 * @method static \Database\Factories\DriverDocumentsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverDocuments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DriverDocuments extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'type',
        'link',
        'comment',
    ];

    protected $casts = [
        'type' => DocumentType::class,
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
