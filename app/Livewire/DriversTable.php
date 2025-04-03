<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Driver;
use Livewire\Component;
use Livewire\WithPagination;

class DriversTable extends Component
{
    use WithPagination;

    public function render()
    {
        $drivers = Driver::query()
            ->paginate(20);

        return view('livewire.drivers-table', [
            'drivers' => $drivers,
        ]);
    }
}
