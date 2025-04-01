<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user'           => ['nullable', 'string', 'max:255'],
            'vehicle'        => ['nullable', 'string', 'max:255'],
            'isActive'       => ['nullable', 'boolean'],
            'status'         => ['nullable', 'string', 'max:120'],
            'createdAtFrom'  => ['nullable', 'date'],
            'createdAtTo'    => ['nullable', 'date'],
            'finishedAtFrom' => ['nullable', 'date'],
            'finishedAtTo'   => ['nullable', 'date'],
            'costTotalFrom'  => ['nullable', 'numeric'],
            'costTotalTo'    => ['nullable', 'numeric'],
            'perPage'        => ['nullable', 'in:20,40,60'],
            'location_start' => ['nullable', 'string', 'regex:/^-?\d+\.?\d*,\s*-?\d+\.?\d*$/'],
            'location_end'   => ['nullable', 'string', 'regex:/^-?\d+\.?\d*,\s*-?\d+\.?\d*$/'],

        ];
    }
}
