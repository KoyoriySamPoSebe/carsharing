<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CreateRentDTO;
use App\Models\Rent;
use App\Repositories\RentRepository;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class RentService
{
    public function __construct(
        private RentRepository $rentRepository,
    ) {
    }

    public function listRents($filters = [], $perPage = 20): LengthAwarePaginator
    {
        return $this->rentRepository->getAllRents($filters, $perPage);
    }

    public function createRent(CreateRentDTO $dto): Rent
    {
        return $this->rentRepository->create($dto);
    }

    /**
     * @throws Exception
     */
    public function changeStatus(int $rentId, string $targetStatus): Rent
    {
        return $this->rentRepository->updateStatus($rentId, $targetStatus);
    }

    public function getHistory(int $driverId, ?string $status, int $limit, int $offset): LengthAwarePaginator
    {
        return $this->rentRepository->getHistory($driverId, $status, $limit, $offset);
    }
}
