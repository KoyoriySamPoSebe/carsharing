<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use App\Traits\GeographicPoints;
use Illuminate\Database\Eloquent\Collection;

final readonly class VehicleService
{
    use GeographicPoints;

    public function __construct(
        private VehicleRepository $repository
    ) {
    }

    public function getAll(?string $search = null): Collection
    {
        return $this->repository->getAll($search);
    }

    public function create(array $data): Vehicle
    {
        if (isset($data['location'])) {
            $data['location'] = $this->validateAndCreatePoint($data['location']);
        }

        return $this->repository->create($data);
    }

    public function getById(int $id): Vehicle
    {
        return $this->repository->getById($id);
    }

    public function update(int $id, array $data): void
    {
        if (isset($data['location'])) {
            $data['location'] = $this->validateAndCreatePoint($data['location']);
        }

        $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
