<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\VehicleService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class VehicleIndex extends Component
{
    use WithPagination;

    public string $searchValue = '';

    protected VehicleService $vehicleService;

    public function boot(VehicleService $vehicleService): void
    {
        $this->vehicleService = $vehicleService;
    }

    public function delete(int $id): void
    {
        $this->vehicleService->delete($id);

        session()->flash('success', 'Vehicle deleted.');
    }

    public function render(): View
    {
        $vehicles = $this->vehicleService->getAll($this->searchValue);

        return view('livewire.vehicle-index', [
            'vehicles' => $vehicles,
        ]);
    }
}
