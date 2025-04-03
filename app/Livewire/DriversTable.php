<?php

namespace App\Livewire;

use App\Models\Driver;
use Livewire\Component;
use Livewire\WithPagination;

class DriversTable extends Component
{
    use WithPagination;

    // Закомментированные фильтры
    /*
    public array $filters = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'isActive' => '',
    ];

    public int $perPage = 20;

    public function applyFilters(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->filters = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'isActive' => '',
        ];
        $this->resetPage();
    }
    */

    public function render()
    {
        $drivers = Driver::query()
            // Закомментированные условия фильтрации
            /*
            ->when($this->filters['name'], fn($query, $name) => $query->where('name', 'like', "%$name%"))
            ->when($this->filters['email'], fn($query, $email) => $query->where('email', 'like', "%$email%"))
            ->when($this->filters['phone'], fn($query, $phone) => $query->where('phone', 'like', "%$phone%"))
            ->when($this->filters['isActive'], fn($query, $isActive) => $query->where('is_active', $isActive))
            */
            ->paginate(20);

        return view('livewire.drivers-table', [
            'drivers' => $drivers,
        ]);
    }
}
