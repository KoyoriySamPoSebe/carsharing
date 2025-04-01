<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class RentCollection extends ResourceCollection
{
    public function __construct(
        Collection $resource,
        private readonly array $paginationData
    ) {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'list'       => $this->collection->toArray(),
            'pagination' => $this->paginationData,
        ];
    }
}
