<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Http\Requests\VehicleSearchRequest;
use App\Services\VehicleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

final class VehicleController extends Controller
{
    public function __construct(
        private readonly VehicleService $vehicleService
    ) {
    }

    public function index(VehicleSearchRequest $request): View
    {
        $search = $request->getSearch();
        $vehicles = $this->vehicleService->getAll($search);

        return view('vehicles.index', compact('vehicles', 'search'));
    }

    public function create(): View
    {
        return view('vehicles.create');
    }

    public function store(VehicleRequest $request, Redirector $redirect): RedirectResponse
    {
        $data = $request->validated();
        $this->vehicleService->create($data);

        return $redirect->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    public function edit(int $id): View
    {
        $vehicle = $this->vehicleService->getById($id);

        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(VehicleRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        $this->vehicleService->update($id, $data);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->vehicleService->delete($id);

        return redirect()->route('vehicles.index');
    }
}
