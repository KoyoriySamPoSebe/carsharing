<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RentRequest;
use App\Services\RentService;
use Illuminate\View\View;

final class RentController extends Controller
{
    public function __construct(private readonly RentService $rentService)
    {
    }

    public function index(RentRequest $request): View
    {
        $filters = $request->validated();

        $perPage = $request->get('perPage', 20);

        $rents = $this->rentService->listRents($filters, $perPage);

        return view('rents.index', compact('rents', 'filters'));
    }
}
