<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\CreateRentDTO;
use App\Models\Rent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class RentRepository
{
    public function __construct(private Builder $builder)
    {
    }

    public function getAllRents($filters = [], $perPage = 20): LengthAwarePaginator
    {
        $query = $this->builder->newQuery();

        if (isset($filters['driver'])) {
            $query->where('driver_id', $filters['driver']);
        }

        if (isset($filters['vehicle'])) {
            $query->where('vehicle_id', $filters['vehicle']);
        }

        if (isset($filters['isActive'])) {
            $query->where('is_active', $filters['isActive']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['createdAtFrom'])) {
            $query->whereDate('created_at', '>=', $filters['createdAtFrom']);
        }

        if (isset($filters['createdAtTo'])) {
            $query->whereDate('created_at', '<=', $filters['createdAtTo']);
        }

        if (array_key_exists('finishedAtFrom', $filters)) {
            $query->whereDate('finished_at', '>=', $filters['finishedAtFrom']);
        }

        if (array_key_exists('finishedAtTo', $filters)) {
            $query->whereDate('finished_at', '<=', $filters['finishedAtTo']);
        }

        if (array_key_exists('costTotalFrom', $filters)) {
            $query->where('cost_total', '>=', (float) $filters['costTotalFrom']);
        }

        if (array_key_exists('costTotalTo', $filters)) {
            $query->where('cost_total', '<=', (float) $filters['costTotalTo']);
        }

        return $query->paginate($perPage);
    }

    public function create(CreateRentDTO $dto): Rent
    {
        /** @var Rent */
        return $this->builder->create([
            'vehicle_id'           => $dto->vehicleId,
            'driver_id'            => $dto->driverId,
            'offer_id'             => $dto->offerId,
            'location_start'       => $dto->locationStart,
            'context'              => $dto->context,
            'status'               => 'reserve',
            'is_active'            => true,
            'is_allowed_zone_left' => false,
            'cost_total'           => 0,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function updateStatus(int $rentId, string $status): Rent
    {
        $res = $this->builder
            ->newQuery()
            ->where('id', $rentId)
            ->update(['status' => $status]);

        if ($res === 0) {
            throw new \Exception('Failed to update rent status');
        }

        /** @var Rent */
        return $this->builder->newQuery()->findOrFail($rentId);
    }

    public function getHistory(int $driverId, ?string $status, int $limit, int $offset): LengthAwarePaginator
    {
        $query = $this->builder->newQuery()
            ->where('driver_id', $driverId);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate(
            perPage: $limit,
            page: floor($offset / $limit) + 1
        );
    }
}
