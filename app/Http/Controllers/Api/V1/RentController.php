<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeRentStatusRequest;
use App\Http\Requests\CreateRentRequest;
use App\Http\Requests\RentHistoryRequest;
use App\Http\Resources\RentCollection;
use App\Http\Resources\RentResource;
use App\Services\RentService;

class RentController extends Controller
{
    public function __construct(
        private readonly RentService $rentService,
    ) {
    }

    public function create(CreateRentRequest $request): RentResource
    {
        $rent = $this->rentService->createRent($request->getDto());

        return new RentResource($rent);
    }

    /**
     * @throws \Exception
     */
    public function changeStatus(ChangeRentStatusRequest $request): RentResource
    {
        $rent = $this->rentService->changeStatus(
            $request->getRentId(),
            $request->getTargetStatus()
        );

        return new RentResource($rent);
    }

    public function history(RentHistoryRequest $request): RentCollection
    {
        $paginator = $this->rentService->getHistory(
            $request->getDriverId(),
            $request->getStatus(),
            $request->getLimit(),
            $request->getOffset()
        );

        return new RentCollection(
            $paginator->getCollection(),
            [
                'total'  => $paginator->total(),
                'limit'  => $request->getLimit(),
                'offset' => $request->getOffset(),
            ]
        );
    }
}
