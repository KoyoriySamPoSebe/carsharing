<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\RentService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class RentTable extends Component
{
    use WithPagination;

    protected RentService $rentService;

    /**
     * @var array<string, string>
     */
    public array $filters = [
        'vehicleId'      => '',
        'driverId'       => '',
        'status'         => '',
        'isActive'       => '',
        'createdAtFrom'  => '',
        'createdAtTo'    => '',
        'finishedAtFrom' => '',
        'finishedAtTo'   => '',
        'costTotalFrom'  => '',
        'costTotalTo'    => '',
    ];

    public int $perPage = 20;

    public bool $isFiltering = false;

    public function applyFilters(): void
    {
        $this->isFiltering = true;
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->filters = [
            'vehicleId'      => '',
            'driverId'       => '',
            'status'         => '',
            'isActive'       => '',
            'createdAtFrom'  => '',
            'createdAtTo'    => '',
            'finishedAtFrom' => '',
            'finishedAtTo'   => '',
            'costTotalFrom'  => '',
            'costTotalTo'    => '',
        ];
        $this->isFiltering = false;
        $this->resetPage();
    }

    public function boot(RentService $rentService): void
    {
        $this->rentService = $rentService;
    }

    public function render(): View
    {
        $filters = $this->isFiltering ? array_filter($this->filters, fn (string $v): bool => $v !== '') : [];

        return view('livewire.rent-table', [
            'rents' => $this->rentService->listRents($filters, $this->perPage),
        ]);
    }
}
