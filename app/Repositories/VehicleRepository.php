<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

final readonly class VehicleRepository
{
    public function __construct(
        private Builder $builder
    ) {
    }

    public function getAll(?string $search = null): Collection
    {
        $query = $this->builder->newQuery();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%$search%")
                    ->orWhere('vin', 'like', "%$search%");
            });
        }

        return $query->get();
    }

    public function create(array $data): Vehicle
    {
        /** @var Vehicle */
        return $this->builder->newQuery()->create($data);
    }

    public function getById(int $id): Vehicle
    {
        /** @var Vehicle */
        return $this->builder->newQuery()->findOrFail($id);
    }

    public function update(int $id, array $data): void
    {
        $updated = $this->builder->newQuery()->where('id', $id)->update($data);

        if (!$updated) {
            throw new InvalidArgumentException("Vehicle with ID: $id not found");
        }
    }

    public function delete(int $id): void
    {
        $this->builder->newQuery()->where('id', $id)->delete();
    }
}
