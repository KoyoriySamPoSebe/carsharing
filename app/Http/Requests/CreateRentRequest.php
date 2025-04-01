<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\CreateRentDTO;
use App\Traits\GeographicPoints;
use Illuminate\Foundation\Http\FormRequest;

class CreateRentRequest extends FormRequest
{
    use GeographicPoints;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicleId' => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],
            'driverId' => [
                'required',
                'integer',
                'exists:drivers,id',
            ],
            'offerId' => [
                'required',
                'string',
            ],
            'locationStart' => [
                'required',
                'string',
                'regex:/^\d+\.\d+,\s*\d+\.\d+$/',
            ],
            'context' => [
                'required',
                'array',
            ],
        ];
    }

    public function getDto(): CreateRentDTO
    {
        return new CreateRentDTO(
            $this->input('vehicleId'),
            $this->input('driverId'),
            $this->validateAndCreatePoint($this->input('locationStart')),
            $this->input('offerId'),
            $this->input('context'),
        );
    }
}
