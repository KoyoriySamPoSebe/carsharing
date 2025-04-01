<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RentHistoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'driverId' => ['required', 'integer'],
            'status'   => ['sometimes', 'string', Rule::in(['reserve', 'prepare', 'driving', 'parking', 'finished', 'failed'])],
            'limit'    => ['sometimes', 'integer', 'min:1', 'max:100'],
            'offset'   => ['sometimes', 'integer', 'min:0'],
        ];
    }

    public function getDriverId(): int
    {
        return (int) $this->query('driverId');
    }

    public function getStatus(): ?string
    {
        return $this->query('status');
    }

    public function getLimit(): int
    {
        return (int) $this->query('limit', 20);
    }

    public function getOffset(): int
    {
        return (int) $this->query('offset', 0);
    }

    public function messages(): array
    {
        return [
            'driverId.required' => ['Driver ID is required'],
            'driverId.integer'  => ['Driver ID must be an integer'],
            'status.in'         => ['Invalid status value'],
            'limit.integer'     => ['Limit must be an integer'],
            'limit.min'         => ['Limit must be at least 1'],
            'limit.max'         => ['Limit cannot exceed 100'],
            'offset.integer'    => ['Offset must be an integer'],
            'offset.min'        => ['Offset cannot be negative'],

        ];
    }
}
